<?php

use App\Services\CttService;
use Illuminate\Support\Facades\File;

class GetDistrictTest extends TestCase
{
    public function testGetDistrict()
    {
        if (!file_exists('tests/Unit/FileConverterTest')) {
            $this->assertTrue(File::makeDirectory('tests/Unit/FileConverterTest'));
        }

        $arrayInsertDistricts = [
            0 => 'code,name ',
            1 => '01;Aveiro',
            2 => '02;Beja',
            3 => '03;Braga',
            4 => '05;Castelo Branco',
        ];

        $arrayInsertDistricts = implode("\n", $arrayInsertDistricts);
        File::put('tests/Unit/FileConverterTest/distritos.csv', $arrayInsertDistricts);
        $this->assertFileExists('tests/Unit/FileConverterTest/distritos.csv');

        $fileDistrict = (new CttService)->getDistrict('./tests/Unit/FileConverterTest/distritos.csv');
        $this->assertIsArray($fileDistrict);

        foreach ($fileDistrict as $key => $value) {
            $this->assertArrayHasKey($key, $fileDistrict);
            $this->assertIsArray($value);
            $this->assertArrayHasKey('code', $value);
            $this->assertArrayHasKey('name', $value);
        }

        $this->assertTrue(File::deleteDirectory('tests/Unit/FileConverterTest/'));

        $this->assertFileDoesNotExist('./tests/Unit/FileConverterTest/distritos.csv');
    }
}
