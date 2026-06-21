<x-layouts::app :title="$company->name">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="grid gap-8 p-6 lg:grid-cols-[260px_1fr]">
                <div class="flex flex-col items-center gap-4">
                    <div class="h-40 w-40 overflow-hidden rounded-3xl border border-zinc-200 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800">
                        @if ($company->logoUrl())
                            <img src="{{ $company->logoUrl() }}" alt="{{ $company->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-4xl font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">
                                {{ substr($company->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('companies.edit', $company) }}" class="rounded-full bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200" wire:navigate>
                            {{ __('Edit') }}
                        </a>
                        <a href="{{ route('companies.index') }}" class="rounded-full border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800" wire:navigate>
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Company Details') }}</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50">{{ $company->name }}</h1>
                    </div>

                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Email') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">{{ $company->email }}</dd>
                        </div>

                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Website') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">
                                @if ($company->website)
                                    <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="text-sky-600 hover:underline dark:text-sky-400">
                                        {{ $company->website }}
                                    </a>
                                @else
                                    {{ __('No website') }}
                                @endif
                            </dd>
                        </div>

                        {{-- <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-950/40 sm:col-span-2">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Stored Logo') }}</dt>
                            <dd class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-50">
                                {{ $company->logo ?? __('No logo uploaded') }}
                            </dd>
                        </div> --}}
                    </dl>
                </div>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 dark:border-zinc-700 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">{{ __('Employee Details') }}</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50">
                        {{ trans_choice('{0} No employees|{1} :count employee|[2,*] :count employees', $employees->count()) }}
                    </h2>
                </div>

                {{-- <a href="{{ route('employees.create') }}" class="inline-flex items-center justify-center rounded-full bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200" wire:navigate>
                    {{ __('New Employee') }}
                </a> --}}
            </div>

            @if ($employees->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-700">
                        <thead class="bg-zinc-50 text-xs uppercase tracking-[0.2em] text-zinc-500 dark:bg-zinc-950/40 dark:text-zinc-400">
                            <tr>
                                <th class="px-6 py-4">{{ __('First Name') }}</th>
                                <th class="px-6 py-4">{{ __('Last Name') }}</th>
                                <th class="px-6 py-4">{{ __('Email') }}</th>
                                <th class="px-6 py-4">{{ __('Phone') }}</th>
                                {{-- <th class="px-6 py-4">{{ __('Actions') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($employees as $employee)
                                <tr class="align-top">
                                    <td class="px-6 py-4">
                                        {{-- <a href="{{ route('employees.show', $employee) }}" class="font-semibold text-zinc-900 hover:underline dark:text-zinc-50" wire:navigate> --}}
                                            {{ $employee->first_name }}
                                        {{-- </a> --}}
                                    </td>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">{{ $employee->last_name }}</td>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">
                                        {{ $employee->email ?? __('No email') }}
                                    </td>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">
                                        {{ $employee->phone ?? __('No phone') }}
                                    </td>
                                    {{-- <td class="px-6 py-4">
                                        <a href="{{ route('employees.edit', $employee) }}" class="rounded-full border border-zinc-300 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800" wire:navigate>
                                            {{ __('Edit') }}
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-50">{{ __('No employees yet') }}</h3>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Employees assigned to this company will appear here.') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
