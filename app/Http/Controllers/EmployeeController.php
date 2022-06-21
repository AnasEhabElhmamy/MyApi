<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employee=Employee::orderBy('id','DESC')->paginate(2);
        return response()->json($employee);
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
            'Salary'=>'required|numeric',
            'PhoneNumber'=>'required|numeric|unique:employees',
        ],[],[
            'Name'=>'الاسم',
            'Salary'=>'الراتب',
            'PhoneNumber'=>'رقم الهاتف',
        ]);

        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }
        $employee=new Employee();
        $employee->Name=$request->Name;
        $employee->Salary=$request->Salary;
        $employee->Address=$request->Address;
        $employee->PhoneNumber=$request->PhoneNumber;
        $employee->JobTitle=$request->JobTitle;
        $employee->id_directors =$request->id_directors ;
        $employee->save();
        return response()->json(['message'=>"Success added"]);
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
        $employee=Employee::Find($id);
        return response()->json(compact('employee'));
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
            'Salary'=>'required|numeric',
            'PhoneNumber'=>'required|numeric|unique:employees',
        ],[],[
            'Name'=>'الاسم',
            'Salary'=>'الراتب',
            'PhoneNumber'=>'رقم الهاتف',
        ]);

        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }

        $employee=Employee::Find($id);
        $employee->Name=$request->Name;
        $employee->Salary=$request->Salary;
        $employee->Address=$request->Address;
        $employee->PhoneNumber=$request->PhoneNumber;
        $employee->JobTitle=$request->JobTitle;
        $employee->id_directors =$request->id_directors ;
        $employee->save();
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

        $employee=Employee::Find($id);
        $employee->delete();
        return response()->json(['message'=>"Success deleted"]);

    }

    public function FilterEmployee(Request $request)
    {
        # code...

        $employee=Employee::OrderBy('id','Asc')->when($request->name,function($r) use($request){
            $r->Where('Name','like','%'.$request->name.'%');
        })->paginate(2);
        return response()->json($employee);
    }
}
