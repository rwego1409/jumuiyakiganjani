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
        $user = auth()->user();
        $query = Resource::query();

        // Only show resources for the member's jumuiya or created by admin
        if ($user->hasRole('member')) {
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
        $data = $request->only(['jumuiya_id', 'name', 'type', 'description', 'status']);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('resources', 'public'); // stores in storage/app/public/resources
            $data['file_path'] = $path;
            $data['original_filename'] = $file->getClientOriginalName();
        }

        Resource::create($data);

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
        // Verify the resource exists
        if (!Storage::exists($resource->file_path)) {
            abort(404);
        }
        return Storage::download($resource->file_path, $resource->original_filename);
    }
}
