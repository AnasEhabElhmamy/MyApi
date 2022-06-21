<?php

namespace App\Http\Controllers;

use App\Models\Director;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $director=Director::orderBy('id','DESC')->paginate(2);
        return response()->json($director);
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
            'PhoneNumber'=>'required|numeric|unique:directors',
        ],[],[
            'Name'=>'الاسم',
            'PhoneNumber'=>'رقم الهاتف',
        ]);
        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }
        $item=new Director();
        $item->Name=$request->Name;
        $item->Address=$request->Address;
        $item->PhoneNumber=$request->PhoneNumber;
        $item->save();
        return response()->json(['message'=>"Success Added"]);
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
        $director=Director::Find($id);
        return response()->json(compact('director'));
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
            'PhoneNumber'=>'required|numeric|unique:directors',
        ],[],[
            'Name'=>'الاسم',
            'PhoneNumber'=>'رقم الهاتف',
        ]);
        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }

        $item=Director::Find($id);
        $item->Name=$request->Name;
        $item->Address=$request->Address;
        $item->PhoneNumber=$request->PhoneNumber;
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
        $item=Director::Find($id);
        $item->delete();

        //ملاحظ يتحتوى على خطا بسبب الForenkey
        return response()->json(['message'=>"Success deleted"]);
    }

    public function FilterDirector(Request $request)
    {
        # code...

        $item=Director::OrderBy('id','Asc')
        ->when($request->name,function($r) use($request){
            $r->Where('Name','like','%'.$request->name.'%');
        })->when($request->phone,function($r)use($request){
            $r->Where('PhoneNumber','like','%'.$request->phone.'%');
        })->paginate(2);
        return response()->json($item);
    }

    public function DirectorEmployee(Request $request)
    {
        # code...

        $item=Director::OrderBy('id','Asc')
        ->when($request->name,function($r) use($request){
            $r->Where('Name','like','%'.$request->name.'%');
        })->with('Director_Emp')->paginate(2);
        return response()->json($item);
    }
}
