<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\Type\Attribute\Attribute;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

abstract class TypeBase extends Core implements iTypeBase {

    public readonly Attribute $attr;

    public function __construct(
        ?string $label = null,
    ) {
        parent::__construct();

        $this->attr = new Attribute;
        $this->attr->label->setValue($label);
    }

    public function validate(
        mixed $value,
        bool  $exception = true,
        bool  $selfField = true,
    ): bool {

        $isEmpty = $selfField ? static::isEmpty($value) : false;

        try {
            $this->exception = $exception;
            $this->errorMsg  = '';

            if ($this->errorImplementation() || $this->verifyConflicts()) {
                $this->setError(Lng::get('implementation'));
                return false;
            }

            if ($isEmpty) {

                if (!$this->attr->required->getValue()) {
                    return true;
                }

                throw new Exception(
                    message: Lng::get('type.type_base.required'),
                );
            } elseif (!$this->typeValidate($value)) {

                if ($this->errorImplementation()) {
                    throw new Exception(Lng::get('implementation'));
                }

                $msgError = $this->getError();

                if (empty($msgError)) {
                    $descType = Lng::get("type.desc_type_{$this->name()}");
                    $msgError = Lng::get('type.type_base.type', ['type' => $descType]);
                }

                throw new Exception($msgError);
            }

            $this->attrsValidate($value);

            if ($this->errorImplementation()) {
                throw new Exception(Lng::get('implementation'));
            }

            return true;
        } catch (Exception $e) {

            $this->setError(
                message: $e->getMessage(),
                label: $this->attr->label->getValue(),
            );
            return false;
        }
    }

    protected function verifyConflicts(): bool {

        if (!$this->checkAttributes()) {

            foreach ($this->attr as $nameAttr => $attribute) {
                if ($nameAttr != 'required' && $attribute->getValue() !== null) {
                    $attribute->setError(true);
                }
            }

            $this->attrError(
                attr: $this->attr,
                errorMessage: Lng::get('type.type_base.conflict'),
            );

            return true;
        }

        return false;
    }

    protected function checkAttributes(): bool {
        $emptyRegex    = self::isEmpty($this->attr->regex->getValue());
        $emptyMax      = self::isEmpty($this->attr->max->getValue());
        $emptyMin      = self::isEmpty($this->attr->min->getValue());
        $emptyOptions  = self::isEmpty($this->attr->options->getValue());
        $emptyFormat   = self::isEmpty($this->attr->format->getValue());
        $emptyUnsigned = self::isEmpty($this->attr->unsigned->getValue());
        $emptyCallable = self::isEmpty($this->attr->callable->getValue());

        $countGroups = 0;

        $countGroups += (int) (!$emptyRegex);
        $countGroups += (int) (!$emptyMax || !$emptyMin || !$emptyUnsigned);
        $countGroups += (int) (!$emptyOptions);
        $countGroups += (int) (!$emptyFormat);
        $countGroups += (int) (!$emptyCallable);

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

            if ($v === null || $k === 'callable') {
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
