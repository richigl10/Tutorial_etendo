<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Module;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('videos');

        // Filtro por usuario
        if ($request->filled('user_id')) {
            $query->where('id', $request->user_id);
        }

        $users = $query->get();

        // Total de videos (todos o filtrados por módulo)
        if ($request->filled('module_id')) {
            $totalVideos = Video::where('module_id', $request->module_id)->count();
        } else {
            $totalVideos = Video::count();
        }

        // Traemos datos para los selects
        $allUsers = User::all();
        $modules = Module::select('id', 'name')->get();

        return view('admin.index', compact('users', 'totalVideos', 'allUsers', 'modules'));
    }
}
