<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $hero = HeroSection::firstOrCreate(
            ['id' => 1],
            [
                'brand_name' => "Sazzad's Dev.",
                'name' => "Sazzad Hossain",
                'work_details' => "Senior Full-Stack Developer",
                'description' => "Crafting elegant & high performance web software.",
            ]
        );
        $projects = \App\Models\Project::orderBy('sort_order', 'asc')->get();
        $categories = \App\Models\Category::orderBy('name', 'asc')->get();
        $experiences = \App\Models\Experience::orderBy('sort_order', 'asc')->get();
        return view('admin.dashboard', compact('hero', 'projects', 'categories', 'experiences'));
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'work_details' => 'required|string|max:255',
            'description' => 'nullable|string',
            'consultancy_button_text' => 'nullable|string|max:255',
            'consultancy_button_url' => 'nullable|string|max:255',
            'talk_button_text' => 'nullable|string|max:255',
            'talk_button_url' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'video' => 'nullable|mimes:mp4,webm,ogg|max:51200',
        ]);

        $hero = HeroSection::firstOrCreate(['id' => 1]);

        $data = [
            'brand_name' => $request->brand_name,
            'name' => $request->name,
            'work_details' => $request->work_details,
            'description' => $request->description,
            'consultancy_button_text' => $request->consultancy_button_text ?? "GET FREE CONSULTANCY",
            'consultancy_button_url' => $request->consultancy_button_url ?? "#contact",
            'talk_button_text' => $request->talk_button_text ?? "LET'S TALK",
            'talk_button_url' => $request->talk_button_url ?? "#contact",
        ];

        if ($request->filled('cropped_avatar')) {
            if ($hero->avatar_path && Storage::disk('public')->exists($hero->avatar_path)) {
                Storage::disk('public')->delete($hero->avatar_path);
            }
            $imgData = $request->cropped_avatar;
            if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $type)) {
                $imgData = substr($imgData, strpos($imgData, ',') + 1);
                $type = strtolower($type[1]);
                $imgData = base64_decode($imgData);
                $fileName = 'portfolio/avatar_' . time() . '.' . ($type === 'jpeg' ? 'jpg' : $type);
                Storage::disk('public')->put($fileName, $imgData);
                $data['avatar_path'] = $fileName;
            }
        } elseif ($request->hasFile('avatar')) {
            if ($hero->avatar_path && Storage::disk('public')->exists($hero->avatar_path)) {
                Storage::disk('public')->delete($hero->avatar_path);
            }
            $avatarPath = $request->file('avatar')->store('portfolio', 'public');
            $data['avatar_path'] = $avatarPath;
        }

        if ($request->hasFile('video')) {
            if ($hero->video_path && Storage::disk('public')->exists($hero->video_path)) {
                Storage::disk('public')->delete($hero->video_path);
            }
            $videoPath = $request->file('video')->store('portfolio', 'public');
            $data['video_path'] = $videoPath;
        }

        $hero->update($data);

        return redirect()->back()->with('success', 'Hero section updated successfully!');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'category_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'live_website_url' => 'nullable|string|max:255',
            'live_mobile_app_url' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:5120',
            'detail_images.*' => 'nullable|image|max:5120',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('projects', 'public');
        }

        $detailPaths = [];
        if ($request->hasFile('detail_images')) {
            foreach ($request->file('detail_images') as $file) {
                $detailPaths[] = $file->store('projects/gallery', 'public');
            }
        }

        $maxSort = \App\Models\Project::max('sort_order') ?? 0;

        \App\Models\Project::create([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'category_tags' => $request->category_tags,
            'cover_image' => $coverPath,
            'detail_images' => $detailPaths,
            'description' => $request->description,
            'live_website_url' => $request->live_website_url,
            'live_mobile_app_url' => $request->live_mobile_app_url,
            'sort_order' => $maxSort + 1,
            'is_featured' => $request->has('is_featured') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Project created successfully!');
    }

    public function updateProject(Request $request, $id)
    {
        $project = \App\Models\Project::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'category_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'live_website_url' => 'nullable|string|max:255',
            'live_mobile_app_url' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:5120',
            'detail_images.*' => 'nullable|image|max:5120',
        ]);

        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'category_tags' => $request->category_tags,
            'description' => $request->description,
            'live_website_url' => $request->live_website_url,
            'live_mobile_app_url' => $request->live_mobile_app_url,
            'is_featured' => $request->has('is_featured') ? true : false,
        ];

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        if ($request->hasFile('detail_images')) {
            $existingDetails = $project->detail_images ?? [];
            foreach ($request->file('detail_images') as $file) {
                $existingDetails[] = $file->store('projects/gallery', 'public');
            }
            $data['detail_images'] = $existingDetails;
        }

        $project->update($data);

        return redirect()->back()->with('success', 'Project updated successfully!');
    }

    public function deleteProject($id)
    {
        $project = \App\Models\Project::findOrFail($id);
        if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
            Storage::disk('public')->delete($project->cover_image);
        }
        if ($project->detail_images) {
            foreach ($project->detail_images as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
        $project->delete();

        return redirect()->back()->with('success', 'Project deleted successfully!');
    }

    public function reorderProjects(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:projects,id',
        ]);

        foreach ($request->order as $index => $id) {
            \App\Models\Project::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Project order updated successfully!']);
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function storeExperience(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:5120',
        ]);

        $logoPath = null;
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('experiences', 'public');
        }

        $maxSort = \App\Models\Experience::max('sort_order') ?? 0;

        \App\Models\Experience::create([
            'company_name' => $request->company_name,
            'location' => $request->location,
            'designation' => $request->designation,
            'duration' => $request->duration,
            'company_logo' => $logoPath,
            'sort_order' => $maxSort + 1,
        ]);

        return redirect()->back()->with('success', 'Experience created successfully!');
    }

    public function updateExperience(Request $request, $id)
    {
        $experience = \App\Models\Experience::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:5120',
        ]);

        $data = [
            'company_name' => $request->company_name,
            'location' => $request->location,
            'designation' => $request->designation,
            'duration' => $request->duration,
        ];

        if ($request->hasFile('company_logo')) {
            if ($experience->company_logo && Storage::disk('public')->exists($experience->company_logo)) {
                Storage::disk('public')->delete($experience->company_logo);
            }
            $data['company_logo'] = $request->file('company_logo')->store('experiences', 'public');
        }

        $experience->update($data);

        return redirect()->back()->with('success', 'Experience updated successfully!');
    }

    public function deleteExperience($id)
    {
        $experience = \App\Models\Experience::findOrFail($id);
        if ($experience->company_logo && Storage::disk('public')->exists($experience->company_logo)) {
            Storage::disk('public')->delete($experience->company_logo);
        }
        $experience->delete();

        return redirect()->back()->with('success', 'Experience deleted successfully!');
    }

    public function reorderExperiences(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:experiences,id',
        ]);

        foreach ($request->order as $index => $id) {
            \App\Models\Experience::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Experience order updated successfully!']);
    }
}
