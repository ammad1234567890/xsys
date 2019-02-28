<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OnShelfImei;
use App\SoAuth;
use App\SoTask;
use App\SoTaskStatus;
use DB;
use App\IMEI;
use App\Http\Controllers\RetailerInvoiceController;
use App\MainWarehouseReceiveItem;
use App\SoTaskSoldItems;

class SoTaskController extends Controller {

    public function __construct() {
        $this->so_task = new SoTask();
        $this->retailer_invoice = new RetailerInvoiceController();
    }

    public function get_so_tasks(Request $request) {
        $data = $this->so_task->tasks($request->so_id);
        $tasks = [];
        if (sizeof($data)) {
            for ($i = 0; $i < sizeof($data); $i++) {
                $aging = $this->retailer_invoice->outlet_aging($data[$i]->outlet_id);
                $tasks[$i]['id'] = $data[$i]->id;
                $tasks[$i]['outlet_id'] = $data[$i]->outlet_id;
                $tasks[$i]['outlet_name'] = $data[$i]->outlet_name;
                $tasks[$i]['address'] = $data[$i]->address;
                $tasks[$i]['task_no'] = $data[$i]->task_no;
                $tasks[$i]['status'] = $data[$i]->status;
                $tasks[$i]['aging'] = number_format($aging['aging'], 0, ',', ',');
            }
            return ['status' => 1, 'status_code' => 200, 'tasks' => $tasks];
        } else {
            return ['status' => 1, 'status_code' => 200, 'tasks' => []];
        }
    }

    public function submit_shelf_report(Request $request) {
        if (sizeof($request['data']['imeis']) == 0) {
            return ['status' => 0, 'status_code' => 401];
        }
        try {
            DB::beginTransaction();
            $data = [];
            $sold_imeis = [];
            $count = 0;
            $so_task = SoTask::where(['id' => $request['data']['task_id']])->where('status_id', '!=', 3)->count();
            if ($so_task) {
                $query_imei1 = IMEI::whereIn('imei1', $request['data']['imeis'])->select('item_id')->get();
                $query_imei2 = IMEI::whereIn('imei2', $request['data']['imeis'])->select('item_id')->get();
                $task_update = SoTask::where(['id' => $request['data']['task_id']]);
                if ($request['data']['comment'] != "") {
                    $task_update->update(['status_id' => 2, 'comment' => $request['data']['comment']]);
                } else {
                    $task_update->update(['status_id' => 2]);
                }
                $all_none_active_imeis = MainWarehouseReceiveItem::where('sold_to_outlet_id', '=', $request['data']['outlet_id'])
                                ->where('activated_date', '=', null)->select('item_id')->get();
                for ($i = 0; $i < sizeof($query_imei1); $i++) {
                    $imei1[$i] = $query_imei1[$i]->item_id;
                }
                for ($i = 0; $i < sizeof($query_imei2); $i++) {
                    $index = sizeof($imei1);
                    $imei1[$index++] = $query_imei2[$i]->item_id;
                }
                for ($i = 0; $i < sizeof($imei1); $i++) {
                    $data[$i]['task_id'] = $request['data']['task_id'];
                    $data[$i]['item_id'] = $imei1[$i];
                }
                for ($i = 0; $i < sizeof($all_none_active_imeis); $i++) {
                    $all_imes[$i] = $all_none_active_imeis[$i]['item_id'];
                }
                $unique_imei = array_diff((array) $all_imes, (array) $imei1);
                foreach ($unique_imei as $unique_imei) {
                    $sold_imeis[$count]['task_id'] = $request['data']['task_id'];
                    $sold_imeis[$count]['item_id'] = $unique_imei;
                    $count++;
                }
                SoTaskSoldItems::where('task_id', $request['data']['task_id'])->delete();
                OnShelfImei::insert($data);
                SoTaskSoldItems::insert($sold_imeis);
                DB::commit();
                return ['status' => 1, 'status_code' => 200];
            } else {
                return ['status' => 0, 'status_code' => 401];
            }
        } catch (Exception $ex) {
            DB::rollBack();
        }
    }

    public function outlet_imeis(Request $request) {
        if ($request->outlet_id != "" && $request->task_id != "") {
            $data = [];
            $query = [];
            $count = 0;
            $so_task = SoTask::where(['id' => $request->task_id])->select('status_id')->first();
            $query = DB::table('tbl_main_warehouse_receive_item')
                    ->join('tbl_imei', 'tbl_imei.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                    ->join('tbl_item', 'tbl_item.id', '=', 'tbl_main_warehouse_receive_item.item_id')
                    ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                    ->where('tbl_main_warehouse_receive_item.sold_to_outlet_id', '=', $request->outlet_id)
                    ->where('tbl_main_warehouse_receive_item.activated_date', '=', null)
                    ->select('tbl_imei.imei1', 'tbl_imei.imei2', 'tbl_product_color.color', 'tbl_product.name');
            if ($so_task['status_id'] == 2) {
                $onshelfimei = OnShelfImei::where(['task_id' => $request->task_id])->select('item_id')->get();
                $query->whereNotIn('tbl_main_warehouse_receive_item.item_id', $onshelfimei);
            }
            $query = $query->get();
            if (sizeof($query)) {
                return ['status' => 1, 'status_code' => 200, 'imeis' => $query];
            } else {
                return ['status' => 0, 'status_code' => 401];
            }
        } else {
            return ['status' => 0, 'status_code' => 401];
        }
    }

}
