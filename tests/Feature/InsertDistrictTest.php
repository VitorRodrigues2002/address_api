<?php

use App\Services\CttService;
use Illuminate\Support\Facades\File;

class InsertDistrictTest extends TestCase
{
    public function testInsertDistrict()
    {
        if (!file_exists('./tests/Unit/InsertTest')) {
            $this->assertTrue(File::makeDirectory('./tests/Unit/InsertTest'));
        }

        $arrayInsertDistricts = [
            0 => 'code,name ',
            1 => '01;Aveiro',
            2 => '02;Beja',
            3 => '03;Braga',
            4 => '05;Castelo Branco',
        ];

        $arrayInsertDistricts = implode("\n", $arrayInsertDistricts);
        File::put('./tests/Unit/InsertTest/distritos.csv', $arrayInsertDistricts);
        $this->assertFileExists('./tests/Unit/InsertTest/distritos.csv');

        $this->assertTrue((new CttService)->insertDistricts('./tests/Unit/InsertTest/'));

        $this->assertTrue(File::deleteDirectory('./tests/Unit/InsertTest/'));
    }
}
