<?php

namespace App\Http\Controllers;

use App\Services\DjangoApiService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $api = new DjangoApiService();
        $response = $api->get('product-types/');
        $productTypes = $response->successful() ? $response->json() : [];
        return view('product-types.index', compact('productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $api = new DjangoApiService();

        $response = $api->post('product-types/', $request->only('name', 'description', 'requires_prescription', 'requires_expiration'));

        if ($response->successful()) {
            return Redirect::route('product-types.index')->with('success', 'Proudct Type created!');
        }

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

            return Redirect::route('product-types.create')->withErrors($errors);
        }

        return Redirect::route('product-types.create')->with('error', 'Failed to connect to API.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
