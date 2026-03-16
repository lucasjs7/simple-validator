<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\_File;
use Lucasjs7\SimpleValidator\Type\_Image;
use Lucasjs7\SimpleValidator\Type\TypeParser;

function is_uploaded_file(string $filename): bool {
    return file_exists($filename);
}

describe('File', function() {

    $fileTxt     = genTmpFile(__DIR__.DIRECTORY_SEPARATOR.'file.txt');
    $fileImg     = genTmpFile(__DIR__.DIRECTORY_SEPARATOR.'cat.jpg');
    $fileInvalid = [
        'name'      => 'file.txt',
        'full_path' => 'invalid.txt',
        'type'      => 'application/octet-stream',
        'tmp_name'  => '/tmp/test',
        'error'     => 0,
        'size'      => 300,
    ];

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'simple text file'         => [_File::new(), $fileTxt, true, true],
            'required file'            => [TypeParser::new('type: file | required'), $fileTxt, true, true],
            'max size 1MB'             => [_File::new()->max('1MB'), $fileTxt, true, true],
            'image width exactly 98'   => [_Image::new()->width(98), $fileImg, true, true],
            'image height exactly 147' => [_Image::new()->height(147), $fileImg, true, true],
            'image extension png jpg'  => [TypeParser::new('type: image | ext: png, jpg'), $fileImg, true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'invalid file data'       => [_File::new(), $fileInvalid, false, false],
            'max size 0.01B'          => [_File::new()->max('0.01B'), $fileTxt, false, false],
            'invalid max format 343'  => [_File::new()->max('343'), $fileTxt, false, false],
            'invalid max format 343B' => [_File::new()->max('343B'), $fileImg, false, false],
            'image wrong width 10'    => [_Image::new()->width(10), $fileImg, false, false],
            'image wrong height 146'  => [_Image::new()->height(146), $fileImg, false, false],
            'image wrong extension'   => [_Image::new()->ext('.jpeg', '.xml'), $fileImg, false, false],
        ]);

});