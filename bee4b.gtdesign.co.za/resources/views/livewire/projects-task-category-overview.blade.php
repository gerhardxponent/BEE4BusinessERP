<div class="space-y-6">
    <div class="mb-4 flex flex-wrap gap-6 text-xs text-gray-700">
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-6 rounded bg-emerald-500">&nbsp;</span>
            <span>Complete</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-6 rounded bg-blue-500">&nbsp;</span>
            <span>Active</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-6 rounded bg-gray-400">&nbsp;</span>
            <span>Inactive</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-6 rounded bg-red-500">&nbsp;</span>
            <span>Red Flagged</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-6 rounded bg-gray-200 border border-gray-300">&nbsp;</span>
            <span>Remaining / Not Started</span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search client / project"
            class="w-80 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-200" />
    </div>

    @forelse ($clients as $client)
        @php
            // keep only projects that are NOT fully complete (sum of 4 cats = 400)
            $visibleProjects = array_values(array_filter($client['projects'], function ($project) {
                return array_reduce(
                    $project['categories'],
                    fn($acc, $c) => $acc + (int) ($c['percent']['complete'] ?? 0),
                    0
                ) !== 400;
            }));
        @endphp

        @continue(empty($visibleProjects))
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="mb-3 text-sm text-gray-500">
                <span class="font-semibold text-gray-800">{{ $client['client'] }}</span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($visibleProjects as $project)
                    @php
                        $sumComplete = array_reduce(
                            $project['categories'],
                            fn($acc, $c) => $acc + (int) ($c['percent']['complete'] ?? 0),
                            0
                        );
                        $flagged = $project['red_flagged'] ?? false;  // ⬅️ guard
                    @endphp

                    @continue($sumComplete === 400)

                    <div class="rounded-lg p-3 border {{ $flagged ? 'bg-red-50' : 'bg-white border-gray-100' }}">
                        <div class="mb-2 flex items-center justify-between text-xs text-gray-600">
                            <div>
                                <a style='font-weight:bold'
                                    href="{{ url('clients/' . $project['client_id'] . '?project=' . $project['board_id']) }}"
                                    class="{{ $flagged ? 'text-red-700' : 'text-indigo-600 hover:underline' }}">
                                    {{ date('Y', strtotime($project['created_at'])) }}
                                </a>
                            </div>
                            @if($flagged)
                                <span
                                    class="inline-flex items-center rounded bg-red-100 px-1.5 py-0.5 text-[10px] font-medium text-red-700">
                                    Red flagged
                                </span>
                            @endif
                        </div>

                        <div class="space-y-2">
                            @foreach ($project['categories'] as $cat)
                                            @php
                                                $p = $cat['percent'];
                                                $pc = (int) ($p['complete'] ?? 0);
                                                $pa = (int) ($p['active'] ?? 0);
                                                $pi = (int) ($p['inactive'] ?? 0);
                                                $pr = (int) ($p['red_flag'] ?? 0);   // NEW

                                                // cumulative stops
                                                $s1 = $pc;
                                                $s2 = $pc + $pa;
                                                $s3 = $s2 + $pi;
                                                $s4 = $s3 + $pr;

                                                $s1 = min($s1, 100);
                                                $s2 = min($s2, 100);
                                                $s3 = min($s3, 100);
                                                $s4 = min($s4, 100);
                                            @endphp

                                            <div class="grid items-center gap-2" style="grid-template-columns: 140px 1fr;">
                                                <div
                                                    class="text-xs font-medium truncate pr-2 {{ $flagged ? 'text-red-800' : 'text-gray-800' }}">
                                                    {{ $cat['category'] }}
                                                </div>
                                                <div class="h-3 rounded-full overflow-hidden"
                                                    title="Complete {{ $pc }}% • Active {{ $pa }}% • Inactive {{ $pi }}% • Red Flag {{ $pr }}%"
                                                    style="background: linear-gradient(
                                    to right,
                                    #10B981 0% {{ $s1 }}%,
                                    #3B82F6 {{ $s1 }}% {{ $s2 }}%,
                                    #9CA3AF {{ $s2 }}% {{ $s3 }}%,
                                    #EF4444 {{ $s3 }}% {{ $s4 }}%,
                                    #F3F4F6 {{ $s4 }}% 100%
                                 );">&nbsp;
                                                </div>
                                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @empty
        <div class="text-sm text-gray-500">No projects found.</div>
    @endforelse
</div>