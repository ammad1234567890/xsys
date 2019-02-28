<?php

namespace App\Http\Controllers;

use App\Item;
use App\Product;
use Illuminate\Support\Facades\Input;
use DB;
use Auth;
use Excel;
use App\IMEI;
use Session;

use Illuminate\Http\Request;

class IMEIController extends Controller
{
  public function __construct()
  {
      
      $this->middleware('auth');
  }
    public function importExport()
  {
    $products=Product::where('is_deleted',0)->get();
    return view('importIMEI',array('products'=>$products));
  }
  public function downloadExcel($type)
  {
    $data = Item::get()->toArray();
    return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
          {
        $sheet->fromArray($data);
          });
    })->download($type);
  }
  public function importExcel(Request $request)
  {
    $userId=Auth::user()->id;
    $productId=$request->input('product');
    if(Input::hasFile('import_file')){
      $path = Input::file('import_file')->getRealPath();
      $data = Excel::load($path, function($reader) {
      })->get();

      if(!empty($data) && $data->count()){
          $is_uploaded=0;

              foreach ($data as $key => $value) {
                  if(IMEI::where('imei1','=',$value->imei1)->exists() || IMEI::where('imei2','=',$value->imei2)->exists()){
                      $is_uploaded=1;
                      break;
                      //return back();

                  }
              }
          //Session::flash('import_error_message', $is_uploaded);
            if($is_uploaded==0){
              foreach ($data as $key => $value) {
                  $insert[] = ['imei1' => $value->imei1,'imei2'=>$value->imei2,'product_id'=>$productId,'created_by'=>$userId];
                 /* $insert[] = ['imei1' => $value->imei3,'imei2'=>$value->imei4,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei5,'imei2'=>$value->imei6,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei7,'imei2'=>$value->imei8,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei9,'imei2'=>$value->imei10,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei11,'imei2'=>$value->imei12,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei13,'imei2'=>$value->imei14,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei15,'imei2'=>$value->imei16,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei17,'imei2'=>$value->imei18,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei19,'imei2'=>$value->imei20,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei21,'imei2'=>$value->imei22,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei23,'imei2'=>$value->imei24,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei25,'imei2'=>$value->imei26,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei27,'imei2'=>$value->imei28,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei29,'imei2'=>$value->imei30,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei31,'imei2'=>$value->imei32,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei33,'imei2'=>$value->imei34,'product_id'=>$productId,'created_by'=>$userId];





                  $insert[] = ['imei1' => $value->imei35,'imei2'=>$value->imei36,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei37,'imei2'=>$value->imei38,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei39,'imei2'=>$value->imei40,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei41,'imei2'=>$value->imei42,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei43,'imei2'=>$value->imei44,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei45,'imei2'=>$value->imei46,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei47,'imei2'=>$value->imei48,'product_id'=>$productId,'created_by'=>$userId];
                  $insert[] = ['imei1' => $value->imei49,'imei2'=>$value->imei50,'product_id'=>$productId,'created_by'=>$userId];*/
              }
              if(!empty($insert)){
                  DB::table('tbl_imei')->insert($insert);
                  Session::flash('import_success_message', 'Imeis has been successfully imported!');
                  //dd('Insert Record successfully.');
              }
          }
          else{
              Session::flash('import_error_message', "Duplicate Imeis Found");
          }
      }
    }
    return back();
  }

  public function get_all_avaiable_imeis(Request $request){
      $product_id = $request->input('product_id');
      return IMEI::where('product_id', $product_id)->where('item_id',NULL)->get();

  }
}
