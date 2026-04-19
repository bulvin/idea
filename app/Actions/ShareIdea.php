<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Idea;
use Illuminate\Support\Str;

class ShareIdea
{
    public  const int CODE_LENGTH  = 11;
    public  const int EXPIRY_DAYS  = 7;
    private const int MAX_ATTEMPTS = 5;

    public function share(Idea $idea): bool
    {
        for ($i = 0; $i < self::MAX_ATTEMPTS; $i++) {
            $shareCode = Str::random(self::CODE_LENGTH);

            $shareCodeIsAlreadyTaken = Idea::query()
                ->where('share_code', $shareCode)
                ->exists();

            if ($shareCodeIsAlreadyTaken) {
                continue;
            }

            $idea->update([
                'share_code' => $shareCode,
                'share_code_expires_at' => now()->addDays(self::EXPIRY_DAYS),
            ]);

            return true;
        }

        return false;
    }
}
