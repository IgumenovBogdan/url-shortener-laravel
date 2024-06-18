<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\DangerousUrlException;
use App\Http\Requests\CreateLinkRequest;
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

    public function findOrCreate(CreateLinkRequest $request): ?Link
    {
        $existingLink = $this->linksRepository->findByUrl($request->url);

        if ($existingLink) {
            return $existingLink;
        }

        if (!$this->googleSafebrowsingService->isUrlSafe($request->url)) {
            // This exception is specifically handled in Exceptions/Handler.php
            throw new DangerousUrlException();
        }

        return $this->linksRepository->createLink($request->url);
    }

    public static function getShortenerPrefix(): string
    {
        //we can configure prefix by changing it in .env. By default, if the variable is not configured, then there is no prefix
        return Config::get('links.prefix');
    }
}
