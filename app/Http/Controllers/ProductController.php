<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Product;
use App\ProductColor;
use App\ProductImage;
use App\Warehouse;
use Response;

class ProductController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Product');
    }

    public function productDetailView(){
      return view('productDetails');
    }

    public function productDetails($id){
        $productDetails=Product::where('id',$id)->with('productCategory','productColor.mainWarehouseReceiveProduct','productColor.warehouseStock.warehouse')->first();
        return $productDetails;
    //       $warehouses=Warehouse::with(['warehouseStock.productColor.product'=>function($q){
    //         $q->where(['id','=',15]);
    //       }])->get();
    //     $warehouses=Warehouse::whereRaw('warehouseStock.productColor.product->id',$id)->get();

      
    // }])->get();


       // $warehouses= DB::table('tbl_warehouse')
       //      ->leftJoin('tbl_warehouse_stock','warehouseStock.productColor.product.id'=15)
       //      ->get();



    //     // $warehouses=Warehouse
    //     // ::whereHas('warehouseStock.productColor.product', function($q) use($id) {
    //     //        $q->where('id', $id); 
    //     // })->with('warehouseStock.productColor.product')->get();
    //     //  $data=array('product'=>$productDetails,'warehouse'=>$warehouses);
    //     // //return $productDetails;
    //     // //return $warehouses;
    //     //  return $data;
    //      return $warehouses;
     }

    public function products()
    {
      $return=array('data'=>Product::with('productCategory')->with('productColor.productImages')->where('is_deleted',0)->get(),'path'=>public_path());
      return $return;
    }


    //get_product_colors
    public function get_colors_by_product(Request $request){
       $id=$request->input('product_id');
    // $record =  Product::with('productColor')->where('productColor.product_id',$id)->get();
        $record = ProductColor::with('product')->where('product_id',$id)->get();
        return Response::json($record);
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

    public function showProduct()
    {
      return view('showproduct');
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
        $productCategoryId=$request->input('productCategory');
        $releaseDate=$request->input('releaseDate');
        $productColors=$request->input('finds');
        $images=array();
        $userId=Auth::user()->id;
        $productColors=$request->input('finds');

        echo $twoG_name= $request->input('two_G_name');
       /* try{
        DB::beginTransaction();
        $product=Product::create(['category_id'=>$productCategoryId,'name'=>$name,'release_date'=>$releaseDate,'created_by'=>$userId]);//create product
        foreach ($productColors as $productColor) {
            $createProductColor=ProductColor::create(['product_id'=>$product->id,'color'=>$productColor['color'],'price'=>$productColor['price'],'discount'=>$productColor['discount'],'created_by'=>$userId]);//create product color
            $images=$productColor['product_images'];
            foreach($images as $image) {
                ////////////////////////////////
                $exploded = explode(',', $image);
                $decoded =base64_decode($exploded[1]);
                if(str_contains($exploded[0],'jpeg')){
                  $extension = "jpg";
                }elseif(str_contains($exploded[0],'png')){
                  $extension = 'png';
                }else{
                  $return=array('replay'=>1,'data'=>"only png and jpg files are acceptable");
                  DB::rollBack();
                  return $return;
                }
                $fileName=str_random().'.'.$extension;
                $path = public_path().'/product_img/'.$fileName;
                file_put_contents($path, $decoded);
                //array_push($images,$);
                $image=ProductImage::create(['product_color_id'=>$createProductColor->id,'image'=>$fileName,'created_by'=>$userId]);//create image
                ////////////////////////////////
            }//image loop ends
        } //productColor loop ends
      }catch(\Exception $e){
        DB::rollBack();
        $return=array('replay'=>2,'data'=>'Fail to create product '.$e);
        return $return;
      }
      DB::commit();
      $CreatedProduct=Product::where('id',$product->id)->with('productColor.productImages')->with('productCategory')->get();
      $return=array('replay'=>0,'data'=>$CreatedProduct);
      return $return; */
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $id=$request->input('id');
      $name=$request->input('name');
      $categoryid=$request->input('productCategory');
      $releaseDate=$request->input('releaseDate');
      $productColors=$request->input('finds');
      $userId=Auth::user()->id;
      $test=array();
     try{
        DB::beginTransaction();
      $updatedProduct=product::where('id',$id)->update(['name'=>$name,'category_id'=>$categoryid,'release_date'=>$releaseDate,'updated_by'=>$userId]);
      foreach ($productColors as $productColor) {
        if(isset($productColor['id'])){ //product alrady exiest
          $updateColor=productColor::where('id',$productColor['id'])->update(['color'=>$productColor['color'],'price'=>$productColor['price'],'discount'=>$productColor['discount'],'updated_by'=>$userId]);
          ProductImage::where('product_color_id',$productColor['id'])->update(['is_deleted'=>1]);
          foreach ($productColor['product_images'] as $image) {
            if(isset($image['id'])){ //if image  found
                ProductImage::where('id',$image['id'])->update(['is_deleted'=>0]);
            }else{ //if image not found
              $exploded = explode(',', $image);
              $decoded =base64_decode($exploded[1]);
              if(str_contains($exploded[0],'jpeg')){
                $extension = "jpg";
              }elseif(str_contains($exploded[0],'png')){
                $extension = 'png';
              }else{
                $return=array('replay'=>1,'data'=>"only png and jpg files are acceptable");
               DB::rollBack();
                return $return;
              }
              $fileName=str_random().'.'.$extension;
              $path = public_path().'/product_img/'.$fileName;
              file_put_contents($path, $decoded);
              //array_push($images,$);
              $image=ProductImage::create(['product_color_id'=>$productColor['id'],'image'=>$fileName,'created_by'=>$userId]);//create image
            }
          }
        }else{ // new product
          $CreatedProductColor=ProductColor::create(['product_id'=>$id,'color'=>$productColor['color'],'price'=>$productColor['price'],'discount'=>$productColor['discount'],'created_by'=>$userId]);
          $images=$productColor['product_images'];
          foreach($images as $image) {
              ///////////////image upload/////////////////
              $exploded = explode(',', $image);
              $decoded =base64_decode($exploded[1]);
              if(str_contains($exploded[0],'jpeg')){
                $extension = "jpg";
              }elseif(str_contains($exploded[0],'png')){
                $extension = 'png';
              }else{
                $return=array('replay'=>1,'data'=>"only png and jpg files are acceptable");
                DB::rollBack();
                return $return;
              }
              $fileName=str_random().'.'.$extension;
              $path = public_path().'/product_img/'.$fileName;
              file_put_contents($path, $decoded);
              //array_push($images,$);
              $image=ProductImage::create(['product_color_id'=>$CreatedProductColor->id,'image'=>$fileName,'created_by'=>$userId]);//create image
              //////////////image upload//////////////////
          }//image loop ends
        }//end alse
      }//end product color loop
    }catch(\Exception $e){
     $return=array('return'=>2,'data'=>$e);
      DB::rollBack();
      return $return;
    }
    DB::commit();
      $product=product::where('id',$id)->with('productColor.productImages')->with('productCategory')->get();
      $return=array('return'=>0,'data'=>$product);
      return $return;
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
          Product::where('id',$id)->update(['is_deleted'=>1]);
        }catch(\Exception $e){
          return $e;
        }
        return 0;
    }

    public function search($data)
    {
      //return $data;
      $searchProducts=Product::where('name','Like','%'.$data.'%')->get();
      return $searchProducts;
    }

    public function productColor($id)
    {
      $productColor=ProductColor::where('product_id',$id)->where('is_deleted',0)->get();
      return $productColor;
    }

    public function get_product_color_by_id($id)
    {
      $productColor=ProductColor::where('id',$id)->where('is_deleted',0)->get();
      return $productColor;
    }


    public function product_specs(){
        return View('product_specs');
    }
}
