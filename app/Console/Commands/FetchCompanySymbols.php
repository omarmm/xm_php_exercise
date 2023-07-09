<?php

namespace App\Console\Commands;

use App\Models\CompanySymbolList;
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


    public function __construct(CompanySymbolService $companySymbolService)
    {
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
        //$this->companySymbolService->storeCompanySymbolListDb();

        $progressbar = $this->output->createProgressBar(count($this->companySymbolService->jsonData));
        $progressbar->start();
        foreach ($this->companySymbolService->jsonData as $value) {
            CompanySymbolList::firstOrCreate(
                [
                    'id'             => $value['Symbol'],
                ],
                [
                    'text'           =>  $value['Symbol'] . '  :  ' . $value['Company Name'],
                ]
            );
            sleep(1);
            $progressbar->advance();
        }
        $progressbar->finish();
    }
}
