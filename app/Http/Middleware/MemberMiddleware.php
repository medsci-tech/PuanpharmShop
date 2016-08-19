<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Member\Member;

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
        if (\Session::has('phone')) {
            return $next($request);
        } else {
            $validator = \Validator::make($request->all(), ['phone' => 'required|digits:11']);
            if ($validator->fails()) {
                return redirect('/member/notice');
            } else {
                if (!$member = Member::where('phone', $request->input('phone'))->first()) {
                    $member = new Member();
                    $member->phone = $request->input('phone');
                    $member->save();
                }
                \Session::set('phone', $member->phone);
                return $next($request);
            }
        }
    }
}