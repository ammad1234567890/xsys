<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use Auth;
use File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCategory::where('is_deleted',0)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category');
    }

    public function path()
    {
        $path=public_path().'\category_img';
        return $path;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name=$request->input('name');
        $description=$request->input('description');
        $exploded = explode(',', $request->image);
        $decoded =base64_decode($exploded[1]);
        if(str_contains($exploded[0],'jpeg')){
          $extension = "jpg";
        }elseif(str_contains($exploded[0],'png')){
          $extension = 'png';
        }else{
          $return=array('replay'=>1,'data'=>"only png and jpg files are acceptable");
          return $return;
        }
        $fileName=str_random().'.'.$extension;
        $path = public_path().'/category_img/'.$fileName;
        file_put_contents($path, $decoded);
        $user=Auth::user()->id;
        $newCategory=ProductCategory::create(['name'=>$name,'description'=>$description,'image'=>$fileName,'created_by'=>$user]);
        $return=array('replay'=>0,'data'=>$newCategory);
        return $return;
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $id=$request->input('id');
       $name=$request->input('name');
       $description=$request->input('description');
       $imageName=$request->input('image');
       $oldImage=$request->input('OldImage');
       $user=Auth::user()->id;
       if(file_exists(public_path().'/category_img/'.$imageName)){
          try{
            ProductCategory::where('id',$id)->update(['name'=>$name,'description'=>$description,'updated_by'=>$user,'image'=>$imageName]);
          }Catch(\Exception $e){
            $return=array('replay'=>2,'data'=>$e);
            return $return;
          }
          $return=array('replay'=>0,'data'=>'Updated with old image');
          return $return;
       }else{
          //File Uploading
          $exploded = explode(',', $request->image);
          $decoded =base64_decode($exploded[1]);
          if(str_contains($exploded[0],'jpeg')){
            $extension = "jpg";
          }elseif(str_contains($exploded[0],'png')){
            $extension = 'png';
          }else{
            $return=array('replay'=>1,'data'=>"only png and jpg files are acceptable");
            return $return;
          }
          $fileName=str_random().'.'.$extension;
          $path = public_path().'/category_img/'.$fileName;
          file_put_contents($path, $decoded);
          File::delete(public_path().'/category_img/'.$oldImage);
          //End Filr Uploading
          try{
            ProductCategory::where('id',$id)->update(['name'=>$name,'description'=>$description,'updated_by'=>$user,'image'=>$fileName]);
          }Catch(\Exception $e){
            $return=array('replay'=>0,'data'=>$e);
            return $return;
          }
          $return=array('replay'=>0,'data'=>'Updated');
          return $return;
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
        ProductCategory::where('id',$id)->update(['is_deleted'=>1]);
      }catch(Exception $e){
        return e;
      }
        return 0;
    }
}
