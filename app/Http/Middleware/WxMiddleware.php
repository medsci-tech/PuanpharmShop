<?php

namespace App\Http\Middleware;

use App\Models\Wx\WxMember;
use App\Models\Aes;
use Closure;
use Illuminate\Support\Facades\Input;

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
	\Log::info('locationtest---' .'1111'); 
		
		$aes = new Aes();
		
        if (\Session::has('wx_member')) {
			\Log::info('session---' .$request->session()->get('wx_member')); 
		
			//切换
			$_phone = Input::get('phone');
			if($_phone){
				$enphone = $aes->Decode(Input::get('phone'),'n0u0norDi5k_maTe');
				$wechatUser = \Wechat::authorizeUser($request->fullUrl());
				$wxMember = WxMember::where('phone', $enphone)->where('openid', $wechatUser['openid'])->first();
				\Log::info('wx_member---' .$wxMember); 
				  if ($wxMember) {
					if($request->session()->get('wx_memb er') != $wxMember->id ) {
						\Session::set('wx_member', $wxMember->id);
					} 
                } else {
                    $wxMember = new WxMember();
                    $wxMember->phone = $enphone;
                    $wxMember->openid = $wechatUser['openid'];
                    $wxMember->save();
                    \Session::set('wx_member', $wxMember->id); 
                  
                }
				
				
			}
			
			\Log::info('locationtest---' .'2222'); 
			\Log::info('locationtest1---' . Input::get('phone')); 
            return $next($request);
        } else {
			\Log::info('locationtest---' .'3333'); 
			\Log::info('from get ---' . Input::get('phone'));  
			
			
			// $enphone = $aes->Decode(urldecode(Input::get('phone')),'n0u0norDi5k_maTe');
			$enphone = $aes->Decode(Input::get('phone'),'n0u0norDi5k_maTe');
			$rules = ['phone'=>'required|digits:11'];
			$input = ['phone'=>$enphone];
			// \Log::info('locationtest---' .'444'.$enphone); 
            $validator = \Validator::make($input, $rules);
		
            if ($validator->fails()) {
				
                return redirect('/member/notice');
            } else {
				
                $wechatUser = \Wechat::authorizeUser($request->fullUrl());
                $wxMember = WxMember::where('phone', $enphone)->where('openid', $wechatUser['openid'])->first();
                if ($wxMember) {
                    \Session::set('wx_member', $wxMember->id);
                    return $next($request);
                } else {
                    $wxMember = new WxMember();
                    $wxMember->phone = $enphone;
                    $wxMember->openid = $wechatUser['openid'];
                    $wxMember->save();
                    \Session::set('wx_member', $wxMember->id);
                    return $next($request);
                }
            }
        }
		
        // if (\Session::has('wx_member')) {
            // return $next($request);
        // } else {
            // $validator = \Validator::make($request->all(), ['phone' => 'required|digits:11']);

            // if ($validator->fails()) {
				
                // return redirect('/member/notice');
            // } else {
				
                // $wechatUser = \Wechat::authorizeUser($request->fullUrl());
                // $wxMember = WxMember::where('phone', $request->input('phone'))->where('openid', $wechatUser['openid'])->first();
                // if ($wxMember) {
                    // \Session::set('wx_member', $wxMember->id);
                    // return $next($request);
                // } else {
                    // $wxMember = new WxMember();
                    // $wxMember->phone = $request->input('phone');
                    // $wxMember->openid = $wechatUser['openid'];
                    // $wxMember->save();
                    // \Session::set('wx_member', $wxMember->id);
                    // return $next($request);
                // }
            // }
        // }
		
		
    }
}

