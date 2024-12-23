<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/api/cart',           // Example: Exclude cart API endpoint
        '/api/orders',         // Example: Exclude orders API endpoint
        '/api/products',       // Example: Exclude products API endpoint
        '/api/users',          // Example: Exclude users API endpoint
        '/api/orders/place',       // Example: Exclude checkout API endpoint
    ];
}
