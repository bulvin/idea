@props(['idea' => new App\Models\Idea()])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}">
    <form
    x-data="{
        status: @js(old('status', $idea->status->value)),
        newLink: '',
        links: @js(old('links', $idea->links ?? [])),
        hasImage: false,
        newStep: '',
        steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed', 'completed_at']))),
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
        addStep() {
            const description = this.newStep.trim();
            if (description.length > 0) {
                this.steps = [...this.steps, { description, completed: false, completed_at: '' }];
                this.newStep = '';
            }
        },
        removeStep(index) {
            this.steps = this.steps.filter((_, i) => i !== index);
        },
    }"
     method="POST"
     action="{{ $idea->exists ? route('ideas.update', $idea) : route('ideas.store') }}"
     enctype="multipart/form-data"
     x-bind:enctype="hasImage ? 'multipart/form-data' : false"
    >
        @csrf

        @if ($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-forms.field
                label="Title"
                name="title"
                placeholder="Enter an idea's title"
                autofocus
                required
                :value="$idea->title"
            />

            <x-forms.field
                label="Description"
                name="description"
                type="textarea"
                placeholder="Describe your idea..."
                :value="$idea->description"
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

            <div class="space-y-2">
                <label for="image" class="label">Featured image</label>

                @if ($idea->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-auto object-cover rounded-lg">
                     </div>

                     <button class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove Image</button>
                 @endif

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

                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input type="hidden" :name="`steps[${index}][id]`" :value="step.id ?? ''" readonly>
                            <input class="input" :name="`steps[${index}][description]`" x-model="step.description" readonly>
                            <input type="hidden" class="input" :name="`steps[${index}][completed]`" :value="step.completed ? '1' : '0'" readonly>
                            <input type="hidden" :name="`steps[${index}][completed_at]`" :value="step.completed_at ?? ''" readonly>
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
            <button data-test="addedit-idea" type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
        </div>
    </form>

    @if ($idea->image_path)
        <form method="POST" action="{{ route('ideas.image.destroy', $idea) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
