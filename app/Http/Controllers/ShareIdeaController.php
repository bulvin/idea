<?php

namespace App\Http\Controllers;

use App\Actions\ShareIdea;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class ShareIdeaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Idea $idea, ShareIdea $action) : RedirectResponse
    {
        Gate::authorize('workWith', $idea);

        return $action->share($idea)
            ? back()->with('success', 'Public link generated!')->with('share_panel_open', true)
            : back()->with('error', 'Could not generate a unique share code. Please try again.');
    }
}
