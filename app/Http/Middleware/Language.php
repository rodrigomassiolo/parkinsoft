<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Language {

    public function __construct(Application $app, Request $request) {
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          if(in_array($request->segment(1), config('app.available_locale'))){
                $this->app->setLocale($request->segment(1));
          }else{
                $this->app->setLocale(config('app.locale'));
          }
    
          return $next($request);
    }

}