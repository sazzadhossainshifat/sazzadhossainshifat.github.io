<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Project;
use App\Models\Category;
use App\Models\Experience;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $hero = HeroSection::first() ?? new HeroSection();
        $projects = Project::where('is_featured', true)->orderBy('sort_order', 'asc')->get();
        $experiences = Experience::orderBy('sort_order', 'asc')->get();
        return view('portfolio.index', compact('hero', 'projects', 'experiences'));
    }

    public function projects(Request $request)
    {
        $hero = HeroSection::first() ?? new HeroSection();
        $categories = Category::orderBy('name', 'asc')->get();
        
        $query = Project::orderBy('sort_order', 'asc');
        
        if ($request->has('category') && !empty($request->category)) {
            $catName = $request->category;
            $query->where('category_tags', 'LIKE', "%{$catName}%");
        }

        $projects = $query->get();
        $selectedCategory = $request->category ?? '';

        return view('portfolio.projects', compact('hero', 'projects', 'categories', 'selectedCategory'));
    }
}
