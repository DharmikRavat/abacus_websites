<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Show Privacy Policy Page
     */
    public function index()
    {
        $policy = PrivacyPolicy::first();

        // Create default row if not exists
        if (!$policy) {
            $policy = PrivacyPolicy::create([
                'title' => 'Privacy Policy',
            ]);
        }

        return view('admin.privacy-policy.index', compact('policy'));
    }

    /**
     * Update Privacy Policy
     */
    public function update(Request $request)
    {
        $policy = PrivacyPolicy::first();
    
        if (!$policy) {
            $policy = PrivacyPolicy::create([
                'title' => 'Privacy Policy',
            ]);
        }
    
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $policy->update([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->has('status'),
        ]);
    
        return redirect()
            ->back()
            ->with('success', 'Privacy Policy updated successfully.');
    }
}
