<?php

namespace App\Http\Controllers;

use App\Models\Debit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $class=Debit::orderBy('id','DESC')->paginate(2);
         return response()->json($class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator=Validator::make($request->all(),[
            'Name'=>'required|max:15',
            'DebtPaid'=>'required|numeric',
            'TotalDebt'=>'required|numeric',
            'PayingAmount'=>'required|numeric',
        ],[],[
            'Name'=>'الاسم',
            'DebtPaid'=>'الدين المدفوع',
            'TotalDebt'=>'الدين الكلي',
            'PayingAmount'=>'مبلغ الدفع'
        ]);

        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }
        $item=new Debit();
        $item->Name=$request->Name;
        $item->Address=$request->Address;
        $item->Notes=$request->Notes;
        $item->DebtPaid=$request->DebtPaid;
        $item->TotalDebt=$request->TotalDebt;
        $item->PayingAmount=$request->PayingAmount;
        $item->Date=$request->Date;
        $item->save();
        return response()->json(['message'=>"Susess Added"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $debit=Debit::Find($id);
        return response()->json(compact('debit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator=Validator::make($request->all(),[
            'Name'=>'required|max:15',
            'DebtPaid'=>'required|numeric',
            'TotalDebt'=>'required|numeric',
            'PayingAmount'=>'required|numeric',
        ],[],[
            'Name'=>'الاسم',
            'DebtPaid'=>'الدين المدفوع',
            'TotalDebt'=>'الدين الكلي',
            'PayingAmount'=>'مبلغ الدفع'
        ]);

        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }

        $item=Debit::Find($id);
        $item->Name=$request->Name;
        $item->Address=$request->Address;
        $item->Notes=$request->Notes;
        $item->DebtPaid=$request->DebtPaid;
        $item->TotalDebt=$request->TotalDebt;
        $item->PayingAmount=$request->PayingAmount;
        $item->Date=$request->Date;
        $item->save();
        return response()->json(['message'=>"Success Edited"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $item=Debit::Find($id);
        $item->delete();
        return response()->json(['message'=>"Success deleted"]);
    }

    public function FilterDebit(Request $request)
    {
        # code...

        $item=Debit::OrderBy('id','Asc')
        ->when($request->Name,function($r) use($request){
            $r->Where('Name','like','%'.$request->Name.'%');
        })->when($request->address,function($r) use($request){
            $r->Where('Address','like','%'.$request->address.'%');
        })->when($request->date,function($r) use($request){
            $r->Where('Date','like','%'.$request->date.'%');
        })->paginate(2);

        return response()->json($item);
    }
}
