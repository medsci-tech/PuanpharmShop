<?php

namespace App\Http\Middleware;

use App\Models\Wx\WxMember;
use App\Models\Aes;
use Closure;

class WxMiddleware
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
		
        if (\Session::has('wx_member')) {
            return $next($request);
        } else {
            $validator = \Validator::make($request->all(), ['phone' => 'required|digits:11']);

            if ($validator->fails()) {
				
                return redirect('/member/notice');
            } else {
				
                $wechatUser = \Wechat::authorizeUser($request->fullUrl());
                $wxMember = WxMember::where('phone', $request->input('phone'))->where('openid', $wechatUser['openid'])->first();
                if ($wxMember) {
                    \Session::set('wx_member', $wxMember->id);
                    return $next($request);
                } else {
                    $wxMember = new WxMember();
                    $wxMember->phone = $request->input('phone');
                    $wxMember->openid = $wechatUser['openid'];
                    $wxMember->save();
                    \Session::set('wx_member', $wxMember->id);
                    return $next($request);
                }
            }
        }
    }
}

