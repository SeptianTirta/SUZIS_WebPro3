<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    public function hosts(): array
    {
        return [
            '*.ngrok-free.app',
            '*.ngrok-free.dev',  // tambahkan ini karena URL kamu pakai .dev
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
