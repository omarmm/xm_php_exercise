<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySymbolList extends Model
{
    use HasFactory;

    protected $table = 'companies_symbols';
    public $incrementing = false;

    protected $guarded = []; 

    public function getCompanyNameAttribute($value)
    {

        $pos = strpos($this->text, ':');
        return substr($this->text, $pos+1);
    }

}
