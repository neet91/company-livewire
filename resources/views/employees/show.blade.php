<x-layouts::app :title="$employee->fullName()">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="grid gap-8 p-6 lg:grid-cols-[260px_1fr]">
                <div class="flex flex-col items-center gap-4">
                    <div class="flex h-40 w-40 items-center justify-center overflow-hidden rounded-3xl border border-zinc-200 bg-zinc-100 text-4xl font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                        {{ strtoupper(substr($employee->first_name, 0, 1).substr($employee->last_name, 0, 1)) }}
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('employees.edit', $employee) }}" class="rounded-full bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200" wire:navigate>
                            {{ __('Edit') }}
                        </a>
                        <a href="{{ route('employees.index') }}" class="rounded-full border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800" wire:navigate>
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Employee Details') }}</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50">{{ $employee->fullName() }}</h1>
                    </div>

                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('First Name') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">{{ $employee->first_name }}</dd>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Last Name') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">{{ $employee->last_name }}</dd>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Company') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">
                                {{ $employee->company?->name ?? __('No company') }}
                            </dd>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Email') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">
                                {{ $employee->email ?? __('No email') }}
                            </dd>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40 sm:col-span-2">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Phone') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">
                                {{ $employee->phone ?? __('No phone') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
