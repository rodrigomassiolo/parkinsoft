<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\Rol;

class CheckMedico
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
        $api = substr ( $request->path(), 0,3 ) == 'api';
        if($api){
            $actualUser = $request->user('api');
            $rol = Rol::where([['id', '=', $actualUser['rol_id']]])->take(1)->get();
            if ($rol[0]->type != 1) {
                abort(403, 'Access denied');
            }
            return $next($request);
        }

        $user = $request->user();
        $rol = Rol::where([['id', '=', $user->rol_id]])->take(1)->get();

        if ($rol[0]->type != "1") {
            return redirect('welcome');
        }

        return $next($request);
    }
}
