<?php

namespace App\Services;

use Carbon\Carbon;
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
            return $e->getMessage();
         }
         $prices = $response->ok()?$response->json()['prices']:[];
         if(count($prices)){
            return $this->filterData($prices , $startDate , $endDate);
         }

         return null;
    }


      public function filterData($prices, $startDate , $endDate ,$region=null){

        $startDate = Carbon::parse($startDate)->timestamp;
        $endDate   = Carbon::parse($endDate)->timestamp;

        $collection = collect($prices);

        $result = $collection->filter(function ($value) use ($startDate , $endDate) {
            return $value['date'] >= $startDate && $value['date'] <= $endDate;
        })->map(function($value){
            $value['date'] = Carbon::parse($value['date'])->toDateString();
            return $value;
        });
       
        return $result;
      }


}