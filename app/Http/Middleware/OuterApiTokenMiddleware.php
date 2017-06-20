<?php

namespace App\Http\Middleware;

use Closure;

class OuterApiTokenMiddleware
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
        $token = $request->input('token');
        $unionid = $request->input('unionid');
        if (!$token) {
            return response()->json([
                'success' => 'false',
                'message' => 'token is required.'
            ]);
        }

        if (!$unionid) {
            return response()->json([
                'success' => 'false',
                'message' => 'unionid is required.'
            ]);
        }
        $phaseA = env('OUTER_API_PHASE_A');
        $phaseB = env('OUTER_API_PHASE_B');
        $token_calculated = sha1($phaseA.$unionid.$phaseB);

        if ($token != $token_calculated) {
            return response()->json([
                'success' => 'false',
                'message' => 'token mismatch.'
            ]);
        }

        return $next($request);
    }
}
