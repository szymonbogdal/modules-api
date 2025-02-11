<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;

class ValidationTest extends TestCase
{
    public static function dimensionProvider()
    {
        return [
            'valid px' => ['100px', true],
            'valid percentage' => ['50%', true],
            'valid rem' => ['10rem', true],
            'valid vh' => ['5vh', true],
            'valid vw' => ['3vw', true],
            'valid em' => ['2.5em', true],
            'only number' => ['100', true],
            'invalid string' => ['invalid', false],
            'invalid unit' => ['abcpx', false],
            'wrong order' => ['px100', false],
        ];
    }

    public static function colorProvider()
    {
        return [
            'valid hex short' => ['#fff', true],
            'valid hex full' => ['#ffffff', true],
            'valid hex with alpha' => ['#12345678', true],
            'valid rgb' => ['rgb(255, 0, 0)', true],
            'valid rgba' => ['rgba(255, 0, 0, 0.5)', true],
            'valid hsl' => ['hsl(360, 100%, 50%)', true],
            'valid hsla' => ['hsla(360, 100%, 50%, 0.5)', true],
            'valid transparent' => ['transparent', true],
            'valid inherit' => ['inherit', true],
            'valid unset' => ['unset', true],
            'invalid color name' => ['invalid', false],
            'invalid hex' => ['#xyz', false],
            'invalid rgb value' => ['rgb(256, 0, 0)', false],
            'invalid hsl value' => ['hsl(100, 200%, 50%)', false],
        ];
    }

    public static function linkProvider()
    {
        return [
            'valid https' => ['https://example.com', true],
            'valid http' => ['http://example.com', true],
            'valid ftp' => ['ftp://example.com', true],
            'invalid string' => ['invalid', false],
            'missing protocol' => ['www.example.com', false],
            'invalid domain' => ['example', false],
        ];
    }

    #[DataProvider('dimensionProvider')]
    public function testCssDimensionValidation($value, $expected){
        $validator = Validator::make(['width' => $value], ['width' => ['required', new \App\Rules\CssDimension()]]);
        $this->assertEquals($expected, $validator->passes());
    }

    #[DataProvider('colorProvider')]
    public function testCssColorValidation($value, $expected){
        $validator = Validator::make(['color' => $value], ['color' => ['required', new \App\Rules\CssColor()]]);
        $this->assertEquals($expected, $validator->passes());
    }

    #[DataProvider('linkProvider')]
    public function testUrlValidation($value, $expected){
        $validator = Validator::make(['link' => $value], ['link' => ['required', 'url']]);
        $this->assertEquals($expected, $validator->passes());
    }
}
