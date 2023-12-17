<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Models\AuditLog as AuditLogModel;

class AuditLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $url = $request->url();
        $fullUrl = $request->fullUrl();
        $host = $request->schemeAndHttpHost();
        $ip = $request->ip();
        $path = str_replace($host,"",$url);
        $fullPath = str_replace($host,"",$fullUrl);
        $useId = $request->user() ? $request->user()->id : null;
        $logType = 'currency';
        $logDetail = [];

        switch ($path){
            case "/api/auth/login":
                $logType = "login";
                $logDetail["email"] = $request->input("email");
                $user = User::where('email',$request->input("email"))->first();

                if($user){
                    $useId = $user->id;
                }
                break;
            case "/api/auth/logout":
                $logType = "logout";
                $logDetail["email"] = $request->input("email");
                $user = User::where('email',$request->input("email"))->first();

                if($user){
                    $useId = $user->id;
                }
                break;
            case "/api/user":
                $logType = "create user";
                $logDetail["email"] = $request->input("email");
                break;
        }

        $auditLog = new AuditLogModel();
        $auditLog->user_id = $useId;
        $auditLog->ip = $ip;
        $auditLog->endpoint = $fullPath;
        $auditLog->log_type = $logType;
        $auditLog->log_detail = json_encode($logDetail);

        $auditLog->save();

        return $next($request);
    }
}
