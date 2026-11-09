<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Schema::hasTable('projects')
            ? Project::published()->orderBy('sort_order')->orderByDesc('updated_at')->get()
            : collect();

        return view('pages.projects', compact('projects'));
    }
}
