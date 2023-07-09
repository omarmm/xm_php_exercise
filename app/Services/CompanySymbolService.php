<?php

namespace App\Services;

use App\Models\CompanySymbolList;
use Illuminate\Support\Facades\Http;

use File;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;
use stdClass;

/**
 * CompanySymbolService
 */
class CompanySymbolService
{


    protected  $companSymbolListUrl;
    protected  $jsonData;
    protected  $jsonFileName;
    protected  $jsonFileStorePath;

    public function __construct()
    {

        $this->companSymbolListUrl =  config('app.company_symbol_list_url');
        $this->jsonData            =  Http::get($this->companSymbolListUrl)->json();
        $this->jsonFileName        =  'companies_symbols.json';
        $this->jsonFileStorePath   =  public_path('/' . $this->jsonFileName);
    }

    /**
     * getCompanySymbolList
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function getCompanySymbolList($request=null): JsonResponse|string
    {
        $q=!is_null($request)?trim($request->q):'';
        $symbols = CompanySymbolList::where('id', 'like', '%' . $q . '%')
            ->where('text', 'LIKE',  '%' . $q . '%')
            ->orderBy('text', 'asc')->simplePaginate(10);

        if (count($symbols)) {
            $morePages = true;
            if (empty($symbols->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $symbols->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );

            return response()->json($results);
        }

        return File::get($this->jsonFileStorePath);
    }
    /**
     * storeCompanySymbolListJsonFile
     *
     * @return stdClass
     */
    public function storeCompanySymbolListJsonFile(): stdClass
    {

        $data = [];
        foreach ($this->jsonData as $key => $value) {
            $data[$key]['id'] = $value['Symbol'];
            $data[$key]['text'] = $value['Symbol'] . '  :  ' . $value['Company Name'];
        }

        File::put($this->jsonFileStorePath, json_encode(["results" => $data]));

        return json_decode(File::get($this->jsonFileStorePath));
    }


    /**
     * storeCompanySymbolListDb
     *
     * @return void
     */
    public function storeCompanySymbolListDb(): void
    {

        foreach ($this->jsonData as $value) {
            CompanySymbolList::firstOrCreate(
                [
                    'id'             => $value['Symbol'],
                ],
                [
                    'text'           =>  $value['Symbol'] . '  :  ' . $value['Company Name'],
                ]
            );
        }
    }
}
