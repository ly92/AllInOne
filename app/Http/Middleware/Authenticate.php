<?php

namespace App\Http\Middleware;

use App\Http\Service\Client\ClientService;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if ($this->auth->guard($guard)->guest()) {
        //     return response('Unauthorized.', 401);
        // }
        return $next($request);


        $cid = $request->input('cid');
        $token = $request->input('token');
        if (empty($cid)){
            throw new \Exception('用户id不可为空', 4001);
        }
        $client = (new ClientService())->getById($cid);
        $localToken = md5($cid . $client->lastLoginTime);
        if ($localToken != $token){
            throw new \Exception('请重新登录', 9999);
        }

        return $next($request);
    }
}
