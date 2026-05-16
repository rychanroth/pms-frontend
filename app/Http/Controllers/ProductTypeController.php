<?php

namespace App\Http\Controllers;

use App\Services\DjangoApiService;
use Illuminate\Http\Request;
use App\Traits\InteractsWithApi;

class ProductTypeController extends Controller
{
    use InteractsWithApi;
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
        return view('product-types.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $api = new DjangoApiService();
        $payload = $request->only('name', 'description');
        $payload['requires_prescription'] = $request->has('requires_prescription');
        $payload['requires_expiration'] = $request->has('requires_expiration');
        $response = $api->post("product-types/", $payload);
        return $this->handleApiSave($response, 'product-types.index', $request);
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
    public function edit($id)
    {
        $api = new DjangoApiService();
        $productType = $api->get("product-types/{$id}/")->json();
        return view('product-types.form', compact('productType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $api = new DjangoApiService();
        $payload = $request->only('name', 'description');
        $payload['requires_prescription'] = $request->has('requires_prescription');
        $payload['requires_expiration'] = $request->has('requires_expiration');
        $response = $api->put("product-types/{$id}/", $payload);
        return $this->handleApiSave($response, 'product-types.index', $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $api = new DjangoApiService();
        $api->withToken()->delete("{$api->baseUrl}/product-types/{$id}/");
        return redirect()->route('product-types.index')->with('success', 'Deleted.');
    }
}
