<?php

namespace App\Console\Commands;

use App\Services\CompanySymbolService;
use Illuminate\Console\Command;

class FetchCompanySymbols extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:symbols';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $companySymbolService;


    public function __construct(CompanySymbolService $companySymbolService) {
        parent::__construct();
        $this->companySymbolService = $companySymbolService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->companySymbolService->storeCompanySymbolListJsonFile();
        $this->companySymbolService->storeCompanySymbolListDb();
    }
}
