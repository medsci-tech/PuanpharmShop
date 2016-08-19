<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;

class WechatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Session::has(\Config::get('constants.SESSION_USER_KEY'))) {
            return $next($request);
        }

        // auth
        $wechatUser = \Wechat::authorizeUser($request->fullUrl());
        \Log::debug('wechatUser', ['wechatUser' => serialize($wechatUser)]);;
        // register
        if (!$customer = Customer::where('openid', $wechatUser['openid'])->first()) {
            $customer = new Customer();
            $customer->openid = $wechatUser['openid'];
            $customer->nickname = $wechatUser['nickname'];
            $customer->head_image_url = $wechatUser['headimgurl'];
            $customer->unionid = $wechatUser['unionid'];
            if ($request->has('utm_source')) {
                $customer->source = $request->input('utm_source');
            }
            $customer->save();
        } elseif (!$customer->unionid) {
            $customer->unionid = $wechatUser['unionid'];
            $customer->save();
        }
        // session
        \Session::put(\Config::get('constants.SESSION_USER_KEY'), $customer);
        return $next($request);
    }
}