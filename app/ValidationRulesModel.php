<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValidationRulesModel extends Model
{
    protected $table = 'validation_rules';

    public function getAll() {
        return self::orderBy('name','asc')->get();
    }

    public function datarows() {
        return $this->belongsToMany('App\DataRowsModel','data_row_validation','validation_id','data_row_id');
    }

}
