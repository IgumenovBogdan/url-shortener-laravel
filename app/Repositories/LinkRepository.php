<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\TokenMaxTriesException;
use App\Models\Link;
use App\Services\TokenService;
use Illuminate\Database\UniqueConstraintViolationException;

class LinkRepository
{
    public function __construct(
        private readonly TokenService $tokenService
    ) {}

    public function getUrlHash(string $url): string
    {
        return md5($url);
    }

    public function findByToken(string $token): ?Link
    {
        return Link::where('token', $token)->first();
    }

    public function findByUrl(string $url): ?Link
    {
        return Link::where('original_url', $url)
            ->where('url_hash', $this->getUrlHash($url))
            ->first();
    }

    public function createLink(string $originalUrl): Link
    {
        $maxAttempts = 5;
        $attempt = 0;

        // For cases of collisions during parallel generation of tokens under high load
        while ($attempt < $maxAttempts) {
            $token = $this->tokenService->createToken();

            try {
                return Link::create([
                    'original_url' => $originalUrl,
                    'url_hash' => $this->getUrlHash($originalUrl),
                    'token' => $token
                ]);
            } catch (UniqueConstraintViolationException $e) {
                $attempt++;
                if ($attempt >= $maxAttempts) {
                    throw new TokenMaxTriesException();
                }
            }
        }

        throw new TokenMaxTriesException();
    }
}
