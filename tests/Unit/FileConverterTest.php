<?php

use App\Services\FileConverter;
use Illuminate\Support\Facades\File;

class FileConverterTest extends TestCase
{
    public function testFileConverter()
    {
        if (!file_exists('tests/Unit/FileConverterTest')) {
            $this->assertTrue(File::makeDirectory('tests/Unit/FileConverterTest'));
        }

        File::put('tests/Unit/FileConverterTest/concelhos.txt', 'File Converter Concelhos');
        $this->assertFileExists('tests/Unit/FileConverterTest/concelhos.txt');

        File::put('tests/Unit/FileConverterTest/distritos.txt', 'File Converter Distritos');
        $this->assertFileExists('tests/Unit/FileConverterTest/distritos.txt');

        File::put('tests/Unit/FileConverterTest/todos_cp.txt', 'File Converter Codigos Postais');
        $this->assertFileExists('tests/Unit/FileConverterTest/todos_cp.txt');

        $this->assertTrue((new FileConverter)->convert('./tests/Unit/FileConverterTest/'));

        $this->assertTrue(File::deleteDirectory('tests/Unit/FileConverterTest/'));
    }
}
