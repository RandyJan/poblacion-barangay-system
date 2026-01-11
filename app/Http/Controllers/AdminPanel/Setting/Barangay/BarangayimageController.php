<?php

namespace App\Http\Controllers\AdminPanel\Setting\Barangay;

use App\Http\Controllers\Controller;

use App\Models\Barangayimage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangayimageController extends Controller
{

   public function store(Request $request)
{
$request->validate([
'barangay_name' => 'required',
'city' => 'required',
'province' => 'required',
'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:300|dimensions:max_width=300,max_height=300',
]);

// Get the uploaded file
$file = $request->file('image');

// Define the path and retain the original filename
$path = $file->storeAs('public/images', $file->getClientOriginalName());

// Delete old file if exists
$deletefile = DB::table('barangayimages')
    ->where('barangay_id', $request->barangay_id)
    ->first();

if ($deletefile !== null) {
    Storage::delete($deletefile->image);
}

// Save or update the record
Barangayimage::updateOrCreate(
    ['barangay_id' => $request->barangay_id],
    [
        'city' => $request->city,
        'barangay_name' => $request->barangay_name,
        'province' => $request->province,
        'image' => $path, // retains original filename
    ]
);

return redirect('/setting/maintenance')
                ->with('success', 'Post has been created successfully.');

}



public function test(){



    echo "231312";
}
}
