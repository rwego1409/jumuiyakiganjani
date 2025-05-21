<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use App\Models\User;
use App\Models\Jumuiya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\MembersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\UserCredentials;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'jumuiya'])
            ->whereHas('user')
            ->whereHas('jumuiya')
            ->get();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $jumuiyas = Jumuiya::all();
        return view('admin.members.create', compact('jumuiyas'));
    }

    public function importForm()
    {
        return view('admin.members.import');
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx|max:2048',
        ]);

        // Import the members using Maatwebsite Excel package
        try {
            Excel::import(new MembersImport, $request->file('file'));
            return redirect()->route('admin.members.index')->with('success', 'Members imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import members: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'password' => 'required|string|confirmed|min:8',
            'status' => 'nullable|string',
            'joined_date' => 'nullable|date',
        ]);

        // Create user account with role as 'member'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
            'role' => 'member', // Set default role as member
        ]);

        // Create the associated member record
        $member = Member::create([
            'user_id' => $user->id,
            'jumuiya_id' => $request->jumuiya_id,
            'phone' => $request->phone,
            'status' => $request->status ?? 'active',
            'joined_date' => $request->joined_date ?? now(),
        ]);

        // Optionally send email with credentials
        if ($request->has('send_credentials') && $request->send_credentials) {
            $plainPassword = $request->password; // Get the plain password before it's hashed
            Mail::to($user->email)->send(new UserCredentials($user, $plainPassword));
        }

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
    }

    public function show(Member $member)
    {
        $member->load('user', 'jumuiya', 'contributions');
        return view('admin.members.show', compact('member'));
    }

    public function edit($id)
    {
        $member = Member::with('user', 'jumuiya')->findOrFail($id);
        $jumuiyas = Jumuiya::all();
        return view('admin.members.edit', compact('member', 'jumuiyas'));
    }

    public function update(StoreMemberRequest $request, Member $member)
    {
        // Update user details
        $member->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
        ]);

        // Update member details
        $member->update([
            'jumuiya_id' => $request->jumuiya_id,
            'phone' => $request->phone,
            'status' => $request->status,
            'joined_date' => $request->joined_date
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member updated successfully');
    }

    public function destroy(Member $member)
    {
        // Check if member has contributions before deleting
        if ($member->contributions()->count() > 0) {
            return redirect()->route('admin.members.index')
                ->with('error', 'Cannot delete member with existing contributions');
        }

        $member->user->delete();
        $member->delete();
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully');
    }
}