<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/cobapost', function () {

    $users = DB::select('SELECT * from trs limit 1');
     dd($users);
    //$response = Http::post('http://10.109.9.12:4000/api/user/login',[
    //     'username' => 'sundakelapa',
    //     'password' => 'sundakelapa',
    // ]);
    // $token = $response->json();
    
    // $response2 = Http::withToken($token['token'])->post('http://10.109.9.12:4000/api/pelindo/trx',[
    //     "cabang"=> "90",
    //     "gerbang"=> "10",
    //     "gardu" => "01",
    //     "gol" => "6",
    //     "jentrn"=> "21",
    //     "resi" => "1234",
    //     "tarif" => "2000",
    //     "saldo" => "4000",
    //     "e_jam" => "2021-02-11 11:59:44", 
    //     "e_tgl" => "2021-02-11",
    //     "shift" => "1",
    //     "id_card"=> "123123214123123",
    //     "etoll_hash"=> "12312asdasad1"
    // ]);

    // echo json_encode($response2->json());
});


