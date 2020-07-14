<?php

namespace App\Http\Middleware;

use Closure;

class CheckApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data=$request->all();
        if(!$data['user_token']){
            $response=[
                'errno'=>50004,
                'msg'=>'没有token令牌',
                'data'=>[]
            ];
            echo json_encode($response);die;
        }
        return $next($request);
    }
}
