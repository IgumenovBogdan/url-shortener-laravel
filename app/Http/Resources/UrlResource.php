<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\LinkService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'original_url' => $this->original_url,
            'short_url' => url('') . '/' . LinkService::getShortenerPrefix() . '/' . $this->token
        ];
    }
}
