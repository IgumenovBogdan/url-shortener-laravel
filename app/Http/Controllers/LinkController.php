<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Http\Resources\UrlResource;
use App\Services\LinkService;
use Illuminate\Http\JsonResponse;

class LinkController extends Controller
{
    public function __construct(
        private readonly LinkService $linkService
    ) {
    }

    public function store(CreateLinkRequest $request): JsonResponse
    {
        $link = $this->linkService->findOrCreate($request);

        return response()->json(new UrlResource($link));
    }

    public function show(string $token): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $link = $this->linkService->showLink($token);

        return redirect($link->original_url);
    }
}
