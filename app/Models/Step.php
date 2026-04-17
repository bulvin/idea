<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Step extends Model
{
    /** @use HasFactory<StepFactory> */
    use HasFactory;

    protected $attributes = ['completed' => false];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
