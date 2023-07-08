<?php

namespace App\Http\Controllers;

use App\Models\CompanySymbolList;
use App\Services\CompanySymbolService;
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

     protected $CompanySymbolService;

    public function __construct(CompanySymbolService $CompanySymbolService)
    {
        $this->CompanySymbolService = $CompanySymbolService;
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('home');
    }

    public function jsonSave(Request $request)
    {
        return $this->CompanySymbolService->getCompanySymbolList($request);

    }

    public function historicalQuotes()
    {
        $symbols = CompanySymbolList::paginate();

        return view('historical_quotes.index', compact('symbols'));
    }
}
