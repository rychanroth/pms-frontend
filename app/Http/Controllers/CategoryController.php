<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DjangoApiService;
use App\Traits\InteractsWithApi;

class CategoryController extends Controller
{
    use InteractsWithApi;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $api = new DjangoApiService();
        $response = $api->get('categories/');
        $categories = $response->successful() ? $response->json() : [];
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $api = new DjangoApiService();
        $productTypes = $api->get('product-types/')->json() ?? [];
        $categoryTree = [];
        return view('categories.form', compact('productTypes', 'categoryTree'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $api = new DjangoApiService();
        $payload = $request->only('name', 'product_type_id', 'parent_id');
        $payload['parent_id'] = $payload['parent_id'] ?: null; // Convert empty string to null

        $response = $api->post('categories/', $payload);
        return $this->handleApiSave($response, 'categories.index', $request);
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
        $category = $api->get("categories/{$id}/")->json();
        $productTypes = $api->get('product-types/')->json() ?? [];

        // FIX: Extract ID from the nested read-only 'product_type' object
        $ptId = $category['product_type']['id'] ?? null;

        // FIX: Django's ViewSet strictly expects 'product_type', not 'product_type_id'
        $categoryTree = $ptId ? $api->get("categories/tree/?product_type={$ptId}")->json() ?? [] : [];

        return view('categories.form', compact('category', 'productTypes', 'categoryTree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $api = new DjangoApiService();
        $payload = $request->only('name', 'product_type_id', 'parent_id');
        $payload['parent_id'] = $payload['parent_id'] ?: null;

        $response = $api->put("categories/{$id}/", $payload);
        return $this->handleApiSave($response, 'categories.index', $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $api = new DjangoApiService();
        $api->withToken()->delete("{$api->baseUrl}/categories/{$id}/");
        return redirect()->route('categories.index')->with('success', 'Deleted.');
    }

    /**
     * ===== CUSTOM FUNCTIONS ===
     */
    public function getTree(Request $request)
    {
        $api = new DjangoApiService();
        
        // FIX: Match what the JS sends AND what Django's ViewSet expects
        $ptId = $request->query('product_type');

        if (!$ptId) {
            return response()->json([]);
        }

        $response = $api->get("categories/tree/?product_type={$ptId}");

        return response()->json($response->json() ?? []);
    }
}
