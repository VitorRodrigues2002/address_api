<?php
namespace App\Console\Commands;

use App\Services\CttService;
use App\Services\FileConverter;
use App\Services\Unzip;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportCtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ctt:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Main file to start script';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today               = date('dmY');
        $todayMinusSevenDays = Carbon::now()->subDay(7)->format('dmY');
        $path                = serializePath('./resources/js/cttExporter/index.js');
        $pathZip             = serializePath("./storage/app/cttAddresses/${today}/todos_cp.zip");
        $pathFile            = serializePath("./storage/app/cttAddresses/${today}/");
        $pathDelete          = serializePath("./storage/app/cttAddresses/${todayMinusSevenDays}");

        if (!file_exists($pathZip)) {
            shell_exec('node ./resources/js/cttExporter/index.js');
        }

        if (!(new Unzip)->unzip()) {
            return $this->error('Error unzip file');
        }

        if (file_exists($pathDelete)) {
            File::deleteDirectory($pathDelete);
        }

        if (!$fileName = (new FileConverter)->convert()) {
            return $this->error("Error converting ${fileName}");
        }

        if (file_exists($path)) {
            if (true) {
                $cttService = new CttService(truncate: true);

                $cttService->insertCounties($pathFile);
                $cttService->insertDistricts($pathFile);
                $cttService->insertZipCodes($pathFile);

                return $this->info('success');
            }

            return $this->error('Error Inserts');
        }
    }
}
