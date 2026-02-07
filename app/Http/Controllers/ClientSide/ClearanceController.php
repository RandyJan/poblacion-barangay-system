<?php

namespace App\Http\Controllers\ClientSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
//model
use App\Models\Certificate_list;
use App\Models\Certificate_request;
use App\Models\CertificateRequirements;


class ClearanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!session()->has("resident")) {
            return redirect("/barangay/login");
        }

        $certificate = Certificate_list::get();

        return view('pages.ClientSide.userdashboard.certificate',compact('certificate'));


    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'resident_id' => 'required|exists:resident_accounts,resident_account_id',
        'request_type' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 1️⃣ Get certificate FIRST
    $certificate = Certificate_list::where(
        'certificate_type',
        $request->request_type
    )->firstOrFail();

    // 2️⃣ Create certificate request (LET DB AUTO-GENERATE request_id)
    $certificateRequest = Certificate_request::create([
        'resident_id' => $request->resident_id,
        'name' => $request->name,
        'gender' => $request->gender,
        'age' => $request->age,
        'description' => $request->Description,
        'request_type' => $request->request_type,
        'paid' => 'No',
        'price' => $certificate->price,
        'cert_id' => $certificate->certificate_list_id,
    ]);

    // 3️⃣ Save uploaded requirements (SAME request_id for all)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/certificates'), $filename);

            CertificateRequirements::create(attributes: [
                'request_id'     => $certificateRequest->request_id,
                'certificate_id' => $certificate->certificate_list_id,
                'image_path'     => 'uploads/certificates/' . $filename,
            ]);
        }
    }

    return redirect('/barangay/schedule')
        ->with('success_certificate', 'Certificate successfully created!');
}



}
