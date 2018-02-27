<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Permission;
use App\Role;
use App\User;

class AccessControllController extends Controller
{

    /**
    *@return view
    */
   public function index() //return view for creating role
   {
     return view('AccessControl');
   }

   /**
   *@return \Illuminate\Http\Response
   */

   public function permission() //return all permissions
   {
        return Permission::all();
   }


   public function RolePermission() //return all roles with permissions
   {
     return Role::with('permission')->where('is_deleted',0)->get();
   }

   public function createRole(Request $request) //create new reole | recive post request
   {
     $roleName=$request->input('roleName');
     $permission=array($request->input('selected'));
     $description=$request->input('description');
     $permissionId=array();
     $user=Auth::user()->id;
     foreach ($permission[0] as $per) {
       array_push($permissionId,$per['id']);
     }
     try{
       DB::beginTransaction();
       $role=Role::create(['role'=>$roleName,'description'=>$description,'created_by'=>$user]);
       $role->permission()->attach($permissionId);
       DB::commit();
     }catch(\Exception $e){
       DB::rollBack();
       return $e;
     }
     return 0;
   }

   public function editRole(Request $request) //edit role | recive post request
   {
     $id=$request->input('id');
     $roleName=$request->input('roleName');
     $permission=array($request->input('selected'));
     $description=$request->input('description');
     $permissionId=array();
     $user=Auth::user()->id;
     foreach ($permission[0] as $per) {
       array_push($permissionId,$per['id']);
     }
    try{
      DB::beginTransaction();
       $role=Role::where('id',$id)->update(['role'=>$roleName,'description'=>$description,'updated_by'=>$user]);
       $role=Role::find($id);
       $role->permission()->detach();
       $role->permission()->attach($permissionId);
       DB::commit();
     }
     catch(\Exception $e){
       DB::rollBack();
       return $e;
     }
     return 0;
   }

   public function deleteRole($id) //delete specific role | recive role id
   {
     try{
    		Role::where('id',$id)->update(['is_deleted'=>1]);
    	}catch(Exception $e){
    		return e;
    	}
        return 0;
   }

   public function userRole()
   {
     return view('UserRole');
   }

   public function Users()
   {
     return User::all();
   }

   public function roles()
   {
     return Role::where('is_deleted',0)->get();
   }

   public function userRoles()
   {
     return User::with('role.permission')->get();
     //return Role::with('permission')->with('users')->get();
   }

   // public function assignRole(Request $request)
   // {
   //   $userId=$request->input('user');
   //   $roles=$request->input('roles');
   //   $user=User::find($userId);
   //   $roleIds=array();
   //   foreach($roles as $role){
   //      array_push($roleIds,$role['id']);
   //   }
   //   try{
   //     $user->role()->attach($roleIds);
   //   }catch(\Exception $e){
   //     return $e;
   //   }
   //  return 0;
   // }

   public function editUserRole(Request $request)
   {
       $userId=$request->input('id');
       $userName=$request->input('user');
       $roles=$request->input('roles');
       $user=User::find($userId);
       $roleIds=array();
       foreach($roles as $role){
          array_push($roleIds,$role['id']);
       }
       try{
         User::where('id',$userId)->update(['name'=>$userName]);
         if(!empty($user->with('role')->get())){
           $user->role()->detach();
           $user->role()->attach($roleIds);
         }else{
           $user->role()->attach($roleIds);
         }
       }catch(\Exception $e){
         return $e;
       }
       return 0;
   }

}
