<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LogDataApi;

class BacaDanKirimCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edii:readkirimcsv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'kirim data ke API baca CSV';

    private $linklogin = 'http://10.109.9.12:4000/api/user/login';
    private $linkkirim = 'http://10.109.9.12:4000/api/pelindo/trx';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function apihargologin()
    {
        $response = Http::post($this->linklogin,[
            'username' => 'sundakelapa',
            'password' => 'sundakelapa',
        ]);
        $token = $response->json();
        return $token;
    }
    public function apihargokirim($token,$datakirim)
    {        
        $response2 = Http::withToken($token)->post($this->linkkirim,$datakirim);

        return $response2->json();
    }

    public function readCSV($csvFile, $array)
    {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
        }
        fclose($file_handle);
        return $line_of_text;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $srcDir = '/home/yanzadmiral/Documents/csv';
        $destDir = '/home/yanzadmiral/Documents/csv/sukses';

        if (file_exists($destDir)) {
        if (is_dir($destDir)) {
            if (is_writable($destDir)) {
            if ($handle = opendir($srcDir)) {
                while (false !== ($file = readdir($handle))) {
                if (is_file($srcDir . '/' . $file)) {
                    //$csvFile = '/home/yanzadmiral/Documents/csv/CSV-basic-ISO-8859-1.LF.csv';
                    echo $srcDir . '/' . $file." --- ".$destDir . '/' . $file."\r\n";
                    $csv = $this->readCSV($srcDir.'/'.$file,array('delimiter' => ','));
                    dump($csv);

                    // $datakirim = [
                    //     "cabang"=> "02",
                    //     "gerbang"=> "$value->PosInID",
                    //     "gardu" => "01",
                    //     "gol" =>rand(1,6),
                    //     "jentrn"=> "$value->TrsType",
                    //     "resi" => "$value->ID",
                    //     "tarif" => "$trf",
                    //     "saldo" => "1000",
                    //     "e_jam" => "$value->TimeIn", 
                    //     "e_tgl" => "$datec",
                    //     "shift" => "$value->SShiftID",
                    //     "id_card"=> $value->CardNo == '' ? "1" : "$value->CardNo",
                    //     "etoll_hash"=> $value->ID
                    // ];
                    // $response = apihargokirim($token['token'],$datakirim);
                    //LogDataApi::create(['str_unix' => $a,'raw_request' => $b,'raw_respons' => $c,]);
                    //rename($srcDir . '/' . $file, $destDir . '/' . $file);
                }
                }
                closedir($handle);
            } else {
                echo "$srcDir could not be opened.\n";
            }
            } else {
            echo "$destDir is not writable!\n";
            }
        } else {
            echo "$destDir is not a directory!\n";
        }
        } else {
        echo "$destDir does not exist\n";
        }
    }
}
