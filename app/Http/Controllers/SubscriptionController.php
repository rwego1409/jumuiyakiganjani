<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumuiya;

class SubscriptionController extends Controller
{
    public function create()
    {
        return view('subscription.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumuiya_name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'submitter_name' => 'required|string|max:255',
            'submitter_contact' => 'required|string|max:255',
        ]);

        // Combine address fields into a single location string
        $location = $validated['region'] . ', ' . $validated['district'] . ', ' . $validated['ward'] . ', ' . $validated['street'] . ', ' . $validated['address'];

        // Save the Jumuiya (add fields as needed)
        $jumuiya = Jumuiya::create([
            'name' => $validated['jumuiya_name'],
            'location' => $location,
            'description' => $validated['description'],
            'created_by_name' => $validated['submitter_name'],
            'created_by_contact' => $validated['submitter_contact'],
        ]);

        // Redirect to confirmation page
        return view('subscription.confirmation');
    }
}
