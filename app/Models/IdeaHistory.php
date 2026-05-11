<?php

namespace App\Models;

use App\IdeaStatus;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdeaHistory extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaHistoryFactory> */
    use HasFactory;

    protected $casts = [
        'links' => AsArrayObject::class,
        'status' => IdeaStatus::class,
        'steps' => AsArrayObject::class
    ];

    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
