<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="mt-8 space-y-6">
            @if ($idea->image_path)
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' .$idea->image_path) }}" class="w-full h-auto object-cover">
                </div>
            @endif
            <h1 class="font-bold text-4xl">{{ $idea->title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-status-label :status="$idea->status">
                    {{ $idea->status->label() }}
                </x-status-label>

                <div class="text-muted-foreground text-sm mt-2">
                   {{  $idea->created_at->diffForHumans() }}
                </div>
            </div>

            @if ($idea->description)
                <x-card class="mt-6" is="div">
                    <div class="prose prose-invert max-w-none text-foreground">
                        {!! $idea->formattedDescription !!}
                    </div>
                </x-card>
            @endif

            @if ($idea->steps->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Actionable Steps</h3>

                    <div class="mt-6 space-y-2">
                        @foreach ($idea->steps as $step)
                            <x-card>
                                <div class="flex items-center gap-x-3">
                                    <button type="submit" role="checkbox" class="cursor-not-allowed size-5 flex items-center justify-center rounded-lg text-primary-foreground {{ $step->completed ? 'bg-primary' : 'border border-primary' }}">&check;</button>
                                    <span class="{{ $step->completed ? 'line-through text-muted-foreground' : '' }}">{{ $step->description }}</span>

                                    @if ($step->completed_at)
                                        <span class="ml-auto shrink-0 text-sm text-muted-foreground">{{ $step->completed_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($idea->links->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Links</h3>

                    <div class="mt-6 space-y-2">
                        @foreach ($idea->links as $link)
                            <x-card :href="$link" class="text-primary font-medium flex gap-x-3 items-center">
                                <x-icons.external />
                                {{ $link }}
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
