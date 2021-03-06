<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Closure;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permision_id)
    {
      if($request->user() === null){
        return response('Please Login', 401);
      }
      $permission=$request->user()->hasPermission($permision_id);
      if($permission==true){
        return $next($request);
      }
      return new Response(view('NotFoundPage'));
      //return response('Permission Denied', 401); 
     // return View('NotFoundPage');
    }
}
