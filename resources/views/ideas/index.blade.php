<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">Make a plan</p>

            <x-card
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                is="button"
                type="button"
                class="mt-10 cursor-pointer h-32 w-full text-left"
                data-test="create-idea-button"
            >
                <p>What's the idea?</p>
            </x-card>
        </header>

        <div>
            <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">All</a>
            @foreach (App\IdeaStatus::cases() as $status)
                <a href="/ideas?status={{ $status->value }}"
                   class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">
                   {{ $status->label() }}
                   <span class="text-xs pl-3">{{ $statusCounts->get($status->value) }}</span>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($ideas as $idea)
                    <div>
                        <x-card href="{{ route('ideas.show', $idea) }}">
                            @if ($idea->image_path)
                                <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-auto object-cover">
                                </div>
                            @endif
                            <h3 class="text-foreground text-lg">
                                {{ $idea->title }}
                            </h3>
                            <div>
                                <x-status-label :status="$idea->status">
                                    {{ $idea->status->label() }}
                                </x-status-label>
                            </div>

                            <div class="prose prose-invert mt-5 line-clamp-3">{!! $idea->formattedDescription !!}</div>
                            <div class="mt-4"> {{ $idea->created_at->diffForHumans() }}</div>
                        </x-card>
                    </div>
                @empty
                    <x-card>
                        <p>No ideas at this time.</p>
                    </x-card>
                @endforelse
            </div>
        </div>

        <x-idea.modal />

    </div>
</x-layout>
