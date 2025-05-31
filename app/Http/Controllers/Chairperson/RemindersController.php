<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class RemindersController extends Controller
{
    public function index()
    {
        // TODO: Fetch scheduled reminders for this chairperson's jumuiya
        $reminders = [];
        return view('chairperson.reminders.index', compact('reminders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reminder_type' => 'required|string',
            'message' => 'required|string',
            'send_at' => 'required|date',
            'recipient_type' => 'required|in:all,specific',
            // 'member_ids' => 'array' // If specific
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // TODO: Save reminder to DB and schedule WhatsApp job
        Session::flash('success', 'WhatsApp reminder scheduled successfully!');
        return redirect()->route('chairperson.reminders.index');
    }
}
