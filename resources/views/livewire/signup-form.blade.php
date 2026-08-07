<div class="container">
    @if ($form->heading)
        <h2 class="type-medium mt-12 mb-4">{{ $form->heading }}</h2>
    @endif

    @if ($submitted)
        <div class="bg-yellow border px-4 py-3 rounded relative my-8 max-w-lg" role="status" aria-live="polite">
            {{ $form->success_message ?: 'Thanks — you have successfully signed up!' }}
        </div>
    @else
        @if ($form->intro)
            <div class="max-w-lg mb-8">{{ $form->intro }}</div>
        @endif

        @if ($formError)
            <div class="bg-yellow border px-4 py-3 rounded relative my-8 max-w-lg" role="alert" aria-live="assertive">
                {{ $formError }}
            </div>
        @endif

        <form wire:submit="submit" class="mt-8">
            <label for="firstName-{{ $form->id }}" class="block">First name
                <input type="text" wire:model="firstName" id="firstName-{{ $form->id }}"
                    class="max-w-full block border p-4 w-64 mt-2" autocomplete="given-name">
            </label>
            @error('firstName')
                <p class="mt-1 text-sm">{{ $message }}</p>
            @enderror

            <label for="lastName-{{ $form->id }}" class="block mt-4">Last name
                <input type="text" wire:model="lastName" id="lastName-{{ $form->id }}"
                    class="border p-4 w-64 max-w-full block mt-2" autocomplete="family-name">
            </label>
            @error('lastName')
                <p class="mt-1 text-sm">{{ $message }}</p>
            @enderror

            <label for="email-{{ $form->id }}" class="block mt-4">Email
                <input type="email" wire:model="email" id="email-{{ $form->id }}"
                    class="border p-4 w-64 max-w-full block mt-2" autocomplete="email">
            </label>
            @error('email')
                <p class="mt-1 text-sm">{{ $message }}</p>
            @enderror

            @if ($statements->isNotEmpty())
                <fieldset class="mt-12">
                    <legend class="type-medium mb-4">Contact preferences</legend>
                    @foreach ($statements as $statement)
                        <label for="statement-{{ $form->id }}-{{ $statement->id }}" class="block">
                            <input type="checkbox" wire:model="selectedStatements" value="{{ $statement->id }}"
                                id="statement-{{ $form->id }}-{{ $statement->id }}" class="mr-2">
                            {{ $statement->text }}
                        </label>
                    @endforeach
                </fieldset>
            @endif

            @foreach ($tagsByGroup as $groupName => $tags)
                <fieldset class="mt-12">
                    @if ($groupName)
                        <legend class="type-small mb-4">{{ $groupName }}</legend>
                    @endif
                    @foreach ($tags as $tag)
                        <label for="tag-{{ $form->id }}-{{ $tag->id }}" class="block">
                            <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}"
                                id="tag-{{ $form->id }}-{{ $tag->id }}" class="mr-2">
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </fieldset>
            @endforeach

            <button type="submit" class="bg-black text-white p-4 mt-8" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="submit">Submit</span>
                <span wire:loading wire:target="submit">Signing you up…</span>
            </button>
        </form>
    @endif
</div>
