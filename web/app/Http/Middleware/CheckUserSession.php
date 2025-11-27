<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {//echo $request->session()->exists('userType').'dddd';//exit;
        if (!$request->session()->exists('accessToken') || !$request->session()->exists('userType')) {
			$request->session()->invalidate();
			return redirect()->route('login')->send();
			// $request->session()->flush();
			// Auth::logout();           
            
        }
        return $this->nocache($next($request));
    }

    protected function nocache($response)
    {
        $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
        $response->headers->set('Pragma','no-cache');

        return $response;
    }
}
