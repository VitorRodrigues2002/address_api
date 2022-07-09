<?php

use App\Services\CttService;
use Illuminate\Support\Facades\File;

class InsertCountyTest extends TestCase
{
    public function testInsertCountry()
    {
        if (!file_exists('./tests/Unit/InsertTest')) {
            $this->assertTrue(File::makeDirectory('./tests/Unit/InsertTest'));
        }

        $arrayInsertCounties = [
            0 => 'code_district,code,name',
            1 => '01;06;Castelo de Paiva',
            2 => '01;07;Espinho',
            3 => '01;08;Estarreja',
            4 => '01;09;Santa Maria da Feira',
        ];

        $arrayInsertCounties = implode("\n", $arrayInsertCounties);
        File::put('tests/Unit/InsertTest/concelhos.csv', $arrayInsertCounties);
        $this->assertFileExists('./tests/Unit/InsertTest/concelhos.csv');

        $this->assertTrue((new CttService)->insertCounties('./tests/Unit/InsertTest/'));

        $this->assertTrue(File::deleteDirectory('./tests/Unit/InsertTest/'));
    }
}
