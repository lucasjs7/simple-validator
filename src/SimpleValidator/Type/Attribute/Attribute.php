<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

class Attribute {

	public readonly AttrData $unsigned;
	public readonly AttrData $min;
	public readonly AttrData $max;
	public readonly AttrData $options;
	public readonly AttrData $format;
	public readonly AttrData $regex;
	public readonly AttrData $required;

	public function __construct() {
		$this->unsigned = new AttrData;
		$this->min 		= new AttrData;
		$this->max 		= new AttrData;
		$this->options 	= new AttrData;
		$this->format 	= new AttrData;
		$this->regex 	= new AttrData;
		$this->required = new AttrData;

		$this->required->setValue(false);
	}
}
