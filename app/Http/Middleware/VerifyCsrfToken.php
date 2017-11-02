<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/payment/*'
	,'/api/*'
    ];

    // public function handle($request, Closure $next)
    // {
    //     // 如果是来自 ajax，就跳过检查
    //     // if (\Request::ajax())
    //     // {
    //     //     return parent::handle($request, $next);
    //     // }

    //     return $next($request);
    // }
}
