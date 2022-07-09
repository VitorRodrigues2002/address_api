<?php

use App\Services\Unzip;
use Illuminate\Support\Facades\File;

class UnzipTest extends TestCase
{
    public function testUnzip()
    {
        if (!file_exists('tests/Unit/UnzipTest')) {
            $this->assertTrue(File::makeDirectory('tests/Unit/UnzipTest'));
        }

        $zip = new ZipArchive;

        if ($zip->open('./tests/Unit/UnzipTest/testUnzip.zip', ZipArchive::CREATE) === true) {
            $files = File::files('./tests/Feature');
            foreach ($files as $key => $valeu) {
                $relativeName = basename($valeu);
                $this->assertTrue($zip->addFile($valeu, $relativeName));
            }
            $zip->close();
        }
        $this->assertTrue((new Unzip)->unzip('./tests/Unit/UnzipTest/testUnzip.zip', './tests/Unit/UnzipTest'));

        $this->assertTrue(File::deleteDirectory('tests/Unit/UnzipTest'));
    }
}
