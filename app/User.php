<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use App\Permission;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /*******************************************************
    hasPermission function will check if user have permission
    for specific route $route is reciving a int which is the
    id of permission table
    ********************************************************/
    public function hasPermission($route)
    {
        $userRoles=$this::role()->select('tbl_role.id')->with('permission')->where('user_id',$this->id);
        $roles=$userRoles->get();
        //echo $roles;
        foreach ($roles as $role) {
            if(!empty($role->permission[0])){
              foreach($role->permission as $permission){
                //echo $permission."||||||||||||||";
                if($permission->id == $route){
                  return true;
                  break;
               }
              }
            }
          }
        return false;
    }


    public function role()
    {
      //Make relation with role through tbl_user_role where tbl_user_role.is_deleted is 0 and tbl_role.is_deleted is also 0
      return $this->belongsToMany('App\Role', 'tbl_user_role', 'user_id', 'role_id')->wherePivot('is_deleted',0)->where('tbl_role.is_deleted',0);
    }

    public function damage(){
      return $this->hasMany('App\Damage');
    }

    public function worker(){
      return $this->hasMany('App\Worker');
    }

    public function category(){
      return $this->hasMany('App\Category');
    }

    public function item(){
      return $this->hasMany('App\Item');
    }

    public function carton_log()
    {
      return $this->hasMany('App\Carton_log');
    }

    public function order_payment(){
      return $this->hasMany('App\Order_payment');
    }

    public function order(){
      return $this->hasMany('App\Order');
    }

    public function product(){
      return $this->hasMany('App\Product');
    }

    public function carton()
    {
      return $this->hasMany('App\Carton');
    }

    public function order_product()
    {
      return $this->hasMany('App\Order_product');
    }

    public function collection()
    {
      return $this->hasMany('App\Collection');
    }

    public function collection_product()
    {
      return $this->hasMany('App\Collection_product');
    }

    public function main_stock()
    {
      return $this->hasMany('App\Main_stock');
    }

    public function warehouse()
    {
      return $this->hasMany('App\Warehouse');
    }

    public function warehouse_stock()
    {
      return $this->hasMany('App\Warehouse_stock');
    }

    public function warehouse_staff()
    {
      return $this->hasMany('App\Warehouse_staff');
    }

    public function warehouse_receive()
    {
      return $this->hasMany('App\Warehouse_receive');
    }

    public function warehouse_exit()
    {
      return $this->hasMany('App\Warehouse_exit');
    }

    public function retailer()
    {
      return $this->hasMany('App\Retailer');
    }

    public function retailer_outlet()
    {
      return $this->hasMany('App\Retailer_outlet');
    }

    public function retailer_order()
    {
      return $this->hasMany('App\Retailer_order');
    }

    public function delivery_product()
    {
      return $this->hasMany('App\Delivery_product');
    }

    public function retailer_order_product()
    {
      return $this->hasMany('App\Retailer_order_product');
    }

    public function retailer_payment()
    {
      return $this->hasMany('App\Retailer_payment');
    }

    public function retailer_delivery()
    {
      return $this->hasMany('App\Retailer_delivery');
    }

    public function vehicle()
    {
      return $this->hasMany('App\Vehicle');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
