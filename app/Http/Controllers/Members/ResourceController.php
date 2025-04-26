<?php

namespace App\Http\Controllers\Members;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;
use App\Models\Jumuiya;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Resource::query();
    
        // Filter by type if provided and not 'all'
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
    
        $resources = $query->latest()->paginate(10);
    
        return view('member.resources.index', compact('resources'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.resources.create', [
            'jumuiyas' => Jumuiya::all() // Fetch all jumuiyas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request)
    {
        Resource::create([
            'jumuiya_id' => $request->jumuiya_id,
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        return view('admin.resources.show', [
            'resource' => $resource->load(['jumuiya'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        return view('admin.resources.edit', [
            'resource' => $resource->load(['jumuiya']),
            'jumuiyas' => Jumuiya::all() // Fetch all jumuiyas for editing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        // Update logic (if needed)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        // Delete the resource from storage
        $resource->delete();

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource deleted successfully');
    }

    /**
     * Download the specified resource.
     */
    public function download(Resource $resource): StreamedResponse
    {
        // Check if the resource file exists
        if (!Storage::exists($resource->file_path)) {
            abort(404, 'Resource file not found.');
        }

        // Check if the logged-in user belongs to the same jumuiya as the resource
        if ($resource->jumuiya_id != auth()->user()->member->jumuiya_id) {
            abort(403, 'You do not have permission to download this resource.');
        }

        // Return the file as a download response
        return Storage::download($resource->file_path, $resource->original_filename);
    }
}
