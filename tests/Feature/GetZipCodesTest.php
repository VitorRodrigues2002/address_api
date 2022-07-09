<?php

use App\Services\CttService;
use Illuminate\Support\Facades\File;

class GetZipCodesTest extends TestCase
{
    public function testGetZipCodes()
    {
        if (!file_exists('tests/Unit/FileConverterTest')) {
            $this->assertTrue(File::makeDirectory('tests/Unit/FileConverterTest'));
        }
        $arrayInsertZipCodes = [
            0 => 'code_district,code_county,code_locality,name_locality,code_arteria,tipo_arteria,prep1,title_arteria,prep2,name_arteria,local_arteria,change,door,client,number_zip_codes,extension_zip_codes,desig_postal',
            1 => '01;01;258;Aguada de Baixo;;;;;;;;;;PC AGUADA DE BAIXO;3750;996;AGUADA DE BAIXO',
            2 => '01;01;323;Borralha;162630000;Rua;do;;;Agueiro;Bairro do Agueiro;;;;3750;851;BORRALHA',
            3 => '17;13;51935;Sabroso de Aguiar;15762100;Rua;da;;;Barroca;;;;;5450;370;SABROSO DE AGUIAR',
            4 => '17;13;75237;Fontes;56190000;Rua;da;;;Capela;;;;;5450;269;SOUTELO DE AGUIAR',
        ];

        $arrayInsertZipCodes = implode("\n", $arrayInsertZipCodes);
        File::put('tests/Unit/FileConverterTest/todos_cp.csv', $arrayInsertZipCodes);
        $this->assertFileExists('tests/Unit/FileConverterTest/todos_cp.csv');

        $fileZipCode = (new CttService)->getZipCodes('./tests/Unit/FileConverterTest/todos_cp.csv');
        $this->assertIsArray($fileZipCode);

        foreach ($fileZipCode as $key => $value) {
            $this->assertArrayHasKey($key, $fileZipCode);
            $this->assertIsArray($value);
            $this->assertArrayHasKey('district_id', $value);
            $this->assertArrayHasKey('county_id', $value);
            $this->assertArrayHasKey('code_locality', $value);
            $this->assertArrayHasKey('name_locality', $value);
            $this->assertArrayHasKey('code_arteria', $value);
            $this->assertArrayHasKey('type_arteria', $value);
            $this->assertArrayHasKey('prep1', $value);
            $this->assertArrayHasKey('title_arteria', $value);
            $this->assertArrayHasKey('prep2', $value);
            $this->assertArrayHasKey('name_arteria', $value);
            $this->assertArrayHasKey('local_arteria', $value);
            $this->assertArrayHasKey('change', $value);
            $this->assertArrayHasKey('door', $value);
            $this->assertArrayHasKey('client', $value);
            $this->assertArrayHasKey('number', $value);
            $this->assertArrayHasKey('extension', $value);
            $this->assertArrayHasKey('desig_postal', $value);
        }

        $this->assertTrue(File::deleteDirectory('tests/Unit/FileConverterTest/'));

        $this->assertFileDoesNotExist('./tests/Unit/FileConverterTest/todos_cp.csv');
    }
}
