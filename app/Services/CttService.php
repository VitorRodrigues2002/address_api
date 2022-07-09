<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class CttService
{
    private ?string $basePath = null;
    private bool $truncate    = false;

    public function __construct(?string $basePath = null, bool $truncate = false)
    {
        $today       = date('dmY');
        $defaultPath = app()->basePath() . DIRECTORY_SEPARATOR
        . 'storage' . DIRECTORY_SEPARATOR
        . 'app' . DIRECTORY_SEPARATOR
        . 'cttAddresses' . DIRECTORY_SEPARATOR
        . "${today}" . DIRECTORY_SEPARATOR;

        $this->basePath = $basePath ?? $defaultPath;
        $this->truncate = $truncate;
    }

    public function insertDistricts(string $path)
    {
        if ($this->truncate) {
            DB::table('districts')->truncate();
        }

        $dataToInsert = $this->getDistrict($path . 'distritos.csv');

        return DB::table('districts')->insert($dataToInsert);
    }

    public function insertCounties(string $path)
    {
        if ($this->truncate) {
            DB::table('counties')->truncate();
        }
        $dataToInsert = $this->getCounties($path . 'concelhos.csv');

        return DB::table('counties')->insert($dataToInsert);
    }

    public function insertZipCodes(string $path)
    {
        if ($this->truncate) {
            DB::table('zip_codes')->truncate();
        }

        $dataToInsert = $this->getZipCodes($path . 'todos_cp.csv');

        $collection = collect($dataToInsert)->chunk(500);
        print_r(PHP_EOL . ' Start inserting into DB');
        foreach ($collection as $key => $value) {
            print_r($key . ';' . PHP_EOL);

            return DB::table('zip_codes')->insert($value->toArray());
        }
    }

    public function getZipCodes(string $path): array
    {
        $file = fopen($path, 'r');
        $key  = 0;
        ini_set('memory_limit', '-1');

        print_r(PHP_EOL . 'Starting reading zip codes CSV' . PHP_EOL);
        while (($line = fgetcsv(stream: $file, separator:';')) !== false) {
            //$line is an array of the csv elements
            if ($key > 0) {
                $district = DB::table('districts')
                    ->where('code', $line[0])
                    ->first();

                $county = DB::table('counties')
                    ->where('code', $line[1])
                    ->where('code_district', $line[0])
                    ->first();

                $toInsert[] = [
                    'district_id'   => $district->id,
                    'county_id'     => $county->id,
                    'code_locality' => $line[2],
                    'name_locality' => utf8_encode($line[3]),
                    'code_arteria'  => $line[4],
                    'type_arteria'  => utf8_encode($line[5]),
                    'prep1'         => $line[6],
                    'title_arteria' => utf8_encode($line[7]),
                    'prep2'         => $line[8],
                    'name_arteria'  => utf8_encode($line[9]),
                    'local_arteria' => utf8_encode($line[10]),
                    'change'        => utf8_encode($line[11]),
                    'door'          => $line[12],
                    'client'        => utf8_encode($line[13]),
                    'number'        => $line[14],
                    'extension'     => $line[15],
                    'desig_postal'  => utf8_encode($line[16]),
                ];
            }
            $key++;
            print_r($key . PHP_EOL);
        }
        print_r('Codigos Postais' . PHP_EOL);
        fclose($file);
        ini_set('memory_limit', '-1');

        return $toInsert;
    }

    public function getDistrict(string $path): array
    {
        $file = fopen($path, 'r');
        $key  = 0;
        print_r(PHP_EOL . 'Starting reading districts CSV' . PHP_EOL);
        while (($line = fgetcsv(stream: $file, separator:';')) !== false) {
            //$line is an array of the csv elements
            if ($key > 0) {
                $toInsert[] = [
                    'code' => $line[0],
                    'name' => utf8_encode($line[1]),
                ];
            }
            $key++;
            print_r($key . PHP_EOL);
        }
        print_r('Distritos' . PHP_EOL);
        fclose($file);

        return $toInsert;
    }

    public function getCounties(string $path): array
    {
        $this->basePath = $path;
        $file           = fopen($path, 'r');
        $key            = 0;
        print_r(PHP_EOL . 'Starting reading counties CSV' . PHP_EOL);
        while (($line = fgetcsv(stream: $file, separator:';')) !== false) {
            //$line is an array of the csv elements
            if ($key > 0) {
                $toInsert[] = [
                    'code_district' => $line[0],
                    'code'          => $line[1],
                    'name'          => utf8_encode($line[2]),
                ];
            }
            $key++;
            print_r($key . PHP_EOL);
        }
        print_r('Concelhos' . PHP_EOL);
        fclose($file);

        return $toInsert;
    }
}
