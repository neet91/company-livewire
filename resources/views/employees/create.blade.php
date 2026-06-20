<x-layouts::app :title="__('Create Employee')">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Employee Directory') }}</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50">{{ __('Create Employee') }}</h1>
        </div>

        @include('employees._form', [
            'employee' => $employee,
            'companies' => $companies,
            'action' => route('employees.store'),
            'method' => 'POST',
        ])
    </div>
</x-layouts::app>
