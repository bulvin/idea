<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Actions\UpdateIdea;
use App\Http\Requests\IdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $ideas = $user
            ->ideas()
            ->when(in_array($request->status, IdeaStatus::values()), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->get();

        return view('ideas.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request, CreateIdea $action)
    {
        $action->create($request->safe()->all());

        return to_route('ideas.index')
            ->with('success', 'Idea has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        return view('ideas.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea): void
    {
        Gate::authorize('workWith', $idea);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, Idea $idea, UpdateIdea $action)
    {
        Gate::authorize('workWith', $idea);

        $action->update($request->safe()->all(), $idea);

        return back()->with('success', 'Idea updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        $idea->delete();

        return to_route('ideas.index');
    }

    public function generateShareCode(Idea $idea): RedirectResponse
    {
        Gate::authorize('workWith', $idea);

        $maxAttempts = 5;
        for ($i = 0; $i < $maxAttempts; $i++) {
            $shareCode = Str::random(11);

            if (Idea::where('share_code', $shareCode)->exists()) {
                continue;
            }

            $idea->update([
                'share_code' => $shareCode,
                'share_code_expires_at' => now()->addDays(7)
            ]);

            return back()->with('success', "Public link generated!");
        }

        return back()->with('error', 'Could not generate a unique share code. Please try again.');
    }

    public function share(Request $request, Idea $idea)
    {
        /**
         * Given I'm sign in
         * and generate code (10 length, temporary - expires in 7 days, or when is a generated new one)
         * when idea is found by share code, then return view with that idea only as readonly for other users - also guests
         * otherwise notfound,
         */


    }
}
