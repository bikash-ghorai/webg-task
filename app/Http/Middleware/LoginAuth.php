<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Response;

class LoginAuth extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $data = (object)['status' => 'Failed', 'message' => 'Token is Invalid'];
                return Response::json($data);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $data = (object)['status' => 'Failed', 'message' => 'Token is Expired'];
                return Response::json($data);
            }else{
                $data = (object)['status' => 'Failed', 'message' => 'Authorization Token not found'];
                return Response::json($data);
            }
        }
        return $next($request);
    }
}
