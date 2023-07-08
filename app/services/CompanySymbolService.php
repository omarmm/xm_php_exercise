<?php

namespace App\Services;

use App\Models\CompanySymbolList;
use Illuminate\Support\Facades\Http;

use File;

class CompanySymbolService{


protected  $companSymbolListUrl ;
protected  $jsonData ;
protected  $jsonFileName ;
protected  $jsonFileStorePath;

public function __construct() {

    $this->companSymbolListUrl =  config('app.company_symbol_list_url');
    $this->jsonData            =  Http::get($this->companSymbolListUrl)->json();
    $this->jsonFileName        =  'companies_symbols.json';
    $this->jsonFileStorePath   =  public_path('/'.$this->jsonFileName);

}

public function getCompanySymbolList($request){
  $q = trim($request->q);
  $symbols = CompanySymbolList::where('id','like','%'.$q.'%')
      ->where('text', 'LIKE',  '%' .$q. '%')
      ->orderBy('text', 'asc')->simplePaginate(10);

    if(count($symbols)){
        $morePages=true;
       if (empty($symbols->nextPageUrl())){
        $morePages=false;
       }
        $results = array(
          "results" => $symbols->items(),
          "pagination" => array(
            "more" => $morePages
          )
        );
    
        return response()->json($results);
    
    
    }

    return json_decode(File::get($this->jsonFileStorePath));
}
public function storeCompanySymbolListJsonFile(){

      $data =[];
     foreach ($this->jsonData as $key => $value) {
         $data[$key]['id'] = $value['Symbol'];
         $data[$key]['text'] = $value['Symbol'].'  :  '.$value['Company Name'];
     }

     File::put($this->jsonFileStorePath, json_encode(["results"=>$data]));

    return json_decode(File::get($this->jsonFileStorePath));
}


public function storeCompanySymbolListDb(){

    foreach($this->jsonData as $value)
    {
        CompanySymbolList::firstOrCreate(
            [
                'id'             => $value['Symbol'],
            ],
            [
                'text'           =>  $value['Symbol'].'  :  '.$value['Company Name'],
            ]);

    }
}




}