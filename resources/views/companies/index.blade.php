<x-layouts::app :title="__('Companies')">
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ deleteTarget: null, deleteName: '' }" class="mx-auto flex w-full max-w-7xl flex-1 flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 rounded-3xl border border-zinc-200 bg-white/90 p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900/70 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Company Directory') }}</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50">{{ __('Companies') }}</h1>
                <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
                    {{ __('Create and manage company records, including a resized 100x100 logo stored in the public disk.') }}
                </p>
            </div>

            <a href="{{ route('companies.create') }}" class="inline-flex items-center justify-center rounded-full bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200" wire:navigate>
                {{ __('New Company') }}
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            @if ($companies->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-700">
                        <thead class="bg-zinc-50 text-xs uppercase tracking-[0.2em] text-zinc-500 dark:bg-zinc-950/40 dark:text-zinc-400">
                            <tr>
                                <th class="px-6 py-4">{{ __('Logo') }}</th>
                                <th class="px-6 py-4">{{ __('Name') }}</th>
                                <th class="px-6 py-4">{{ __('Email') }}</th>
                                <th class="px-6 py-4">{{ __('Website') }}</th>
                                <th class="px-6 py-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($companies as $company)
                                <tr class="align-top">
                                    <td class="px-6 py-4">
                                        <div class="h-16 w-16 overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800">
                                            <img src="{{ $company->logoUrl() }}" alt="{{ $company->name }}" class="h-full w-full object-cover">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('companies.show', $company) }}" class="font-semibold text-zinc-900 hover:underline dark:text-zinc-50" wire:navigate>
                                            {{ $company->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">{{ $company->email }}</td>
                                    <td class="px-6 py-4">
                                        @if ($company->website)
                                            <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="text-sky-600 hover:underline dark:text-sky-400">
                                                {{ $company->website }}
                                            </a>
                                        @else
                                            <span class="text-zinc-400">{{ __('No website') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('companies.edit', $company) }}" class="rounded-full border border-zinc-300 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800" wire:navigate>
                                                {{ __('Edit') }}
                                            </a>
                                            <button
                                                type="button"
                                                x-on:click="deleteTarget = @js(route('companies.destroy', $company)); deleteName = @js($company->name)"
                                                class="rounded-full border border-red-200 bg-red-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-red-700 transition hover:bg-red-100 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-200"
                                            >
                                                {{ __('Delete') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-700">
                    {{ $companies->links() }}
                </div>
            @else
                <div class="flex flex-col items-start gap-4 px-6 py-16">
                    <div class="max-w-xl">
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-50">{{ __('No companies yet') }}</h2>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ __('Add the first company to start building your directory.') }}
                        </p>
                    </div>
                    <a href="{{ route('companies.create') }}" class="inline-flex items-center justify-center rounded-full bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200" wire:navigate>
                        {{ __('Create Company') }}
                    </a>
                </div>
            @endif
        </div>

        <div x-cloak x-show="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-zinc-950/70" x-on:click="deleteTarget = null"></div>
            <div class="relative w-full max-w-lg rounded-3xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-50">{{ __('Delete company?') }}</h2>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    <span x-text="deleteName"></span>
                    {{ __('will be permanently removed, along with its stored logo.') }}
                </p>

                <form method="POST" :action="deleteTarget" class="mt-6 flex items-center justify-end gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" x-on:click="deleteTarget = null" class="rounded-full border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-500">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
