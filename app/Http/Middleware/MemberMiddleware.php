<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Member\Member;
use Illuminate\Support\Facades\Input;
use App\Models\Aes;

class MemberMiddleware
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
		
		$aes = new Aes();
		 if (\Session::has('phone')) {
            return $next($request);
        } else {
			
			$enphone = $aes->Decode(urldecode(Input::get('phone')),'n0u0norDi5k_maTe');
			$rules = ['phone'=>'required|digits:11'];
			$input = ['phone'=>$enphone];
            $validator = \Validator::make($input, $rules);
			
            if ($validator->fails()) {
                return redirect('/member/notice');
            } else {
                if (!$member = Member::where('phone', $enphone)->first()) {
                    $member = new Member();
                    $member->phone = $enphone;
                    $member->save();
                }
                \Session::set('phone', $member->phone);
                return $next($request);
            }
        }
		
        // if (\Session::has('phone')) {
            // return $next($request);
        // } else {
            // $validator = \Validator::make($request->all(), ['phone' => 'required|digits:11']);
            // if ($validator->fails()) {
                // return redirect('/member/notice');
            // } else {
                // if (!$member = Member::where('phone', $request->input('phone'))->first()) {
                    // $member = new Member();
                    // $member->phone = $request->input('phone');
                    // $member->save();
                // }
                // \Session::set('phone', $member->phone);
                // return $next($request);
            // }
        // }
		
		
		
    }
}