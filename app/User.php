<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Role;
use App\Permission;
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'staff_id' ,'password',
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

    public function staffRecord()
    {
      return $this->belongsTo('App\Staff')->where('tbl_staff.is_deleted',0);;
    }
    public function role()
     {
       //Make relation with role through tbl_user_role where tbl_user_role.is_deleted is 0 and tbl_role.is_deleted is also 0
       return $this->belongsToMany('App\Role', 'tbl_user_role', 'user_id', 'role_id')->wherePivot('is_deleted',0)->where('tbl_role.is_deleted',0);
     }

    public function product()
    {
      return $this->hasMany('App\Product');
    }
    public function productCategory()
    {
      return $this->hasMany('App\ProductCategory');
    }
    public function productColor()
    {
      return $this->hasMany('App\ProductColor');
    }
    public function productImage()
    {
      return $this->hasMany('App\ProductImage');
    }

    public function staff()
    {
      return $this->hasMany('App\Staff');
    }

    public function warhouse()
    {
      return $this->hasMany('App\Warehouse');
    }

    public function userRole()
    {
      return $this->hasMany('App\UserRole');
    }

    public function mainWarehouseReceiveProduct()
    {
      return $this->hasMany('App\MainWarehouseReceiveProduct');
    }

    public function mainWarehouseReceive()
    {
      return $this->hasMany('App\MainWarehouseReceive');
    }

    public function warehouseIssue()
    {
      return $this->hasMany('App\WarehouseIssue');
    }

    public function warehouseIssueItem()
    {
      return $this->hasMany('App\WarehouseIssueItem');
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
