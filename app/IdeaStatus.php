<?php

declare(strict_types=1);

namespace App;

enum IdeaStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed'
        };
    }

    public static function values(): array
    {
        return array_map(fn (IdeaStatus $status) => $status->value, self::cases());
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
            self::IN_PROGRESS => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
            self::COMPLETED => 'bg-primary/10 text-primary border-primary/20',
        };
    }
}
