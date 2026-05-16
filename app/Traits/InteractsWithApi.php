<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

trait InteractsWithApi
{
    // Pass the Django response, the route to redirect to, and the request object
    protected function handleApiSave($response, $redirectRoute, Request $request)
    {
        if ($response->successful()) {
            return Redirect::route($redirectRoute)->with('success', 'Saved successfully!');
        }

        if ($response->status() === 400) {
            $errors = $response->json();
            
            // This single loop magically maps Django's JSON errors to Laravel's @error directive
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $request->session()->flash("errors.$field", $message);
                }
            }

            $request->session()->flash('_old_input', $request->all());
            return Redirect::route($redirectRoute)->withErrors($errors);
        }

        return Redirect::route($redirectRoute)->with('error', 'Server/API Error.');
    }
}