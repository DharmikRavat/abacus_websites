<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FranchisePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FranchisePageController extends Controller
{
    /**
     * Display Page
     */
    public function index()
    {
        $franchise = FranchisePage::latest()->first();

        return view('admin.franchise.index', compact('franchise'));
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $request->validate([

            'title'                    => 'nullable|string',

            'training_description'     => 'nullable|string',

            'advantages_title'         => 'nullable|string',

            'advantages_description'   => 'nullable|string',

            'advantages_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'why_join_title'           => 'nullable|string',

            'why_join_description'     => 'nullable|string',

        ]);

        $folder = public_path('franchise');

        if (!File::exists($folder)) {
            File::makeDirectory($folder,0755,true);
        }

        $image = null;

        if($request->hasFile('advantages_image')){

            $file = $request->file('advantages_image');

            $filename = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();

            $file->move($folder,$filename);

            $image = 'franchise/'.$filename;

        }

        $franchise = FranchisePage::create([

            'title'                   => $request->title,

            'training_description'    => $request->training_description,

            'advantages_title'        => $request->advantages_title,

            'advantages_description'  => $request->advantages_description,

            'advantages_image'        => $image,

            'why_join_title'          => $request->why_join_title,

            'why_join_description'    => $request->why_join_description,

        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Franchise Page Created Successfully',
            'data'=>$franchise
        ]);
    }

    /**
     * Show
     */
    public function show($id)
    {
        return response()->json([
            'success'=>true,
            'data'=>FranchisePage::findOrFail($id)
        ]);
    }

    /**
     * Update
     */
    public function update(Request $request,$id)
    {
        $franchise = FranchisePage::findOrFail($id);

        $request->validate([

            'title'                    => 'nullable|string',

            'training_description'     => 'nullable|string',

            'advantages_title'         => 'nullable|string',

            'advantages_description'   => 'nullable|string',

            'advantages_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'why_join_title'           => 'nullable|string',

            'why_join_description'     => 'nullable|string',

        ]);

        $folder = public_path('franchise');

        if (!File::exists($folder)) {
            File::makeDirectory($folder,0755,true);
        }

        if($request->hasFile('advantages_image')){

            if($franchise->advantages_image &&
                file_exists(public_path($franchise->advantages_image))){

                unlink(public_path($franchise->advantages_image));
            }

            $file = $request->file('advantages_image');

            $filename = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();

            $file->move($folder,$filename);

            $franchise->advantages_image = 'franchise/'.$filename;
        }

        $franchise->update([

            'title'                   => $request->title,

            'training_description'    => $request->training_description,

            'advantages_title'        => $request->advantages_title,

            'advantages_description'  => $request->advantages_description,

            'advantages_image'        => $franchise->advantages_image,

            'why_join_title'          => $request->why_join_title,

            'why_join_description'    => $request->why_join_description,

        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Franchise Page Updated Successfully',
            'data'=>$franchise
        ]);
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $franchise = FranchisePage::findOrFail($id);

        if($franchise->advantages_image &&
            file_exists(public_path($franchise->advantages_image))){

            unlink(public_path($franchise->advantages_image));
        }

        $franchise->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Deleted Successfully'
        ]);
    }
}