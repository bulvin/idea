<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UpdateIdea
{
    public function update(array $attributes, Idea $idea): void
    {
        $data = collect($attributes)
            ->only(["title", "description", "status", "links"])
            ->toArray();

        if ($attributes["image"] ?? false) {
            $data["image_path"] = $attributes["image"]->store(
                "ideas",
                "public",
            );
        }

        DB::transaction(function () use ($idea, $data, $attributes) {
            $originalIdea = $idea->getOriginal();
            $originalSteps = $idea
                ->steps()
                ->get(["description", "completed", "completed_at"])
                ->toArray();

            $idea->update($data);

            $idea->steps()->delete();
            $idea->steps()->createMany($attributes["steps"] ?? []);

            $idea->histories()->create([
                "idea_id" => $originalIdea["id"],
                "user_id" => Auth::id(),
                "title" => $originalIdea["title"],
                "description" => $originalIdea["description"],
                "status" => $originalIdea["status"],
                "image_path" => $originalIdea["image_path"],
                "links" => $originalIdea["links"],
                "steps" => $originalSteps ?? [],
            ]);
        });
    }
}
