<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Http\Requests\ModuleRequest;
use App\Services\ModuleService;

class ModuleController extends Controller
{

    private $service;

    public function __construct(ModuleService $service){
        $this->service = $service;
    }

    public function createModule(ModuleRequest $request){
        $module = Module::create($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Module created successfully.',
            'data' => [
                'id' => $module->id
            ]
        ], 201);
    }

    public function downloadModule($id){
        $module = Module::findOrFail($id);
        return $this->service->downloadModule($module);
    }
}
