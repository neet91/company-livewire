<x-layouts::app :title="__('Edit Company')">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Company Directory') }}</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50">{{ __('Edit Company') }}</h1>
        </div>

        @include('companies._form', [
            'company' => $company,
            'action' => route('companies.update', $company),
            'method' => 'PUT',
        ])
    </div>
</x-layouts::app>
