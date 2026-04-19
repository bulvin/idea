<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Step;

class StepController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Step $step)
    {
        $completed = ! $step->completed;
        $completed_at = $step->completed_at ?? now();

        $step->update([
            'completed' => $completed,
            'completed_at' => $completed ? $completed_at : null,
        ]);

        return back();
    }
}
