<?php

namespace App\Http\Controllers;

use App\Product;
use App\SmsLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class smsLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:sms.logs');
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $smsLogQuery = SmsLog::query();
            $logs = Datatables::of($smsLogQuery)
                ->addIndexColumn()
                ->editColumn('text',function($row){
                    $text =  '<small>'.$row->text.'</small>';
                    return $text;
                })
                ->editColumn('status_code',function($row){
                    $status_badge = $row->status_code == 1101 ?  'success' : 'danger';
                    $status =  '<span class="badge badge-'. $status_badge.'">'.VisionSmsResponse($row->status_code).'</span>';
                    return $status;
                })
                ->editColumn('created_at',function($row){
                   return $row->created_at->diffForHumans();
                })
                ->addColumn('action', function($row){
                    $actionbtn='
                        <a href="'.route('sms_logs.show',[$row->id]).'" class="btn btn-info btn-sm edit"><i class="fas fa-eye"></i></a>';
                    return $actionbtn;
                })
                ->rawColumns(['action','status_code','text'])
                ->make(true);
            return  $logs;

        }

        return view('sms_log.index');
    }

    public function show($id){
            //  TODO: Under construct
        return "under construction";
    }
}
