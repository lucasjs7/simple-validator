<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Exception;
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleCliTable;

/**
 * Esta classe só deve ser chamada quando ocorrer um uso
 * indevido dos atributos de um Type
 */
class AttrError {

    public static function buildError(
        Attribute $attr,
        string    $errorMessage,
    ): void {
        $titleHeader = 'Attribute Error';
        $titleLib = Core::genHeaderError($titleHeader);
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

        Core::exitError(
            title: $titleHeader,
            message: $errorMessage,
            exception: new Exception,
            backtrace: true,
            tables: $attrTable,
        );
    }
}
