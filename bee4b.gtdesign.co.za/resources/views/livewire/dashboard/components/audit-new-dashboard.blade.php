{{-- Year tabs --}}
<div class="mb-2 flex items-center gap-2">
  @foreach($years as $y)
    @php
      $qs = http_build_query([
        'year' => $y,
        'search' => $search,
        'agency' => $agency,
        'analyst' => $analyst,
      ]);
    @endphp
    <a
      href="{{ request()->url() }}?{{ $qs }}"
      class="px-3 py-1 rounded-full text-sm font-semibold
             {{ (int)$year === (int)$y ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
      {{ $y }}
    </a>
  @endforeach
</div>

{{-- Filters --}}
<div class="mb-6">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 audit-dashboard-filters"
       x-data="{
         updateUrl() {
           const base = '{{ route('dashboard') }}';
           const params = new URLSearchParams(window.location.search);
           params.set('year', '{{ (int)$year }}');
           const search = this.$refs.search?.value ?? '';
           const agency = this.$refs.agency?.value ?? '';
           const analyst = this.$refs.analyst?.value ?? '';
           params.set('search', search);
           params.set('agency', agency);
           params.set('analyst', analyst);
           window.location.href = base + '?' + params.toString();
         },
         initFromUrl() {
           try {
             const params = new URLSearchParams(window.location.search);
             const s = params.get('search') ?? '';
             const a = params.get('agency') ?? '';
             const an = params.get('analyst') ?? '';
            if (this.$refs.search && s !== '' && this.$refs.search.value !== s) {
               this.$refs.search.value = s;
            }
            if (this.$refs.agency && a !== '' && this.$refs.agency.value !== a) {
               this.$refs.agency.value = a;
            }
            if (this.$refs.analyst && an !== '' && this.$refs.analyst.value !== an) {
               this.$refs.analyst.value = an;
            }
           } catch (e) { /* noop */ }
         }
       }"
       x-init="initFromUrl()">
    <style>
      /* Select2 sizing + layering for this dashboard */
      .audit-dashboard-filters .select2-container--default .select2-selection--single {
        height: 38px !important;
        min-height: 38px !important;
      }
      .audit-dashboard-filters .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 8px;
      }
      .audit-dashboard-filters .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px !important;
        top: 0 !important;
        right: 6px;
      }
      /* Ensure dropdown always overlays headers even when appended to <body> */
      .select2-container { z-index: 2147483647 !important; position: relative; }
      .select2-dropdown.select2-dropdown--below,
      .select2-dropdown.select2-dropdown--above { z-index: 2147483647 !important; }
    </style>
    <div class="flex items-center justify-between mb-3">
      <div class="text-sm font-semibold text-gray-700">Filters</div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-xs text-gray-500 mb-1">Search client</label>
        <input type="text" x-ref="search" wire:model.defer="search" placeholder="Type client name" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-200" />
      </div>
      <div>
        <label class="block text-xs text-gray-500 mb-1">Ratings agency</label>
        <select
          x-ref="agency"
          wire:ignore
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-200"
          x-init="$nextTick(() => { try { const $jq = window.jQuery || window.$; if ($jq) { $jq($el).select2({ width:'100%', dropdownParent: $jq('body') }); } } catch(e) { console.warn('select2 init (agency) failed', e); } })"
        >
          <option value="">All</option>
          @php
            $agencies = collect($this->months)
              ->flatMap(fn($m) => $m->clients)
              ->filter()
              ->map(fn($c) => $c->ratingAgency?->name)
              ->filter()
              ->unique()
              ->sort()
              ->values();
          @endphp
          @foreach($agencies as $ag)
            @php $opt = trim($ag); @endphp
            <option value="{{ $opt }}" @if(strtolower(trim((string)$this->agency)) === strtolower($opt)) selected @endif>{{ $ag }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs text-gray-500 mb-1">Analyst</label>
        <select
          x-ref="analyst"
          wire:ignore
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-200"
          x-init="$nextTick(() => { try { const $jq = window.jQuery || window.$; if ($jq) { $jq($el).select2({ width:'100%', dropdownParent: $jq('body') }); } } catch(e) { console.warn('select2 init (analyst) failed', e); } })"
        >
          <option value="">All</option>
          @php
            $analysts = collect($this->months)
              ->flatMap(fn($m) => $m->clients)
              ->filter()
              ->map(function($c){ return optional($c->getAnalyst)->name ?? optional($c->analyst)->name; })
              ->filter()
              ->unique()
              ->sort()
              ->values();
          @endphp
          @foreach($analysts as $an)
            @php $optA = trim($an); @endphp
            <option value="{{ $optA }}" @if(strtolower(trim((string)$this->analyst)) === strtolower($optA)) selected @endif>{{ $an }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="mt-4 flex justify-end gap-2">
      <x-jet-secondary-button type="button" x-on:click="
        if ($refs.search) $refs.search.value = '';
        if ($refs.agency) $refs.agency.value = '';
        if ($refs.analyst) $refs.analyst.value = '';
        updateUrl();
      ">Reset</x-jet-secondary-button>
      <x-jet-button type="button" x-on:click="updateUrl()">Apply Filters</x-jet-button>
    </div>
  </div>
</div>



<script>
  window.addEventListener('year-changed', e => console.log('year-changed:', e.detail));
</script>

{{-- Listen for the browser event from changeYear() --}}
<script>
  window.addEventListener('year-changed', e => {
    console.log('[year-changed] ->', e.detail);
  });
</script>

<div wire:key="audit-year-{{ $year }}">
    {{-- (optional temporary debug – helps you verify re-render) --}}
<div class="text-xs text-gray-500 mb-2">
  Selected year: <b>{{ $year }}</b> • Rendered: {{ now()->toTimeString() }}
</div>

{{-- Client-side URL updates handled by Alpine's updateUrl() on input changes --}}
    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        @forelse ($this->months as $month)
        <div class="bg-white p-4 rounded-lg">
            @php
                // show only clients whose next_audit falls in the selected year and match filters
                $clientsForYear = $month->clients->filter(function ($client) use ($year) {
                    $d = $client->next_audit; 
                    if (!$d) return false;
                    try {
                        if ((int)\Carbon\Carbon::parse($d)->year !== (int)$year) return false;
                    } catch (\Throwable $e) { return false; }

                    // search by client name
                    if (!empty($this->search)) {
                        if (stripos($client->name, $this->search) === false) return false;
                    }
                    // filter by agency name (case-insensitive)
                    if (!empty($this->agency)) {
                        $clientAgency = strtolower(trim($client->ratingAgency->name ?? ''));
                        if ($clientAgency !== strtolower(trim($this->agency))) return false;
                    }
                    // filter by analyst name (internal analyst preferred, else analyst) (case-insensitive)
                    if (!empty($this->analyst)) {
                        $anName = strtolower(trim(optional($client->getAnalyst)->name ?? optional($client->analyst)->name ?? ''));
                        if ($anName !== strtolower(trim($this->analyst))) return false;
                    }
                    return true;
                });
            @endphp

            <div class="text-lg font-bold flex justify-between items-center">
                <div>{{ $month->name }}</div>
                <div class="bg-indigo-500 text-white rounded-full w-8 h-8 flex justify-center items-center">
                    <div>{{ $clientsForYear->count() }}</div>
                </div>
            </div>


            <div>
                
                    <div class="border border-gray-200 rounded-lg overflow-hidden my-8">
                        <table class="border-collapse table-fixed w-full text-sm">
                            <thead>
                                <tr>
                                    <th class="border-b font-medium py-3 pl-8 text-slate-400 text-left">Client</th>
                                    <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Analyst</th>
                                    <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Audit Date</th>
                                    <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Audit date of
                                        engagement</th>
                                    <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Audit progress
                                    </th>
                                    <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Ratings agency
                                    </th>
                                    <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Rating analyst
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($clientsForYear as $client)
                                    @php
                                        $prog = $this->auditProgressFor($client->id);
                                        $a = (int) ($prog['approved'] ?? 0);
                                        $p = (int) ($prog['pending'] ?? 0);
                                        $r = (int) ($prog['rejected'] ?? 0);
                                        $s1 = $a;
                                        $s2 = $a + $p;
                                        $s3 = $s2 + $r;

                                        $auditDate = $client->next_audit;               // your requirement
                                        $engagementDate = $client->planned_audit_date ?? '—';
                                        $agencyName = $client->ratingAgency?->name ?? '—';
                                        $ratingAnalyst = $client->ratingAnalyst?->name ?? '—';
                                        $analystInitials = $client->getAnalyst
                                            ? $this->generateInitials($client->getAnalyst->name)
                                            : '';
                                    @endphp

                                    <tr>
                                        {{-- Client --}}
                                        <td class="border-b border-gray-200 p-4 pl-8 text-slate-500">
                                            <a class="table-link"
                                                href="{{ url('clients/' . $client->id) }}">{{ $client->name }}</a>
                                        </td>

                                        {{-- Analyst (initials) --}}
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            {{ $analystInitials }}
                                        </td>

                                        {{-- Audit Date --}}
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            {{ $auditDate ?? '—' }}
                                        </td>

                                        {{-- Audit date of engagement (clients.planned_audit_date) --}}
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            {{ $engagementDate }}
                                        </td>

                                        {{-- Audit progress (approved / pending / rejected) --}}
                                        <td class="border-b border-gray-200 p-4 text-slate-500">
                                            <div class="h-2 rounded-full overflow-hidden"
                                                title="Approved {{ $a }}% • Pending {{ $p }}% • Rejected {{ $r }}%" style="background: linear-gradient(
                                                to right,
                                                #10B981 0% {{ $s1 }}%,
                                                #3B82F6 {{ $s1 }}% {{ $s2 }}%,
                                                #EF4444 {{ $s2 }}% {{ $s3 }}%,
                                                #E5E7EB {{ $s3 }}% 100%
                                            );">
                                            </div>
                                            <!--<div class="mt-1 text-[11px] text-gray-500">
                                                                Approved {{ $a }}% • Pending {{ $p }}% • Rejected {{ $r }}%
                                                            </div>-->
                                        </td>

                                        {{-- Ratings agency --}}
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            {{ $agencyName }}
                                        </td>

                                        {{-- Rating analyst --}}
                                        <td class="border-b border-gray-200 p-4 pr-8 text-slate-500 text-center">
                                            {{ $ratingAnalyst }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    {{-- <div wire:pagination>
                        {{ $month->clients()->paginate($perPage, ['*'], 'page_' . $month->id)->links() }}
                    </div> --}}

            </div>
        </div>
        @endforeach
    </div>
</div>
