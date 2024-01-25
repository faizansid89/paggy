<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class AuthenticateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Token');

        if (!$token || !$this->isValidToken($token)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    private function isValidToken($apiToken)
    {
        // Split the token to retrieve the customer ID
        $parts = explode('-', $apiToken);
        $customerId = $parts[0];

        // Retrieve the customer based on the ID
        $customer = Customer::find($customerId);

        // Check if the customer exists and the token is valid
        if ($customer && $customer->api_token === $apiToken) {
            //if ($customer && $customer->api_token === $apiToken && $customer->token_expires_at >= Carbon::now()) {
            return true;
        }

        return false;
    }
}
