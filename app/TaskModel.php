<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = 'app_tasks';

    public function getTasksByProcessId($id = null) {
        return self::where('process_id',$id)->orderBy('order','asc')->get();
    }

    public function datarows() {
        return $this->hasMany('App\DataRowsModel','task_id');
    }

    public function getfields($attributes) {
        return self::where(['id'=>$attributes['task_id']])->first();
    }
}
