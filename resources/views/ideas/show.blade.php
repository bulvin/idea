<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between items-center flex-wrap">
            <a href="{{ route('ideas.index') }}" class="flex items-center gap-x-2 text-sm font-medium mb-6">
                <x-icons.arrow-back />
                Back to Ideas
            </a>
            <div class="flex w-full flex-col items-start gap-3 sm:w-auto sm:items-end">
                <div class="flex flex-wrap items-center gap-3">
                    <button x-data type="button" class="btn btn-outlined" data-test="edit-idea-button"
                        @click="$dispatch('open-modal', 'edit-idea')">
                        <x-icons.external />
                        Edit Idea
                    </button>
                    <form method="POST" action="{{ route('ideas.destroy', $idea) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outlined text-red-500">Delete</button>
                    </form>
                    <div x-data="{
                        link: @js($idea->shareLink),
                        copied: false,
                        panelOpen: @js(session('share_panel_open', false)),
                        async copy() {
                            await navigator.clipboard.writeText(this.link);
                            this.copied = true;
                            setTimeout(() => (this.copied = false), 2000);
                        },
                    }" class="relative">
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('ideas.code.store', $idea) }}">
                                @csrf
                                <button type="submit" class="btn btn-outlined">
                                    {{ $idea->share_code ? 'Rotate link' : 'Share' }}
                                </button>
                            </form>

                            @if ($idea->share_code)
                            <button type="button" class="btn btn-outlined w-24" @click="panelOpen = true"
                                x-show="!panelOpen"
                                @if(session('share_panel_open')) style="display:none;" @endif>
                                Show link
                            </button>
                            <button type="button" class="btn btn-outlined w-24" @click="panelOpen = false"
                                x-show="panelOpen"
                                @if(!session('share_panel_open')) style="display:none;" @endif>
                                Hide link
                            </button>
                        @endif
                        </div>

                        @if ($idea->share_code)
                            <div
                                x-show="panelOpen"
                                style="display: none;"
                                x-transition
                                class="absolute right-0 top-full z-10 mt-2 w-72 rounded-lg border border-primary/25 bg-background p-2 font-mono text-sm text-foreground shadow-md"
                            >
                                <div class="min-w-0">
                                    <p class="break-all">{{ $idea->shareLink }}</p>
                                    @if ($idea->share_code_expires_at)
                                        <p class="mt-1 text-xs {{ $idea->isShareCodeExpired() ? 'text-red-500' : 'text-amber-500' }}">
                                            Expires: {{ $idea->share_code_expires_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_ABSOLUTE) }}
                                        </p>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-outlined px-2 py-1 text-xs"
                                        @click="copy()"
                                        x-bind:aria-label="copied ? 'Copied' : 'Copy share link'">
                                        <span x-show="!copied" x-cloak>Copy</span>
                                        <span x-show="copied" x-cloak class="text-primary">Copied</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-8 space-y-6">
            @if ($idea->image_path)
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $idea->image_path) }}" class="w-full h-auto object-cover">
                </div>
            @endif
            <h1 class="font-bold text-4xl">{{ $idea->title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-status-label :status="$idea->status">
                    {{ $idea->status->label() }}
                </x-status-label>

                <div class="text-muted-foreground text-sm mt-2">
                    {{ $idea->created_at->diffForHumans() }}
                </div>
            </div>

            @if ($idea->description)
                <x-card class="mt-6" is="div">
                    <div class="prose prose-invert max-w-none cursor-pointer text-foreground">
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
                                <form method="POST" action="{{ route('steps.update', $step) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="flex items-center gap-x-3">
                                        <button type="submit" role="checkbox"
                                            class="size-5 flex items-center justify-center rounded-lg text-primary-foreground {{ $step->completed ? 'bg-primary' : 'border border-primary' }}">&check;</button>
                                        <span
                                            class="{{ $step->completed ? 'line-through text-muted-foreground' : '' }}">{{ $step->description }}</span>

                                        @if ($step->completed_at)
                                            <span
                                                class="ml-auto shrink-0 text-sm text-muted-foreground">{{ $step->completed_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </form>
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

        <x-idea.modal :idea="$idea" />
    </div>
</x-layout>
