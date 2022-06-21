<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $class=products::orderBy('id','DESC')->paginate(2);
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
            'Name'=>'required|max:20',
            'Barcode'=>'required|numeric|unique:product',
            'PriceBuy'=>'required|numeric',
            'PriceSelling'=>'required|numeric',
            'Image'=>'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
        ],[],[
            'Name'=>'الاسم',
            'Barcode'=>'الباركود',
            'PriceBuy'=>'سعر الشراء',
            'PriceSelling'=>'سعر البيع',
            'Image'=>'الصورة',
        ]);

        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }
        $pro=new products();
        $pro->Name=$request->Name;
        $pro->Description=$request->Description;
        $pro->Barcode=$request->Barcode;
        $pro->Type=$request->Type;
        $pro->DatePurchase=$request->DatePurchase;
        $pro->Quantity=$request->Quantity;
        $pro->PriceBuy=$request->PriceBuy;
        $pro->PriceSelling=$request->PriceSelling;
        $pro->Validity=$request->Validity;
        if($request->hasFile('Image')){
            $file=$request->file('Image');
            $image_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$image_name;
            $file->move(public_path('images'),$image_name);
            $pro->Image=$path;
        }
        $pro->save();
        return response()->json(['massage'=>"Success Added"]);
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
        $product=products::Find($id);
        return response()->json(compact('product'));
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
            'Name'=>'required|max:20',
            'Barcode'=>'required|numeric|unique:product',
            'PriceBuy'=>'required|numeric',
            'PriceSelling'=>'required|numeric',
            'Image'=>'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
        ],[],[
            'Name'=>'الاسم',
            'Barcode'=>'الباركود',
            'PriceBuy'=>'سعر الشراء',
            'PriceSelling'=>'سعر البيع',
            'Image'=>'الصورة'
        ]);

        if($validator->failed()){
            $message="Please Sure on Data Entered";
            $data=$validator->errors();

            return response()->json(compact('message','data'),422);
        }

        $pro=products::Find($id);
        $pro->Name=$request->Name;
        $pro->Description=$request->Description;
        $pro->Barcode=$request->Barcode;
        $pro->Type=$request->Type;
        $pro->DatePurchase=$request->DatePurchase;
        $pro->Quantity=$request->Quantity;
        $pro->PriceBuy=$request->PriceBuy;
        $pro->PriceSelling=$request->PriceSelling;
        $pro->Validity=$request->Validity;
        if($request->hasFile('Image')){
            $file=$request->file('Image');
            $image_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$image_name;
            $file->move(public_path('images'),$image_name);
            $pro->Image=$path;
        }
        $pro->save();
        return response()->json(['massage'=>"Success Edited"]);
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

        $pro=products::Find($id);
        $pro->delete();
        return response()->json(['message'=>"Success deleted"]);
    }

    public function FilterProducts(Request $request)
    {
        # code...

        $pro=products::OrderBy('id','Asc')
        ->when($request->name,function($r) use($request){

            $r->Where('Name','like','%'.$request->name.'%');

         })->when($request->barcode,function($r) use($request){

            $r->Where('Barcode','like','%'.$request->barcode.'%');

         })->paginate(2);
        return response()->json($pro);

    }
}
