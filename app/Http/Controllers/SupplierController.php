<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DjangoApiService;

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
    
}
