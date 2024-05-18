<?php

use Lucasjs7\SimpleValidator\Language\Language as Lng;
use Lucasjs7\SimpleValidator\Language\eLanguage as eLng;
use Lucasjs7\SimpleValidator\Type\_Int;

Lng::set(eLng::PT);

# TEST 1
it('_Int#1 - T', function () {
	expect(
		value: _Int::new()->max(10)->validate(10, false)
	)->toBe(true);
});
it('_Int#2 - T', function () {
	expect(
		value: _Int::new()->min(10)->validate(10, false)
	)->toBe(true);
});
it('_Int#3 - T', function () {
	expect(
		value: _Int::new()->unsigned()->validate(0, false)
	)->toBe(true);
});
it('_Int#4 - T', function () {
	expect(
		value: _Int::new()->max(10)->min(5)->validate(10, false)
	)->toBe(true);
});
it('_Int#5 - T', function () {
	expect(
		value: _Int::new()->max(10)->min(5)->validate(5, false)
	)->toBe(true);
});
it('_Int#6 - T', function () {
	expect(
		value: _Int::new()->max(10)->unsigned()->validate(0, false)
	)->toBe(true);
});
it('_Int#7 - T', function () {
	expect(
		value: _Int::new()->max(10)->unsigned()->validate(10, false)
	)->toBe(true);
});

# TEST 2
it('_Int#1 - F', function () {
	expect(
		value: _Int::new()->max(10)->validate(11, false)
	)->toBe(false);
});
it('_Int#2 - F', function () {
	expect(
		value: _Int::new()->min(10)->validate(9, false)
	)->toBe(false);
});
it('_Int#3 - F', function () {
	expect(
		value: _Int::new()->unsigned()->validate(-1, false)
	)->toBe(false);
});
it('_Int#4 - F', function () {
	expect(
		value: _Int::new()->max(10)->min(5)->validate(11, false)
	)->toBe(false);
});
it('_Int#5 - F', function () {
	expect(
		value: _Int::new()->max(10)->min(5)->validate(4, false)
	)->toBe(false);
});
it('_Int#6 - F', function () {
	expect(
		value: _Int::new()->max(10)->unsigned()->validate(-1, false)
	)->toBe(false);
});
it('_Int#7 - F', function () {
	expect(
		value: _Int::new()->max(10)->unsigned()->validate(11, false)
	)->toBe(false);
});
