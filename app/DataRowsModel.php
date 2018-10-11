<?php

namespace App;

use App\DataRowsModel;
use App\ValidationRulesModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DataRowsModel extends Model
{
    protected $table = 'data_rows';

    protected $foreignKey = 'task_id';

    protected $fillable = [
        'name',
        'process_id',
        'type',
        'label',
        'order',
        'validation_rule'
    ];
    public function getFormByWorkflowId($id) {
         return self::select(DB::raw('*'))->where('process_id',$id)->orderBy('order','asc')->get();   
    }

    public function create_field($attributes) {

        $rules = json_decode($attributes['validation_rule']);
        
        $attributes['validation_rule'] = $this->checkRulesArray($rules);

        return self::create($attributes);
    }

    /**
     * function to set value, rule and message in the validation rule array
     *
     * @param [type] $rules
     *
     * @return void
     */
    private function checkRulesArray($rules) {
        $new_rules = [];
        foreach($rules as $key => $rule) {
            
            $new_rules[$key] = ['rule'=>$rule->rule];
            
            $value  = !property_exists($rule,'value') ? ['value'=>null] : ['value'=>$rule->value];
            
            $new_rules[$key] = array_merge($new_rules[$key],$value);

            $message = !property_exists($rule,'message') ? [ 'message'=>null] : [ 'message'=>$rule->message];
          
            $new_rules[$key] = array_merge($new_rules[$key], $message);
        }
        return json_encode($new_rules);
    }

    public function tasks() {
        return $this->belongsTo('App\TaskModel');
    }

    public function validations() {
        return $this->belongsToMany('App\ValidationRulesModel','data_row_validation','data_row_id','validation_id');
    }
}
