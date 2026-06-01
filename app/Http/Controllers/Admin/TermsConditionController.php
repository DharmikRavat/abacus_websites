<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsCondition;
use Illuminate\Http\Request;

class TermsConditionController extends Controller
{
    /**
     * Show Terms & Conditions Page
     */
    public function index()
    {
        $terms = TermsCondition::first();

        // Create default row if not exists
        if (!$terms) {
            $terms = TermsCondition::create([
                'title' => 'Terms & Conditions',
            ]);
        }

        return view('admin.terms-conditions.index', compact('terms'));
    }

    /**
     * Update Terms & Conditions
     */
    public function update(Request $request)
    {
        $terms = TermsCondition::first();

        if (!$terms) {
            $terms = TermsCondition::create([
                'title' => 'Terms & Conditions',
            ]);
        }

        $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $terms->update([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->has('status'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Terms & Conditions updated successfully.');
    }
}
