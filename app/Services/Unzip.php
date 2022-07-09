<?php
namespace App\Services;

use ZipArchive;

class Unzip extends ZipArchive
{
    public function unzip(?string $path = null, ?string $path2 = null): bool
    {
        $path  = $path  ?? $this->serializePath(env('CTT_ZIP_PATH'));
        $path2 = $path2 ?? $this->serializePath(env('CTT_EXTRACT_PATH'));
        if ($this->open($path) === true) {
            $this->extractTo($path2);
            $this->close();

            return true;
        }

        return false;
    }

    public function serializePath(string $path): string
    {
        return str_replace('####', date('dmY'), $path);
    }
}
