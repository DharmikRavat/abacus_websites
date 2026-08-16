<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Customer;
use App\Models\StudentCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    /**
     * Display Listing
     */
    public function index()
    {
        $certificates = StudentCertification::with('student')->latest()->get();
        $students = Customer::where('role', 'student')
        ->where('isActive', 1)
        ->get();

        return view('admin.certification.index', compact('certificates','students'));
    }

    /**
     * Store Certificate
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'title'                 => 'required|string|max:255',
            'student_enrollment_id' => 'required|string|max:100',
            'file'                  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }
    
        try {
    
            $path = null;
    
            if ($request->hasFile('file')) {
    
                $file = $request->file('file');
    
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
                $destination = public_path('student-certificates');
    
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
    
                $file->move($destination, $fileName);
    
                $path = 'student-certificates/' . $fileName;
            }
    
            $certificate = StudentCertification::create([
                'certificate_unique_id' => 'CERT' . date('YmdHis') . rand(100, 999),
                'title'                 => $request->title,
                'file'                  => $path,
                'student_enrollment_id' => $request->student_enrollment_id,
                'added_by'              => auth()->id(),
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Certificate uploaded successfully.',
                'data'    => $certificate
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit
     */
    public function edit($id)
    {
        $certificate = StudentCertification::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $certificate
        ]);
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'title'                 => 'required|string|max:255',
            'student_enrollment_id' => 'required|string|max:100',
            'file'                  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }
    
        try {
    
            $certificate = StudentCertification::findOrFail($id);
    
            $data = [
                'title'                 => $request->title,
                'student_enrollment_id' => $request->student_enrollment_id,
            ];
    
            if ($request->hasFile('file')) {
    
                if ($certificate->file && file_exists(public_path($certificate->file))) {
                    unlink(public_path($certificate->file));
                }
    
                $file = $request->file('file');
    
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
                $destination = public_path('student-certificates');
    
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
    
                $file->move($destination, $fileName);
    
                $data['file'] = 'student-certificates/' . $fileName;
            }
    
            $certificate->update($data);
    
            return response()->json([
                'success' => true,
                'message' => 'Certificate updated successfully.',
                'data'    => $certificate
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Download Certificate
     */
    public function download($id)
    {
        $certificate = StudentCertification::findOrFail($id);
    
        $filePath = public_path($certificate->file);
    
        if (!file_exists($filePath)) {
            abort(404, 'Certificate not found.');
        }
    
        return response()->download(
            $filePath,
            $certificate->title . '.' . pathinfo($certificate->file, PATHINFO_EXTENSION)
        );
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        try {
    
            $certificate = StudentCertification::findOrFail($id);
    
            if ($certificate->file && file_exists(public_path($certificate->file))) {
                unlink(public_path($certificate->file));
            }
    
            $certificate->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully.'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}