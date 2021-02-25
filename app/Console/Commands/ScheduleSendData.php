<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\LogDataApi;

class ScheduleSendData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edii:kirimdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'kirim data ke API baca DB Query';

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
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //$token = $this->apihargologin();

        $data = \DB::select("SELECT * from trs where date(TimeIn) >= date('2021-02-20') limit 2");
        
        foreach ($data as $key => $value) {

            $datec = date_create($value->TimeIn);
            $datec = date_format($datec,"Y-m-d");
            $trf = round($value->Rate,0);
            $datakirim = [
                "cabang"=> "02",
                "gerbang"=> "$value->PosInID",
                "gardu" => "01",
                "gol" =>rand(1,6),
                "jentrn"=> "$value->TrsType",
                "resi" => "$value->ID",
                "tarif" => "$trf",
                "saldo" => "1000",
                "e_jam" => "$value->TimeIn", 
                "e_tgl" => "$datec",
                "shift" => "$value->SShiftID",
                "id_card"=> $value->CardNo == '' ? "1" : "$value->CardNo",
                "etoll_hash"=> $value->ID
            ];
            //$response = apihargokirim($token['token'],$datakirim);
            //LogDataApi::create(['str_unix' => $a,'raw_request' => $b,'raw_respons' => $c,]);
            //print_r(json_encode($response2));
        }
    }
}
