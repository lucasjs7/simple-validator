<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

class Attribute {

    public readonly AttrData $unsigned;
    public readonly AttrData $min;
    public readonly AttrData $max;
    public readonly AttrData $options;
    public readonly AttrData $format;
    public readonly AttrData $regex;
    public readonly AttrData $label;
    public readonly AttrData $callable;
    public readonly AttrData $required;
    public readonly AttrData $width;
    public readonly AttrData $height;

    public function __construct() {
        $this->unsigned = new AttrData;
        $this->min      = new AttrData;
        $this->max      = new AttrData;
        $this->options  = new AttrData;
        $this->format   = new AttrData;
        $this->regex    = new AttrData;
        $this->label    = new AttrData;
        $this->callable = new AttrData;
        $this->required = new AttrData;
        $this->width    = new AttrData;
        $this->height   = new AttrData;

        $this->required->setValue(false);
    }
}
