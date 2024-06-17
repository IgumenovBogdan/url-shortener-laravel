<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Link;

class LinkRepository
{
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
}
