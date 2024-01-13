<?php

use function Tembra\Pest\Plugins\XArgs\{getXArg};
use function Tembra\Pest\Plugins\XArgs\{hasXArg};

it('can receive no argument', function () {
    $hasArg = hasXArg('does-not-exists');
    $value = getXArg('does-not-exists');

    expect($hasArg)->toBe(false)
        ->and($value)->toBeNull();
});

it('can receive --x-test argument', function () {
    $hasTest = hasXArg('test');
    $value = getXArg('test');

    expect($hasTest)->toBe(true)
        ->and($value)->toBe('');
});

it('can receive --x-key=value argument', function () {
    $value = getXArg('key');

    expect($value)->toBe('value');
});

it('can receive --x-any-key="any value inside quotes" argument', function () {
    $value = getXArg('any-key');

    expect($value)->toBe('any value inside quotes');
});

it("can receive --x-special-chars-value=\"\`-=~!@#$%^&*()_+[]\{}|;':\\\",./<>? \" argument", function () {
    $value = getXArg('special-chars-value');

    expect($value)->toBe('`-=~!@#$%^&*()_+[]\{}|;\':",./<>? ');
});

it('can receive --x-speci@l_k3y+on.\"AnY\\\'!cAsE=value argument', function () {
    $value = getXArg('speci@l_k3y+on."AnY\'!cAsE');

    expect($value)->toBe('value');
});

it('can receive --x-value-with-equal=arg=value argument where value = "arg=value"', function () {
    $value = getXArg('value-with-equal');

    expect($value)->toBe('arg=value');
});

it('can not receive --x-arg=key=value argument where key = "arg=key"', function () {
    $value = getXArg('arg=key');

    expect($value)->toBeNull();
});
