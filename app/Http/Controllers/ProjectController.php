<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get active projects with pagination
        $projects = Project::where('is_active', true)
            ->orderBy('completion_date', 'desc')
            ->paginate(9);
        
        return view('pages.projects.index', compact('projects'));
    }
    
    /**
     * Display the specified project.
     *
     * @param  string  $slug  Project slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Find the project by slug
        $project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get related projects (excluding current project)
        $relatedProjects = Project::where('id', '!=', $project->id)
            ->where('is_active', true)
            ->take(3)
            ->get();
            
        return view('pages.projects.show', compact('project', 'relatedProjects'));
    }
}