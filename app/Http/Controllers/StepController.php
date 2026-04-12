<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Step $step)
    {
        $step->update(['completed' => ! $step->completed]);

        return back();
    }
}
