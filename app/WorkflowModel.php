<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class WorkflowModel extends Model
{
    protected $table = 'app_process';


    public function getWorkflow($id = null) {
        return self::orderBy('order','asc')->get();
    }

    public function findWorkflow($process_id) {
        return self::select(DB::raw('id, task, order, action'))->where('process',$process)->get();
    }

    public function getAllProcess() {
        return self::orderBy('order','asc')->get();
    }

    public function tasks() {
        return $this->hasMany('App\TaskModel','process_id');
    }
 
}
