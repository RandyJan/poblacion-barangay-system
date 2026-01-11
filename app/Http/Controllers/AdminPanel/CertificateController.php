<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Certificate_layout;
use App\Models\Certificate_request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Certificate_list;
use App\Models\brgy_official;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class CertificateController extends Controller
{

    public function index(Request $request)
    {
        if (!session()->has("user")) {
            return redirect("login");
        }

        $brgy_official = brgy_official::where('position','!=','Punong Barangay')
        ->get();
        $puno = brgy_official::where('position','=','Punong Barangay')
        ->get();
        $content = Certificate_list::get();

        $certrequest = Certificate_request::latest()
        ->where('paid','=','No')
        ->get();
        if ($request->ajax()) {
            $data = Certificate_request::latest()
            ->where('paid','=','No')
            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->request_id.'" data-original-title="Edit" class="edit btn btn-info  btn-xs pr-4 pl-4 editrequest"><i class="fa fa-pencil fa-lg"></i> </a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"   data-id="'.$row->request_id.'" data-original-title="Delete" class="btn btn-danger btn-xs pr-4 pl-4 deleterequest"><i class="fa fa-trash fa-lg"></i> </a>';
                          return $btn;
                 })
                   ->rawColumns(['action'])
                    ->make(true);





        }

        return view('pages.AdminPanel.certificate',[compact('certrequest'),'brgy_official2'=>$brgy_official,'brgy_official'=>$brgy_official,'puno'=>$puno,'puno2'=>$puno,'approve'=>$puno,'approve2'=>$puno,'content'=>$content]);
    }


    public function storerequest(Request $request){

        $request->validate([

            'request_id_paid' => 'Required',
            'paid' => 'Required',

        ]);
        Certificate_request::updateOrCreate(['request_id' => $request->request_id_paid],
        ['paid'=>$request->paid]);



        return response()->json(['Success'=>'Data saved successfully']);


    }
    public function deleterequest($request_id){

        $cert = Certificate_request::find($request_id)->delete();
        return response()->json(["success"=>"Data saved successfully"]);
    }
    public function certrequestpaid(Request $request)
    {


        $cert = Certificate_request::latest()
            ->where('paid','=','Yes')
            ->get();
        if ($request->ajax()) {
            $data = Certificate_request::latest()
            ->where('paid','=','Yes')
            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->request_id.'" data-original-title="Edit" class="edit btn btn-info  btn-xs pr-4 pl-4 editrequest"><i class="fa fa-pencil fa-lg"></i> </a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"   data-id="'.$row->request_id.'" data-original-title="Delete" class="btn btn-danger btn-xs pr-4 pl-4 deleterequest"><i class="fa fa-trash fa-lg"></i> </a>';
                          return $btn;
                 })
                   ->rawColumns(['action'])
                    ->make(true);





        }
    }


public function store(Request $request)
{
    Log::info("test");

    // Delete previous files if exist
    $deletefile = DB::table('certificate_layouts')
        ->where('layout_id', $request->certificate_id)
        ->first();

    if ($deletefile !== null) {
        @unlink(public_path('images/' . $deletefile->logo_1));
        @unlink(public_path('images/' . $deletefile->logo_2));
        @unlink(public_path('images/' . $deletefile->punongbarangay));
    }

    // Store files using original names
    $file1 = $request->file('logo1');
    $file2 = $request->file('logo2');
    $file3 = $request->file('punongbarangay');

    $filename1 = $file1->getClientOriginalName();
    $filename2 = $file2->getClientOriginalName();
    $filename3 = $file3->getClientOriginalName();

    $path1 = 'public/images/' . $filename1;
    $path2 = 'public/images/' . $filename2;
    $path3 = 'public/images/' . $filename3;

    // Move files to public/images
    $file1->move(public_path('images'), $filename1);
    $file2->move(public_path('images'), $filename2);
    $file3->move(public_path('images'), $filename3);

    // Save paths in DB
    Certificate_layout::updateOrCreate(
        ['layout_id' => $request->certificate_id],
        [
            'logo_1' => $path1,
            'logo_2' => $path2,
            'punongbarangay' => $path3,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'barangay' => $request->barangay,
            'office' => $request->office
        ]
    );

    return response()->json([
        'Success' => true,
        'logo_1' => $path1,
        'logo_2' => $path2,
        'punongbarangay' => $path3
    ]);
}




    public function edit($request_id){

        $cert = Certificate_request::find($request_id);
        return response()->json($cert);
    }

    public function certificate_type(Request $request){

        $certrequest = DB::table('certificate_lists')->orderBy('certificate_list_id')->get();
        if ($request->ajax()) {
            $data = DB::table('certificate_lists')->orderBy('certificate_list_id')->get();
            return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->certificate_list_id.'" data-original-title="Edit" class="edit btn btn-info  btn-xs pr-4 pl-4 edittype"><i class="fa fa-pencil fa-lg"></i> </a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"   data-id="'.$row->certificate_list_id.'" data-original-title="Delete" class="btn btn-danger btn-xs pr-4 pl-4 deletetype"><i class="fa fa-trash fa-lg"></i> </a>';
                         return $btn;
                 })
                   ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function certtypesubmit(Request $request)
    {
        Log::info($request->all());
        $request->validate([


        ]);
        $validator = Validator::make($request->all(), [
            'certificate_list_id' => '',
            'content_1' => 'Required',
            'content_2' => 'Required',
            'price' => 'Required',
            'content_3' => 'Required',
            'certificate_name'  => 'Required',
            'certificate_type' => 'Required',
        ]);


        if ($validator->fails()) {
            return response()->json(['status'=>0,'error'=>$validator->errors()]);
        }else{
        Certificate_list::updateOrCreate(['certificate_list_id' => $request->certificate_list_id],
        ['content_1'=>$request->content_1,'content_2'=>$request->content_2,'content_3'=>$request->content_3,'certificate_type'=>$request->certificate_type,'price'=>$request->price,'certificate_name'=>$request->certificate_name]);

        return response()->json(['status'=>1,'Success'=>'Data saved successfully']);
    }





    }
    public function certtypeedit($request_id){

        $cert = Certificate_list::find($request_id);
        return response()->json($cert);
    }
    public function certtypedelete($request_id){

        $cert = Certificate_list::find($request_id)->delete();
        return response()->json(["success"=>"Data saved successfully"]);
    }
}

