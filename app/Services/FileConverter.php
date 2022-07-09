<?php
namespace App\Services;

class FileConverter
{
    public function configs()
    {
        return [
            'concelhos' => 'code_district,code,name',
            'distritos' => 'code,name',
            'todos_cp'  => 'code_district,code_county,code_locality,name_locality,code_arteria,tipo_arteria,prep1,title_arteria,prep2,name_arteria,local_arteria,change,door,client,number_zip_codes,extension_zip_codes,desig_postal'
        ];
    }

    public function convert(?string $path = null): bool | string
    {
        $path = $path ?? $this->serializePath(env('CTT_FILES_PATH'));
        foreach ($this->configs() as $fileName => $columns) {
            $oldName = $path . $fileName . '.txt';
            $newName = $path . $fileName . '.csv';

            if (!rename($oldName, $newName)) {
                return $fileName;
            }

            $header = "{$columns} \r\n";
            $data   = file_get_contents($newName);
            file_put_contents($newName, $header . $data);
        }

        return true;
    }

    public function serializePath(string $path): string
    {
        return str_replace('####', date('dmY'), $path);
    }
}
