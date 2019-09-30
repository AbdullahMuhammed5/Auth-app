<?php

namespace App\Http\Middleware;

use App\Job;
use Closure;
use Illuminate\Http\Request;

class WriterAndReporter
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route('job')->id;
        $job = Job::whereId($id)->pluck('name')->first();
        $exceptions = ['Writer', 'Reporter'];
        if (!in_array($job, $exceptions) ){
            return $next($request);
        }
        return abort(403, 'Unauthorized action.');
    }
}
