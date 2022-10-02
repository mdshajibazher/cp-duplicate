<?php

namespace App\Http\Controllers\Pos;
use App\User;
use App\Prevdue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class PrevdueController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:previous_due.index')->only('index');
        $this->middleware('permission:previous_due.create')->only('create','store');
        $this->middleware('permission:previous_due.edit')->only('edit','update');
        $this->middleware('permission:previous_due.delete')->only('destroy');
    }

    public function index()
    {
        $users = User::where('user_type','pos')->get();
        $prevdues = Prevdue::with('user')->get();
        return view('pos.prevdue.index',compact('users','prevdues'));
    }


    public function create()
    {
        return false;
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'due_at' => 'required|date',
            'user' => 'required|numeric',
            'amount' => 'required|numeric',
            'reference' => 'required|max:45',
        ]);

        $prevdue = new Prevdue;
        $prevdue->due_at = $request->due_at." ".Carbon::now()->toTimeString();;
        $prevdue->user_id = $request->user;
        $prevdue->amount = $request->amount;
        $prevdue->reference = $request->reference;
        $prevdue->admin_id = Auth::user()->id;
        $prevdue->save();
        Toastr::success('Due Saved Successfully', 'success');
        return redirect()->back();


    }

    public function show(Prevdue $prevdue)
    {
        return false;
    }


    public function edit(Prevdue $prevdue)
    {
        return $prevdue;
    }


    public function update(Request $request, Prevdue $prevdue)
    {

        $this->validate($request,[
            'due_at' => 'required|date',
            'user' => 'required|numeric',
            'amount' => 'required|numeric',
            'reference' => 'required|max:45',
        ]);
        $prevdue->due_at = $request->due_at." ".Carbon::now()->toTimeString();;
        $prevdue->user_id = $request->user;
        $prevdue->amount = $request->amount;
        $prevdue->reference = $request->reference;
        $prevdue->admin_id = Auth::user()->id;
        $prevdue->save();
        Toastr::success('Due Updated Successfully', 'success');
        return redirect()->back();
    }


    public function destroy(Prevdue $prevdue)
    {
        return false;
    }
}
