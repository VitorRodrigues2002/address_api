<?php

use App\Services\CttService;
use Illuminate\Support\Facades\File;

class InsertZipCodeTest extends TestCase
{
    public function testInsertZipCode()
    {
        if (!file_exists('./tests/Unit/InsertTest')) {
            $this->assertTrue(File::makeDirectory('./tests/Unit/InsertTest'));
        }
        $arrayInsertZipCodes = [
            0 => 'code_district,code_county,code_locality,name_locality,code_arteria,tipo_arteria,prep1,title_arteria,prep2,name_arteria,local_arteria,change,door,client,number_zip_codes,extension_zip_codes,desig_postal',
            1 => '01;06;258;Aguada de Baixo;;;;;;;;;;PC AGUADA DE BAIXO;3750;996;AGUADA DE BAIXO',
            2 => '01;07;258;Aguada de Baixo;;;;;;;;;;;3750;031;AGUADA DE BAIXO',
            3 => '01;08;260;Landiosa;;;;;;;;;;;3750;033;AGUADA DE BAIXO',
            4 => '01;09;262;Passadouro;;;;;;;;;;;3750;035;AGUADA DE BAIXO',
        ];

        $arrayInsertZipCodes = implode("\n", $arrayInsertZipCodes);
        File::put('./tests/Unit/InsertTest/todos_cp.csv', $arrayInsertZipCodes);
        $this->assertFileExists('./tests/Unit/InsertTest/todos_cp.csv');

        $this->assertTrue((new CttService)->insertZipCodes('./tests/Unit/InsertTest/'));

        $this->assertTrue(File::deleteDirectory('./tests/Unit/InsertTest/'));
    }
}
