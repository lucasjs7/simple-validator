<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\Type\Attribute\AttrError;
use Lucasjs7\SimpleValidator\Type\Attribute\Attribute;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

abstract class TypeBase extends Core implements iTypeBase {

    public readonly Attribute $attr;

    public function __construct(
        ?string $label = null,
    ) {
        $this->attr = new Attribute;
        $this->attr->label->setValue($label);
    }

    public static function isEmpty(
        mixed $value,
    ): bool {
        return ($value === null || $value === [] || (is_string($value) && trim($value) === ''));
    }

    public function validate(
        mixed $value,
        bool $exception = true,
    ): bool {
        $isEmpty = self::isEmpty($value);

        try {
            $this->exception = $exception;
            $this->verifyConflicts();

            if ($this->attr->required->getValue() && $isEmpty) {
                throw new Exception(
                    message: Lng::get('type.type_base.required'),
                );
            } elseif (!$this->typeValidate($value)) {
                $descType = Lng::get("type.desc-type-{$this->name()}");

                throw new Exception(
                    message: Lng::get('type.type_base.type', ['type' => $descType]),
                );
            }

            $this->attrsValidate($value);

            return true;
        } catch (Exception $e) {
            if ($this->attr->required->getValue() || !$isEmpty) {
                $this->setError(
                    message: $e->getMessage(),
                    label: $this->attr->label->getValue(),
                );
                return false;
            }

            return true;
        }
    }

    protected function verifyConflicts(): void {
        if (!$this->checkAttributes()) {
            foreach ($this->attr as $nameAttr => $attribute) {
                if ($nameAttr != 'required' && $attribute->getValue() !== null) {
                    $attribute->setError(true);
                }
            }

            AttrError::buildError(
                attr: $this->attr,
                errorMessage: Lng::get('type.type_base.conflict'),
            );
        }
    }

    protected function checkAttributes(): bool {
        $emptyRegex    = self::isEmpty($this->attr->regex->getValue());
        $emptyMax      = self::isEmpty($this->attr->max->getValue());
        $emptyMin      = self::isEmpty($this->attr->min->getValue());
        $emptyOptions  = self::isEmpty($this->attr->options->getValue());
        $emptyFormat   = self::isEmpty($this->attr->format->getValue());
        $emptyUnsigned = self::isEmpty($this->attr->unsigned->getValue());

        $countGroups = 0;

        $countGroups += (int) (!$emptyRegex);
        $countGroups += (int) (!$emptyMax || !$emptyMin || !$emptyUnsigned);
        $countGroups += (int) (!$emptyOptions);
        $countGroups += (int) (!$emptyFormat);

        $invalidGroups = 0;

        $invalidGroups += (int) (!$emptyUnsigned && !$emptyMin);

        $noGroupUsed = ($countGroups == 0);
        $validGroups = ($countGroups == 1 && $invalidGroups == 0);

        return ($noGroupUsed || $validGroups);
    }

    public function info(): string {
        $rtn = $listAttr = [];

        $class = trim(substr(static::class, strrpos(static::class, '\\') + 1), '_');
        $rtn[] = 'type: ' . strtolower($class);

        foreach ($this->attr as $name => $value) {
            $listAttr[$name] = $value->getValue();
        }

        foreach ($listAttr as $k => $v) {
            if ($v === null) {
                continue;
            }

            $rtn[] = $k . ': ' . match (gettype($v)) {
                'boolean' => ($v ? 'true' : 'false'),
                'array'   => implode(', ', $v),
                default   => $v,
            };
        }

        return implode(' | ', $rtn);
    }

    public function label(
        string $value,
    ): static {
        $this->attr->label->setValue($value);

        return $this;
    }

    public static function new(
        ?string $label = null,
    ): static {
        return new static($label);
    }

    public function required(
        bool $value = true,
    ): static {
        $this->attr->required->setValue($value);
        return $this;
    }
}
