<?php

namespace App\Http\Controllers;

use App\TaskModel;
use App\DataRowsModel;
use App\WorkflowModel;
use Illuminate\Http\Request;
use App\ValidationRulesModel;

class AdminController extends Controller
{
    protected $Workflow;

    protected $dataRow;

    protected $task;

    protected $validationRule;

    public function __construct(
        WorkflowModel $Workflow, 
        DataRowsModel $dataRow,
        ValidationRulesModel $validationRule,
        TaskModel $task
        ) {
        $this->Workflow = $Workflow;
        $this->dataRow = $dataRow;
        $this->validationRule = $validationRule;
        $this->task = $task;    
    }

    public function showWorkflow() {
        $workflow = $this->Workflow->getWorkflow();
        $processes = $this->createProcessOutput($workflow);
        // dd($processes);
        return view('admin.workflow.index',compact('processes') );
    }

     private function createProcessOutput($processes) {
        $output = [];
        foreach ($processes as $process) {
            if (array_key_exists($process['name'], $output)) {
                $output[$process['name']] += [
                        // $process['task'] => [
                                        'id'    => $process['id'],
                                        'action'=> $process['action'],
                                        'order'=> $process['order'],
                                    // ]
                    ];
            } else {
                $output[$process['name']] = [
                                // $process['task'] => [
                                    'id'    => $process['id'],
                                    'action'=> $process['action'],
                                    'order'=> $process['order'],
                                // ]
                    ];
            }
        }
        return $output;
    }

    public function workflow($process) {
        $tasks = $this->task->getTasksByProcessId($process);
        return view('admin.workflow.single',compact('tasks'));

    }

    public function showform(Request $request) {
        return $this->dataRow->getFormByWorkflowId($request->task_id);
    }

    public function createForm()  {
        $process = $this->Workflow->getAllProcess();
        $validation_rules = $this->validationRule->getAll();
        return view('admin.workflow.createform',compact('process','validation_rules'));
    }

    public function getform(Request $request) {
        return $this->task->getTasksByProcessId($request->process);
    }

    public function createField(Request $request) {
        
        $this->validate($request, [
            'process_id'       => 'required',
            'order'            => 'required',
            'name'             => 'required',
            'type'             => 'required',
            'validation_rule'  => 'required',
            'label'            => 'required'
        ]);   

        return $this->dataRow->create_field($request->all());
    }

    public function getfields(Request $request) {
        $task = $this->task->getfields($request->all());
        return view('admin.workflow.form-fields',compact('task'))->render();
    }
}
