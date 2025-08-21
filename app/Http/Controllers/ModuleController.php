<?php

namespace App\Http\Controllers;

use App\Models\Module;

class ModuleController extends Controller
{
    /**
     * Muestra todos los módulos disponibles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::withCount(['videos as completed_videos' => function($query) {
            $query->where('completed', true);
        }])->with('videos')->get();

        // Calcular progreso para cada módulo
        $modules->each(function ($module) {
            $module->progress = $module->videos->count() > 0
                ? round(($module->completed_videos / $module->videos->count()) * 100)
                : 0;
        });

        return view('modules.index', compact('modules'));
    }

    /**
     * Muestra un módulo específico con sus videos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currentModule = Module::with('videos')->findOrFail($id);
        $allModules = Module::all();

        return view('modules.show', compact('currentModule', 'allModules'));
    }
}
