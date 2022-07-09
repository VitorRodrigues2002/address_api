<?php

use App\Services\CttService;
use Illuminate\Support\Facades\File;

class GetCountyTest extends TestCase
{
    public function testGetCounty()
    {
        if (!file_exists('tests/Unit/FileConverterTest')) {
            $this->assertTrue(File::makeDirectory('tests/Unit/FileConverterTest'));
        }

        $arrayInsertCounties = [
            0 => 'code_district,code,name',
            1 => '01;06;Castelo de Paiva',
            2 => '01;07;Espinho',
            3 => '01;08;Estarreja',
            4 => '01;09;Santa Maria da Feira',
        ];

        $arrayInsertCounties = implode("\n", $arrayInsertCounties);
        File::put('tests/Unit/FileConverterTest/concelhos.csv', $arrayInsertCounties);

        $this->assertFileExists('./tests/Unit/FileConverterTest/concelhos.csv');

        $fileCounties = (new CttService)->getCounties('./tests/Unit/FileConverterTest/concelhos.csv');
        $this->assertIsArray($fileCounties);

        foreach ($fileCounties as $key => $value) {
            $this->assertArrayHasKey($key, $fileCounties);
            $this->assertIsArray($value);
            $this->assertArrayHasKey('code_district', $value);
            $this->assertArrayHasKey('code', $value);
            $this->assertArrayHasKey('name', $value);
        }

        $this->assertTrue(File::deleteDirectory('tests/Unit/FileConverterTest/'));

        $this->assertFileDoesNotExist('./tests/Unit/FileConverterTest/concelhos.csv');
    }
}
