<?php

namespace Matchappen\Http\Middleware;

use Closure;

/*
 * Trims whitespace from input data in the request.
 * Define fields with : and comma-separated list of fieldnames (dot-notated).
 *
 * Example for route definition:
 * 'middleware' => 'input.trim:name,user.age,description'
 *
 * Example for controller:
 * $this->middleware('input.trim:name,user.age,description');
 *
 */

class InputTrim
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string,... $field_to_trim
     * @return mixed
     */
    public function handle($request, Closure $next, $field_to_trim)
    {
        $input = $request->all();
        foreach (array_slice(func_get_args(), 2) as $field_to_trim) {
            if (array_has($input, $field_to_trim)) {
                array_set($input, $field_to_trim, trim(array_get($input, $field_to_trim)));
            }
        }
        $request->replace($input);

        return $next($request);
    }
}