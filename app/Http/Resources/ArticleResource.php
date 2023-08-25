<?php

namespace App\Http\Resources;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organizer_id' => $this->organizer_id,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'translations' => TranslationResource::collection($this->whenLoaded('translations')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'organizer' => new OrganizerResource($this->whenLoaded('organizer')),
        ];
    }
}
