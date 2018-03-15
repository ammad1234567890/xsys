<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Support\Facades\Input;
use DB;
use Auth;
use Excel;

use Illuminate\Http\Request;

class IMEIController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    public function importExport()
  {
    return view('importIMEI');
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
  public function importExcel()
  {
    $userId=Auth::user()->id;
    if(Input::hasFile('import_file')){
      $path = Input::file('import_file')->getRealPath();
      $data = Excel::load($path, function($reader) {
      })->get();
      if(!empty($data) && $data->count()){
        foreach ($data as $key => $value) {
          $insert[] = ['imei1' => $value->imei1,'imei2'=>$value->imei2,'created_by'=>$userId];
        }
        if(!empty($insert)){
          DB::table('tbl_imei')->insert($insert);
          //dd('Insert Record successfully.');
        }
      }
    }
    return back();
  }
}
