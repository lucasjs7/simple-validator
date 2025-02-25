<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
use Lucasjs7\SimpleCliTable;
use Lucasjs7\SimpleValidator\Language\{Language, eLanguage};
use Lucasjs7\SimpleValidator\Type\Attribute\Attribute;
use Lucasjs7\SimpleValidator\Type\TypeBase;

abstract class Core {

    public static eMode $mode = eMode::PRODUCTION;

    protected array  $path = [];
    protected string $errorMsg  = '';
    protected bool   $exception = true;

    public bool             $errorImplementation = false;
    public static eLanguage $language;

    public function __construct() {
        if (empty(self::$language)) {
            Language::defaultLang();
        }
    }

    protected function setPath(array $value): void {
        $this->path = $value;
    }

    protected function setError(
        string  $message,
        array   $errorPath = [],
        ?string $label     = null,
    ): void {

        $lngField        = ($label !== null) ? Language::get('field', ['label' => $label]) : '';
        $fieldIdentified = (($label !== null) && str_starts_with($message, $lngField));

        $lngPath        = Language::get('path');
        $pathIdentified = str_contains($message, "($lngPath:");

        if (!$fieldIdentified && !$pathIdentified) {

            $hasLabel     = ($label !== null);
            $dataPath     = array_merge($this->path, $errorPath);
            $hasErrorPath = !empty($dataPath);
            $fmtMessage   = rtrim($message, '. ');

            if ($hasLabel) {
                $this->errorMsg = "$lngField $fmtMessage.";
            } elseif ($hasErrorPath) {
                $ePath = implode(' > ', $dataPath);
                $this->errorMsg = "$fmtMessage ($lngPath: $ePath).";
            } else {
                $this->errorMsg = "$fmtMessage.";
            }
        } else {
            $this->errorMsg = $message;
        }

        if ($this->exception) {
            throw new ValidatorException(
                message: $this->errorMsg,
                errorPath: $errorPath,
            );
        }
    }

    public function getError(): string {
        return $this->errorMsg;
    }

    public static function genHeaderError(
        string $title,
    ): string {
        return "SimpleValidator - $title";
    }

    public static function exitError(
        string             $title,
        string             $message,
        Exception          $exception,
        bool               $backtrace,
        ?SimpleCliTable ...$tables,
    ): void {

        self::logFile($title, $message, $exception);

        if (static::$mode === eMode::DEBUG) {

            $noCli = (php_sapi_name() !== 'cli');
            $headerData = [
                [self::genHeaderError($title)],
                [$message],
            ];

            if ($noCli) {
                echo '<pre>';
            }

            echo SimpleCliTable::build($headerData, true) . "\n";

            foreach ($tables as $table) {
                if ($table === null) continue;

                echo $table->render() . "\n";
            }

            if ($backtrace) {
                $trace = $exception->getTrace();
                $lastTrace = (array_key_last($trace));
                $bkTable = new SimpleCliTable;

                $bkTable->setContainsHeader(true);
                $bkTable->add(['', 'Backtrace', 'Function', 'Args']);

                for ($i = $lastTrace, $n = 1; $i > 0; $i--, $n++) {
                    $traceFile     = $trace[$i]['file'] ?? '-';
                    $traceLine     = $trace[$i]['line'] ?? '-';
                    $traceFunction = $trace[$i]['function'] ?? '';
                    $traceArgs     = $trace[$i]['args'] ?? '';

                    $bkTable->add([
                        "#$n",
                        "$traceFile:$traceLine",
                        $traceFunction,
                        json_encode($traceArgs),
                    ]);
                }

                echo $bkTable->render();
            }

            if ($noCli) {
                echo '</pre>';
            }

            exit;
        }
    }

    public function attrError(
        Attribute $attr,
        string    $errorMessage,
    ): void {
        $titleHeader = 'Attribute Error';
        $attrTable = new SimpleCliTable;

        $attrTable->setContainsHeader(true);
        $attrTable->add(['Attribute', 'Value', 'Error']);

        foreach ($attr as $kAttr => $vAttr) {
            $attrValeu = match (gettype($vAttr->getValue())) {
                'array', 'object' => json_encode($vAttr->getValue()),
                'NULL'            => '',
                default           => $vAttr->getValue(),
            };

            $attrTable->add([
                $kAttr,
                $attrValeu,
                $vAttr->getError() ? '*' : '',
            ]);
        }

        $this->exitError(
            title: $titleHeader,
            message: $errorMessage,
            exception: new Exception,
            backtrace: true,
            tables: $attrTable,
        );

        $this->errorImplementation = true;
    }

    public static function logFile(
        string    $title,
        string    $message,
        Exception $exception,
    ): void {
        $fileErrorLog = ini_get('error_log');

        if (empty($fileErrorLog)) return;

        $strTrace   = $exception->getTraceAsString();
        $logMessage = "$title: $message\n$strTrace\n";

        error_log($logMessage, 3, $fileErrorLog);
    }

    public static function name(): string {
        $name = trim(substr(static::class, (strrpos(static::class, '\\') + 1)), '_');
        return strtolower($name);
    }

    public static function isEmpty(
        mixed $value,
    ): bool {
        return ($value === null);
    }

    public function isRequired(): bool {

        if ($this instanceof TypeBase) {
            if ($this->getAttr()->required->getValue()) {
                return true;
            }
        } elseif ($this instanceof Struct) {
            foreach ($this->structure as $stcVal) {
                if ($stcVal->isRequired()) {
                    return true;
                }
            }
        } elseif ($this instanceof Map || $this instanceof Slice) {
            if ($this->typeValues->isRequired()) {
                return true;
            }
        }

        return false;
    }

    public function errorImplementation(): bool {

        if ($this->errorImplementation) {
            return true;
        } elseif ($this instanceof Struct) {
            foreach ($this->structure as $stcVal) {
                if ($stcVal->errorImplementation()) {
                    return true;
                }
            }
        } elseif ($this instanceof Map) {
            if ($this->typeKeys->errorImplementation()) {
                return true;
            } elseif ($this->typeValues->errorImplementation()) {
                return true;
            }
        } elseif ($this instanceof Slice) {
            if ($this->typeValues->errorImplementation()) {
                return true;
            }
        }

        return false;
    }
}
