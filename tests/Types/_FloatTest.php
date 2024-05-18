<?php

use Lucasjs7\SimpleValidator\Language\Language as Lng;
use Lucasjs7\SimpleValidator\Language\eLanguage as eLng;
use Lucasjs7\SimpleValidator\Type\_Float;

Lng::set(eLng::PT);

# TRUE TESTS
it('_Float#1 - T', function () {
	expect(
		value: _Float::new()->max(10.3)->validate(10.3, false)
	)->toBe(true);
});
it('_Float#2 - T', function () {
	expect(
		value: _Float::new()->min(10.3)->validate(10.3, false)
	)->toBe(true);
});
it('_Float#3 - T', function () {
	expect(
		value: _Float::new()->unsigned()->validate(0, false)
	)->toBe(true);
});
it('_Float#4 - T', function () {
	expect(
		value: _Float::new()->max(10.3)->min(5.8)->validate(10.3, false)
	)->toBe(true);
});
it('_Float#5 - T', function () {
	expect(
		value: _Float::new()->max(10.3)->min(5.8)->validate(5.8, false)
	)->toBe(true);
});
it('_Float#6 - T', function () {
	expect(
		value: _Float::new()->max(10.3)->unsigned()->validate(0, false)
	)->toBe(true);
});
it('_Float#7 - T', function () {
	expect(
		value: _Float::new()->max(10.3)->unsigned()->validate(10.3, false)
	)->toBe(true);
});

# FALSE TESTS
it('_Float#1 - F', function () {
	expect(
		value: _Float::new()->max(10.3)->validate(10.4, false)
	)->toBe(false);
});
it('_Float#2 - F', function () {
	expect(
		value: _Float::new()->min(10.3)->validate(10.2, false)
	)->toBe(false);
});
it('_Float#3 - F', function () {
	expect(
		value: _Float::new()->unsigned()->validate(-0.1, false)
	)->toBe(false);
});
it('_Float#4 - F', function () {
	expect(
		value: _Float::new()->max(10.3)->min(5.8)->validate(10.4, false)
	)->toBe(false);
});
it('_Float#5 - F', function () {
	expect(
		value: _Float::new()->max(10.3)->min(5.8)->validate(5.7, false)
	)->toBe(false);
});
it('_Float#6 - F', function () {
	expect(
		value: _Float::new()->max(10.3)->unsigned()->validate(-0.1, false)
	)->toBe(false);
});
it('_Float#7 - F', function () {
	expect(
		value: _Float::new()->max(10.3)->unsigned()->validate(10.4, false)
	)->toBe(false);
});
