<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Jumuiya; // Or the correct namespace for your Jumuiya model
class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource with pagination
     */
    public function index()
    {
        $resources = Resource::orderBy('created_at', 'desc')
                      ->paginate(10); // 10 items per page

        return view('admin.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        $resourceTypes = [
            'document' => 'Document',
            'video' => 'Video',
            'audio' => 'Audio',
            'image' => 'Image',
            'other' => 'Other'
        ];

        $jumuiyas = \App\Models\Jumuiya::all();

        return view('admin.resources.create', compact('resourceTypes', 'jumuiyas'));
    }

    /**
     * Store a newly created resource with improved file handling
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:document,video,audio,image,other',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,jpeg,png,jpg,docx,mp4,mov,mp3,wav|max:20480',
            'jumuiya_id' => 'required|exists:jumuiyas,id' // Add validation
        ]);
    
        $file = $request->file('file');
        
        $resource = Resource::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'jumuiya_id' => $validated['jumuiya_id'], // Add this line
            'file_path' => $file->store('resources', 'public'),
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => round($file->getSize() / 1024),
            'file_extension' => $file->getClientOriginalExtension(),
        ]);
    
        return redirect()->route('admin.resources.show', $resource->id)
                       ->with('success', 'Resource created successfully');
    }
    /**
     * Display the specified resource with download count
     */
    public function show(string $id)
    {
        $resource = Resource::findOrFail($id);
        
        // Increment view count (optional)
        $resource->increment('view_count');
        
        return view('admin.resources.show', compact('resource'));
    }

    /**
     * Download the specified resource
     */
    // public function download(string $id)
    // {
    //     $resource = Resource::findOrFail($id);
    //     $filePath = storage_path('app/public/' . $resource->file_path);

    //     if (!file_exists($filePath)) {
    //         abort(404);
    //     }

    //     // Increment download count
    //     $resource->increment('download_count');

    //     return response()->download($filePath, $resource->original_filename);
    // }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(string $id)
    {
        $resource = Resource::findOrFail($id);
        $resourceTypes = [
            'document' => 'Document',
            'video' => 'Video',
            'audio' => 'Audio',
            'image' => 'Image',
            'other' => 'Other'
        ];

        return view('admin.resources.edit', compact('resource', 'resourceTypes'));
    }

    /**
     * Update the specified resource with file handling
     */
    public function update(Request $request, string $id)
    {
        $resource = Resource::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:document,video,audio,image,other',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,docx,mp4,mov,mp3,wav|max:20480'
        ]);

        $updateData = [
            'title' => $validated['title'],
            'type' => $validated['type'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::delete('public/' . $resource->file_path);

            // Store new file
            $file = $request->file('file');
            $filePath = $file->store('resources', 'public');
            
            $updateData = array_merge($updateData, [
                'file_path' => $filePath,
                'original_filename' => $file->getClientOriginalName(),
                'file_size' => round($file->getSize() / 1024),
                'file_extension' => $file->getClientOriginalExtension(),
            ]);
        }

        $resource->update($updateData);

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource with proper file cleanup
     */
    public function destroy(string $id)
    {
        $resource = Resource::findOrFail($id);

        // Delete associated file
        if ($resource->file_path) {
            Storage::delete('public/' . $resource->file_path);
        }

        $resource->delete();

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource deleted successfully');
    }

    public function download(Resource $resource)
{
    // Verify the resource exists and user has permission
    if (!$resource->exists) {
        abort(404);
    }

    $filePath = storage_path('app/' . $resource->file_path);
    
    if (!file_exists($filePath)) {
        abort(404, 'The requested file does not exist.');
    }

    return response()->download($filePath, $resource->original_name);
}
}