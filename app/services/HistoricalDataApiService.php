<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class HistoricalDataApiService{


    protected  $HistoricalDataUrl ;
    protected  $xRapidApiKey;
    protected  $xRapidApiHost ;
    protected  $jsonFileName ;
    protected  $jsonFileStorePath;

    public function __construct() {
        $this->HistoricalDataUrl = config('rapidapi.historical_data_url');
        $this->xRapidApiKey      = config('rapidapi.key');
        $this->xRapidApiHost     = config('rapidapi.host');

    }


    public function getData($symbol, $startDate , $endDate ,$region=null){

         
         try {
            $response = Http::withHeaders([
                "X-RapidAPI-Key"=>$this->xRapidApiKey,
                "X-RapidAPI-Host"=>$this->xRapidApiHost,
                ])->get($this->HistoricalDataUrl , [
                    'symbol' => $symbol
                ]);
         } catch (ConnectionException $e) {
            //throw $th;
         }

         return $this->filterData($response->json() , $startDate , $endDate);


    }


      public function filterData($symbol, $startDate , $endDate ,$region=null){

         // maybe store it first as a json
      }


}