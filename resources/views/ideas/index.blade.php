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

                        <div class="mt-5 line-clamp-3"> {{ $idea->description }}</div>
                        <div class="mt-4"> {{ $idea->created_at->diffForHumans() }}</div>
                    </x-card>
                @empty
                    <x-card>
                        <p>No ideas at this time.</p>
                    </x-card>
                @endforelse
            </div>
        </div>

        <x-modal name="create-idea" title="New Idea">
            <form
            x-data="{
                status: 'pending',
                newLink: '',
                links: [],
                hasImage: false,
                addLink() {
                    const val = this.newLink.trim();
                    if (val) {
                        this.links = [...this.links, val];
                        this.newLink = '';
                    }
                },
                removeLink(index) {
                    this.links = this.links.filter((_, i) => i !== index);
                },
                newStep: '',
                steps: [],
                addStep() {
                    const val = this.newStep.trim();
                    if (val) {
                        this.steps = [...this.steps, val];
                        this.newStep = '';
                    }
                },
                removeStep(index) {
                    this.steps = this.steps.filter((_, i) => i !== index);
                },
            }"
             method="POST"
             action="{{ route('ideas.store') }}"
             x-bind:enctype="hasImage ? 'multipart/form-data : false"
            >
                @csrf

                <div class="space-y-6">
                    <x-forms.field
                        label="Title"
                        name="title"
                        placeholder="Enter an idea's title"
                        autofocus
                        required
                    />

                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>

                        <div class="flex gap-x-3">
                            @foreach (App\IdeaStatus::cases() as $status)
                                <button
                                    type="button"
                                    @click="status = @js($status->value)"
                                    data-test="button-status-{{ $status->value }}"
                                    class="btn flex-1 h-10"
                                    :class="{'btn-outlined': status !== @js($status->value)}">
                                    {{ $status->label() }}
                                </button>
                            @endforeach

                            <input type="hidden" name="status" :value="status" class="input">
                        </div>

                        <x-forms.error name="status" />
                    </div>

                    <x-forms.field
                        label="Description"
                        name="description"
                        type="textarea"
                        placeholder="Describe your idea"
                        autofocus
                    />

                    <div class="space-y-2">
                        <label for="image" class="label">Featured image</label>
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            @change="hasImage = $event.target.files.length > 0"
                        >
                        <x-forms.error name="image" />
                    </div>

                    <div>
                        <fieldset class="space-y-3">
                            <legend class="label">Actionable Steps</legend>

                            <template x-for="(step, index) in steps" :key="step">
                                <div class="flex gap-x-2 items-center">
                                    <input class="input" name="steps[]" x-model="step" readonly>
                                    <button
                                        type="button"
                                        @click="removeStep(index)"
                                        aria-label="Remove link"
                                        class="form-muted-icon"
                                    >
                                        <x-icons.close />
                                    </button>
                                </div>
                            </template>

                            <div class="flex gap-x-2 items-center">
                                <input
                                    x-model="newStep"
                                    id="new-step"
                                    data-test="new-step"
                                    placeholder="What needs to be done?"
                                    class="input flex-1"
                                    spellcheck="false"
                                >
                                <button
                                    type="button"
                                    @click="addStep()"
                                    :disabled="newStep.trim().length === 0"
                                    aria-label="Add link button"
                                    class="form-muted-icon"
                                    data-test='submit-new-step-button'
                                >
                                    <x-icons.close class="rotate-45" />
                                </button>
                            </div>
                        </fieldset>
                    </div>

                    <div>
                        <fieldset class="space-y-3">
                            <legend class="label">Links</legend>

                            <template x-for="(link, index) in links" :key="link">
                                <div class="flex gap-x-2 items-center">
                                    <input class="input" name="links[]" x-model="link" readonly>
                                    <button
                                        type="button"
                                        @click="removeLink(index)"
                                        aria-label="Remove link"
                                        class="form-muted-icon"
                                    >
                                        <x-icons.close />
                                    </button>
                                </div>
                            </template>

                            <div class="flex gap-x-2 items-center">
                                <input
                                    x-model="newLink"
                                    type="url"
                                    id="new-link"
                                    data-test="new-link"
                                    placeholder="http://example.com"
                                    autocomplete="url"
                                    class="input flex-1"
                                    spellcheck="false"
                                >
                                <button
                                    type="button"
                                    @click="addLink()"
                                    :disabled="newLink.trim().length === 0"
                                    aria-label="Add link button"
                                    class="form-muted-icon"
                                    data-test='submit-new-link-button'
                                >
                                    <x-icons.close class="rotate-45" />
                                </button>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="flex justify-end gap-x-5 mt-4">
                    <button type="button" @click="$dispatch('close-modal')">Cancel</button>
                    <button type="submit" class="btn">Create</button>
                </div>
            </form>
        </x-modal>

    </div>
</x-layout>
