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

        // Members can see resources from their jumuiya and global admin resources
        if ($user->role === 'member') {
            $member = $user->member;
            if ($member && $member->jumuiya_id) {
                $jumuiyaId = $member->jumuiya_id;
                $query->where(function ($q) use ($jumuiyaId) {
                    $q->where('jumuiya_id', $jumuiyaId)
                      // Or global resources created by admin (not linked to any jumuiya)
                      ->orWhere(function ($q2) {
                          $q2->whereNull('jumuiya_id')
                             ->whereHas('creator', function ($q3) {
                                 $q3->where('role', 'admin');
                             });
                      });
                });
            } else {
                // If no jumuiya, only show global admin resources
                $query->whereNull('jumuiya_id')
                      ->whereHas('creator', function ($q) {
                          $q->where('role', 'admin');
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
        if (auth()->user()->role === 'member') abort(403);
        return view('admin.resources.create', [
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request)
    {
        if (auth()->user()->role === 'member') abort(403);
        $data = $request->only(['jumuiya_id', 'name', 'type', 'description', 'status']);
        $data['created_by'] = auth()->id();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('resources', 'public');
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
        return view('member.resources.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        if (auth()->user()->role === 'member') abort(403);
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
        if (auth()->user()->role === 'member') abort(403);
        $data = $request->only(['jumuiya_id', 'name', 'type', 'description', 'status']);

        if ($request->hasFile('file')) {
            if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
                Storage::disk('public')->delete($resource->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('resources', 'public');
            $data['file_path'] = $path;
            $data['original_filename'] = $file->getClientOriginalName();
        }

        $resource->update($data);

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        if (auth()->user()->role === 'member') abort(403);
        if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource deleted successfully');
    }

    /**
     * Download the resource file.
     */
    public function download(Resource $resource): StreamedResponse
    {
        if (!$resource->file_path || !Storage::exists($resource->file_path)) {
            abort(404, __('Resource file not found.'));
        }
        return Storage::download($resource->file_path, basename($resource->file_path));
    }
}
