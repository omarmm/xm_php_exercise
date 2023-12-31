<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoricalDataRequest;
use App\Jobs\SendEmailJob;
use App\Models\CompanySymbolList;
use App\Services\CompanySymbolService;
use App\Services\HistoricalDataApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use File;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $companySymbolService;
    protected $historicalDataApiService;


    /**
     * __construct
     *
     * @param  mixed $companySymbolService
     * @param  mixed $historicalDataApiService
     * @return void
     */
    public function __construct(CompanySymbolService $companySymbolService, HistoricalDataApiService $historicalDataApiService)
    {
        $this->companySymbolService     = $companySymbolService;
        $this->historicalDataApiService = $historicalDataApiService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        return view('home');
    }

    /**
     * jsonSave
     *
     * @param  mixed $request
     * @return void
     */
    public function jsonSave(Request $request)
    {
        return $this->companySymbolService->getCompanySymbolList($request);
    }

    /**
     * historicalQuotes
     *
     * @param  mixed $request
     * @return void
     */
    public function historicalQuotes(HistoricalDataRequest $request)
    {
        $historicalQuotes = $this->historicalDataApiService->getData(
            $request->symbol,
            $request->start_date,
            $request->end_date
        );
        $companyName = CompanySymbolList::find($request->symbol)->company_name;
        if (!$historicalQuotes) {
            return redirect()->back()->with('msg', 'No records for Company:' . $companyName);
        }

        $dates = $opens = $closes = [];

        foreach ($historicalQuotes as $key => $value) {

            $dates[$key]  = $value['date'];
            $opens[$key]  = $value['open'];
            $closes[$key] = $value['close'];
        }
        dispatch(new SendEmailJob($request->email, $historicalQuotes, $request->start_date, $request->end_date, $companyName));
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        return view('historical_quotes.index', compact(
            'historicalQuotes',
            'companyName',
            'startDate',
            'endDate',
            'dates',
            'opens',
            'closes'
        ));
    }
}
