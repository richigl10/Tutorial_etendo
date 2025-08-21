<?php

namespace App\Http\Controllers;

use App\Models\Module;

class ProgressController extends Controller
{
    public function index()
    {
        $modules = Module::with('videos')->get()->map(function($module) {
            $totalVideos = $module->videos->count();
            $completedVideos = $module->videos->where('completed', true)->count();

            return (object) [
                'id' => $module->id,
                'name' => $module->name,
                'total_videos' => $totalVideos,
                'completed_videos' => $completedVideos,
                'progress' => $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0,
                'videos' => $module->videos
            ];
        });

        $totalModules = $modules->count();
        $completedModules = $modules->where('progress', 100)->count();
        $totalVideos = $modules->sum('total_videos');
        $completedVideos = $modules->sum('completed_videos');
        $globalProgress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;

        return view('progress.progress', compact(
            'modules',
            'totalModules',
            'completedModules',
            'totalVideos',
            'completedVideos',
            'globalProgress'
        ));
    }
}
