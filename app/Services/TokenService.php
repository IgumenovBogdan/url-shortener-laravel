<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\TokenMaxTriesException;
use App\Models\Link;
use Illuminate\Support\Str;

class TokenService
{
    public function createToken(): string
    {
        $try = 0;
        $maxTries = 10;
        while (true) {
            $token = Str::random(6);
            if (!Link::where('token', $token)->exists()) {
                break;
            }

            if ($try > $maxTries) {
                throw new TokenMaxTriesException();
            }

            $try++;
        }

        return $token;
    }
}
