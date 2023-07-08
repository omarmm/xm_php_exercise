<?php

namespace Tests\Unit;

use App\Services\CompanySymbolService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use File;
class CompanySymbolTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGettingSymbolsFromJsonFileIfDBNotExist()
    {
        $result =(new CompanySymbolService())->getCompanySymbolList();

         $path =   public_path('/companies_symbols.json');
         $expected_file = File::get( $path);

         $this->assertJsonStringEqualsJsonString($expected_file ,$result );
    }

    public function teststoreCompanySymbolListJsonFile()
    {
        $result =(new CompanySymbolService())->storeCompanySymbolListJsonFile();

         $this->assertIsObject($result);
    }

    public function testGettingSymbols()
    {
        $result =(new CompanySymbolService())->getCompanySymbolList();


         $this->assertNotEmpty($result );
    }
}
