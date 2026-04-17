<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Support\Carbon;

class StepController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Step $step)
    {
        $completed = ! $step->completed;

        $step->update([
            'completed' => $completed,
            'completed_at' => $completed ? Carbon::now() : null,
        ]);

        return back();
    }
}
