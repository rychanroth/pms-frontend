<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DjangoApiService;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    public function index()
    {
        $api = new DjangoApiService();
        $response = $api->get('suppliers/');

        if ($response->successful()) {
            $suppliers = $response->json();
        } else {
            $suppliers = [];
        }

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $api = new DjangoApiService();

        // Send POST request to Django
        $response = $api->post('suppliers/', $request->only('name', 'phone', 'address'));

        if ($response->successful()) {
            // If Django saved it successfully (returns 201), redirect back to list
            return Redirect::route('suppliers.index')->with('success', 'Supplier created!');
        }

        // THE WALL: If Django rejects it (returns 400 Bad Request)
        if ($response->status() === 400) {
            $errors = $response->json(); // Example: {"name": ["This field is required."]}

            // Loop through Django's JSON errors and flash them to Laravel's session
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    // This feeds the @error('name') directive in our Blade form!
                    $request->session()->flash("errors.$field", $message);
                }
            }

            // Flash the old input so the form isn't empty
            $request->session()->flash('_old_input', $request->all());

            return Redirect::route('suppliers.create')->withErrors($errors);
        }

        // Catch-all for server errors (500)
        return Redirect::route('suppliers.create')->with('error', 'Failed to connect to API.');
    }
}
