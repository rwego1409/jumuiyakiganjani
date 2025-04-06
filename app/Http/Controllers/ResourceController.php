<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;
use Symfony\Component\HttpFoundation\StreamedResponse;
class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $resources = Resource::paginate(10); // Paginate with 10 items per page
    return view('admin.resources.index', compact('resources'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.resources.create', [
            'jumuiyas' => Jumuiya::all()
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
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource deleted successfully');
    }

    public function download(Resource $resource): StreamedResponse
{
    // Verify the resource exists and user has permission
    if (!Storage::exists($resource->file_path)) {
        abort(404);
    }

    return Storage::download($resource->file_path, $resource->original_filename);
}
}
