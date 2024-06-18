<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\DangerousUrlException;
use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkService
{
    public function __construct(
        private readonly LinkRepository $linksRepository,
        private readonly GoogleSafebrowsingService $googleSafebrowsingService
    ) {
    }

    public function showLink(string $token): ?Link
    {
        $link = $this->linksRepository->findByToken($token);

        if (!$link) {
            throw new NotFoundHttpException();
        }

        return $link;
    }

    public function findOrCreate(string $url): ?Link
    {
        $existingLink = $this->linksRepository->findByUrl($url);

        if ($existingLink) {
            return $existingLink;
        }

        if (!$this->googleSafebrowsingService->isUrlSafe($url)) {
            // This exception is specifically handled in Exceptions/Handler.php
            throw new DangerousUrlException();
        }

        return $this->linksRepository->createLink($url);
    }

    public static function getShortenerPrefix(): string
    {
        //we can configure prefix by changing it in .env. By default, if the variable is not configured, then there is no prefix
        return Config::get('links.prefix');
    }
}
