<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Support\Facades\Validator;

class ShowSharedIdeaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $code)
    {
        Validator::make(
            ['share_code' => $code],
            ['share_code' => ['required', 'string', 'size:11']],
        )->validate();

        $idea = Idea::query()
            ->where('share_code', $code)
            ->with('steps')
            ->sole();

        if ($idea->isShareCodeExpired()) {
            abort(404);
        }

        return view('ideas.share', [
            'idea' => $idea,
        ]);
    }
}
