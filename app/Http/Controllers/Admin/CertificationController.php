<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        $certifications = Certification::latest()->get();

        return view('admin.certification.index', compact('certifications'));
    }

    /**
     * Store Certification
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [

            'trainer_name'     => 'nullable|string|max:255',
            'certificate_date' => 'nullable|date',
            'level'             => 'nullable|string|max:255',

            'student_name'     => 'required|string|max:255',
            'parents_name'     => 'nullable|string|max:255',
            'mobile_no'        => 'nullable|string|max:20',
            'exam_date'        => 'nullable|date',

            'score'            => 'nullable|numeric',
            'result'           => 'nullable|string|max:255',

            'address'          => 'nullable|string',
            'receiver_contact' => 'nullable|string|max:20',

            'address_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'certificate_image'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'dispatch_date'    => 'nullable|date',
            'dispatch_id'      => 'nullable|string|max:255',

            'received_date'    => 'nullable|date',
            'remark'           => 'nullable|string',

            'download_type'    => 'nullable|string|max:50',

        ]);

        // Validation Error
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {

            $data = $request->all();

            // Upload Address Image
            if ($request->hasFile('address_image')) {

                $data['address_image'] = $request
                    ->file('address_image')
                    ->store('certifications/address', 'public');
            }

            // Upload Certificate Image
            if ($request->hasFile('certificate_image')) {

                $data['certificate_image'] = $request
                    ->file('certificate_image')
                    ->store('certifications/certificate', 'public');
            }

            $certification = Certification::create($data);

            return response()->json([
                'success'       => true,
                'message'       => 'Certification created successfully.',
                'certification' => $certification
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show Single
     */
    public function showCertificate($id)
    {
        $certification = Certification::findOrFail($id);
    
        return view(
            'admin.certification.view',
            compact('certification')
        );
    }

    /**
     * Edit
     */
    public function edit($id)
    {
        try {

            $certification = Certification::findOrFail($id);

            return response()->json([
                'success'       => true,
                'certification' => $certification
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Certification not found'
            ], 404);
        }
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [

            'trainer_name'     => 'nullable|string|max:255',
            'certificate_date' => 'nullable|date',
            'level'             => 'nullable|string|max:255',

            'student_name'     => 'required|string|max:255',
            'parents_name'     => 'nullable|string|max:255',
            'mobile_no'        => 'nullable|string|max:20',
            'exam_date'        => 'nullable|date',

            'score'            => 'nullable|numeric',
            'result'           => 'nullable|string|max:255',

            'address'          => 'nullable|string',
            'receiver_contact' => 'nullable|string|max:20',

            'address_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'certificate_image'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'dispatch_date'    => 'nullable|date',
            'dispatch_id'      => 'nullable|string|max:255',

            'received_date'    => 'nullable|date',
            'remark'           => 'nullable|string',

            'download_type'    => 'nullable|string|max:50',

        ]);

        // Validation Error
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {

            $certification = Certification::findOrFail($id);

            $data = $request->all();

            // Update Address Image
            if ($request->hasFile('address_image')) {

                // Delete old image
                if ($certification->address_image &&
                    Storage::disk('public')->exists($certification->address_image)) {

                    Storage::disk('public')
                        ->delete($certification->address_image);
                }

                $data['address_image'] = $request
                    ->file('address_image')
                    ->store('certifications/address', 'public');
            }

            // Update Certificate Image
            if ($request->hasFile('certificate_image')) {

                // Delete old image
                if ($certification->certificate_image &&
                    Storage::disk('public')->exists($certification->certificate_image)) {

                    Storage::disk('public')
                        ->delete($certification->certificate_image);
                }

                $data['certificate_image'] = $request
                    ->file('certificate_image')
                    ->store('certifications/certificate', 'public');
            }

            $certification->update($data);

            return response()->json([
                'success'       => true,
                'message'       => 'Certification updated successfully.',
                'certification' => $certification
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        try {

            $certification = Certification::findOrFail($id);

            // Delete Address Image
            if ($certification->address_image &&
                Storage::disk('public')->exists($certification->address_image)) {

                Storage::disk('public')
                    ->delete($certification->address_image);
            }

            // Delete Certificate Image
            if ($certification->certificate_image &&
                Storage::disk('public')->exists($certification->certificate_image)) {

                Storage::disk('public')
                    ->delete($certification->certificate_image);
            }

            $certification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certification deleted successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Delete failed'
            ], 500);
        }
    }
}