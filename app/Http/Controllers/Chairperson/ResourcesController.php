<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Resource::query();

        // Only show resources for the user's jumuiya or created by admin
        if ($user->hasRole('chairperson')) {
            $jumuiya = $user->jumuiyas()->first();
            if ($jumuiya) {
                $query->where(function($q) use ($jumuiya) {
                    $q->where('jumuiya_id', $jumuiya->id)
                      ->orWhere(function($q2) {
                          $q2->whereNull('jumuiya_id')
                             ->whereHas('creator', function($q3) {
                                 $q3->where('role', 'admin');
                             });
                      });
                });
            }
        } elseif ($user->hasRole('member')) {
            $member = $user->member;
            if ($member && $member->jumuiya_id) {
                $query->where(function($q) use ($member) {
                    $q->where('jumuiya_id', $member->jumuiya_id)
                      ->orWhereHas('creator', function($q2) {
                          $q2->where('role', 'admin');
                      });
                });
            }
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get the filtered resources with pagination
        $resources = $query->latest()->paginate(10);

        return view('chairperson.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chairperson.resources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:document,video,audio,image,other',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|file|max:10240' // 10MB max
        ]);

        // Get the chairperson's jumuiya
        $jumuiya = auth()->user()->jumuiyas()->first();
        if (!$jumuiya) {
            return redirect()->route('chairperson.resources.index')->with('error', 'No jumuiya assigned to your account.');
        }
        $validated['jumuiya_id'] = $jumuiya->id;
        $validated['created_by'] = auth()->id();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('resources', 'public');
            $validated['file_path'] = $filePath;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $resource = Resource::create($validated);

        return redirect()->route('chairperson.resources.show', $resource)
            ->with('success', __('Resource created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        return view('chairperson.resources.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        return view('chairperson.resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:document,video,audio,image,other',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|file|max:10240' // 10MB max
        ]);

        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            // Delete old file if it exists
            if ($resource->file_path && Storage::exists($resource->file_path)) {
                Storage::delete($resource->file_path);
            }

            $file = $request->file('file');
            $filePath = $file->store('resources', 'public');
            $validated['file_path'] = $filePath;
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $resource->update($validated);

        return redirect()->route('chairperson.resources.show', $resource)
            ->with('success', __('Resource updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        // Delete the file if it exists
        if ($resource->file_path && Storage::exists($resource->file_path)) {
            Storage::delete($resource->file_path);
        }

        $resource->delete();

        return redirect()->route('chairperson.resources.index')
            ->with('success', __('Resource deleted successfully.'));
    }

    /**
     * Download the resource file.
     */
    public function download(Resource $resource): StreamedResponse
    {
        if (!$resource->file_path || !\Storage::disk('public')->exists($resource->file_path)) {
            abort(404, __('Resource file not found.'));
        }
        return \Storage::disk('public')->download($resource->file_path, $resource->original_filename);
    }
}
