<?php

namespace Control\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
      '8484979d35fb8bc1b64ac580c04c840bd7ea0b51058372e00e1f7085046f/*'
    ];
}
