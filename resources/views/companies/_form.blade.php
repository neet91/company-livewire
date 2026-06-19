@php
    $isEdit = $company?->exists ?? false;
    $previewUrl = $company?->logoUrl();
@endphp

<form
    method="POST"
    action="{{ $action }}"
    enctype="multipart/form-data"
    x-data="{ previewUrl: @js($previewUrl), previewImage(event) { const file = event.target.files?.[0]; if (!file) return; this.previewUrl = URL.createObjectURL(file); } }"
    class="space-y-6"
>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <div class="grid gap-6 lg:grid-cols-[1fr_260px]">
            <div class="space-y-5">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Name') }}</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $company->name ?? '') }}"
                        required
                        autofocus
                        class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-900 focus:ring-2 focus:ring-zinc-200 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-zinc-300 dark:focus:ring-zinc-700"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Email') }}</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $company->email ?? '') }}"
                        required
                        class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-900 focus:ring-2 focus:ring-zinc-200 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-zinc-300 dark:focus:ring-zinc-700"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="website" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Website') }}</label>
                    <input
                        id="website"
                        name="website"
                        type="url"
                        value="{{ old('website', $company->website ?? '') }}"
                        placeholder="https://example.com"
                        class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-900 focus:ring-2 focus:ring-zinc-200 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-zinc-300 dark:focus:ring-zinc-700"
                    >
                    @error('website')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="logo" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Logo') }}</label>
                    <input
                        id="logo"
                        name="logo"
                        type="file"
                        accept="image/*"
                        x-on:change="previewImage"
                        class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-zinc-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-zinc-700 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:file:bg-white dark:file:text-zinc-900 dark:hover:file:bg-zinc-200"
                    >
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Optional. Uploaded logos are normalized to 100x100 PNG files in public storage.') }}</p>
                    @error('logo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="rounded-3xl border border-dashed border-zinc-300 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">{{ __('Logo Preview') }}</p>
                <div class="mt-4 flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-white shadow-sm dark:bg-zinc-900">
                    <template x-if="previewUrl">
                        <img :src="previewUrl" alt="{{ __('Company logo preview') }}" class="h-full w-full object-cover">
                    </template>
                    <template x-if="!previewUrl">
                        <div class="text-center">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-zinc-200 text-lg font-semibold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                                {{ strtoupper(substr($company->name ?? 'C', 0, 1)) }}
                            </div>
                            <p class="mt-3 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Choose an image to preview it here.') }}</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="flex items-center justify-between"> --}}
    <div>
        <button type="submit" class="rounded-full bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
            {{ $isEdit ? __('Update Company') : __('Create Company') }}
        </button>

        <div class="mt-4 ml-4">
        <a href="{{ route('companies.index') }}" class="text-sm font-semibold text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
            {{ __('Back to companies') }}
        </a>
        </div>
    </div>
</form>
