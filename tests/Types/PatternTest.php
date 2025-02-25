<?php

use Lucasjs7\SimpleValidator\Type\_Callable;
use Lucasjs7\SimpleValidator\Type\TypeParser;

it('Pattern#' . __LINE__, function () {

    $attrRequired = TypeParser::new('type: string');
    $attrRequired->save('test_pattern_required');

    $finalAttrRequired = TypeParser::new('type: string | pattern: test_pattern_required | required');

    expect($attrRequired->getAttr()->required->getValue())->toBe(false);
    expect($finalAttrRequired->getAttr()->required->getValue())->toBe(true);
});

it('Pattern#' . __LINE__, function () {

    $attrUnsigned = TypeParser::new('type: int');
    $attrUnsigned->save('test_pattern_unsigned');

    $finalAttrUnsigned = TypeParser::new('type: int | pattern: test_pattern_unsigned | unsigned');

    expect($attrUnsigned->getAttr()->unsigned->getValue())->toBe(null);
    expect($finalAttrUnsigned->getAttr()->unsigned->getValue())->toBe(true);
});

it('Pattern#' . __LINE__, function () {

    $attrMin = TypeParser::new('type: int');
    $attrMin->save('test_pattern_min');

    $finalAttrMin = TypeParser::new('type: int | pattern: test_pattern_min | min: 2');

    expect($attrMin->getAttr()->min->getValue())->toBe(null);
    expect($finalAttrMin->getAttr()->min->getValue())->toBe(2.0);
});

it('Pattern#' . __LINE__, function () {

    $attrMax = TypeParser::new('type: float');
    $attrMax->save('test_pattern_max');

    $finalAttrMax = TypeParser::new('type: float | pattern: test_pattern_max | max: 3');

    expect($attrMax->getAttr()->max->getValue())->toBe(null);
    expect($finalAttrMax->getAttr()->max->getValue())->toBe(3.0);
});

it('Pattern#' . __LINE__, function () {

    $attrOptions = TypeParser::new('type: string');
    $attrOptions->save('test_pattern_options');

    $finalAttrOptions = TypeParser::new('type: string | pattern: test_pattern_options | options: 1');

    expect($attrOptions->getAttr()->options->getValue())->toBe(null);
    expect($finalAttrOptions->getAttr()->options->getValue())->toBe(['1']);
});

it('Pattern#' . __LINE__, function () {

    $attrFormat = TypeParser::new('type: date');
    $attrFormat->save('test_pattern_format');

    $finalAttrFormat = TypeParser::new('type: date | pattern: test_pattern_format | format: Y');

    expect($attrFormat->getAttr()->format->getValue())->toBe('Y-m-d');
    expect($finalAttrFormat->getAttr()->format->getValue())->toBe('Y');
});

it('Pattern#' . __LINE__, function () {

    $attrRegex = TypeParser::new('type: string');
    $attrRegex->save('test_pattern_regex');

    $finalAttrRegex = TypeParser::new('type: string | pattern: test_pattern_regex | regex: /[^0-9]/');

    expect($attrRegex->getAttr()->regex->getValue())->toBe(null);
    expect($finalAttrRegex->getAttr()->regex->getValue())->toBe('/[^0-9]/');
});

it('Pattern#' . __LINE__, function () {

    $attrLabel = TypeParser::new('type: string');
    $attrLabel->save('test_pattern_label');

    $finalAttrLabel = TypeParser::new('type: string | pattern: test_pattern_label | label: jorel');

    expect($attrLabel->getAttr()->label->getValue())->toBe(null);
    expect($finalAttrLabel->getAttr()->label->getValue())->toBe('jorel');
});

it('Pattern#' . __LINE__, function () {

    $attrCallable = _Callable::new(null, null);
    $attrCallable->save('test_pattern_callable');

    $finalFunction = function () {
        return true;
    };

    $finalAttrCallable = TypeParser::new('type: callable | pattern: test_pattern_callable');
    $finalAttrCallable->getAttr()->callable->setValue($finalFunction);

    expect($attrCallable->getAttr()->callable->getValue())->toBe(null);
    expect($finalAttrCallable->getAttr()->callable->getValue())->toBe($finalFunction);
});
