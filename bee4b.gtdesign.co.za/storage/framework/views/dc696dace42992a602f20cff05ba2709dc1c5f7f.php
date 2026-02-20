
<div class="mb-2 flex items-center gap-2">
  <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
      $qs = http_build_query([
        'year' => $y,
        'search' => $search,
        'agency' => $agency,
        'analyst' => $analyst,
      ]);
    ?>
    <a
      href="<?php echo e(request()->url()); ?>?<?php echo e($qs); ?>"
      class="px-3 py-1 rounded-full text-sm font-semibold
             <?php echo e((int)$year === (int)$y ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
      <?php echo e($y); ?>

    </a>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="mb-6">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 audit-dashboard-filters"
       x-data="{
         updateUrl() {
           const base = '<?php echo e(route('dashboard')); ?>';
           const params = new URLSearchParams(window.location.search);
           params.set('year', '<?php echo e((int)$year); ?>');
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
          <?php
            $agencies = collect($this->months)
              ->flatMap(fn($m) => $m->clients)
              ->filter()
              ->map(fn($c) => $c->ratingAgency?->name)
              ->filter()
              ->unique()
              ->sort()
              ->values();
          ?>
          <?php $__currentLoopData = $agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $opt = trim($ag); ?>
            <option value="<?php echo e($opt); ?>" <?php if(strtolower(trim((string)$this->agency)) === strtolower($opt)): ?> selected <?php endif; ?>><?php echo e($ag); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
          <?php
            $analysts = collect($this->months)
              ->flatMap(fn($m) => $m->clients)
              ->filter()
              ->map(function($c){ return optional($c->getAnalyst)->name ?? optional($c->analyst)->name; })
              ->filter()
              ->unique()
              ->sort()
              ->values();
          ?>
          <?php $__currentLoopData = $analysts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $an): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $optA = trim($an); ?>
            <option value="<?php echo e($optA); ?>" <?php if(strtolower(trim((string)$this->analyst)) === strtolower($optA)): ?> selected <?php endif; ?>><?php echo e($an); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
    </div>
    <div class="mt-4 flex justify-end gap-2">
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.secondary-button','data' => ['type' => 'button','xOn:click' => '
        if ($refs.search) $refs.search.value = \'\';
        if ($refs.agency) $refs.agency.value = \'\';
        if ($refs.analyst) $refs.analyst.value = \'\';
        updateUrl();
      ']]); ?>
<?php $component->withName('jet-secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'button','x-on:click' => '
        if ($refs.search) $refs.search.value = \'\';
        if ($refs.agency) $refs.agency.value = \'\';
        if ($refs.analyst) $refs.analyst.value = \'\';
        updateUrl();
      ']); ?>Reset <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'button','xOn:click' => 'updateUrl()']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'button','x-on:click' => 'updateUrl()']); ?>Apply Filters <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>
  </div>
</div>



<script>
  window.addEventListener('year-changed', e => console.log('year-changed:', e.detail));
</script>


<script>
  window.addEventListener('year-changed', e => {
    console.log('[year-changed] ->', e.detail);
  });
</script>

<div wire:key="audit-year-<?php echo e($year); ?>">
    
<div class="text-xs text-gray-500 mb-2">
  Selected year: <b><?php echo e($year); ?></b> • Rendered: <?php echo e(now()->toTimeString()); ?>

</div>


    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $this->months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white p-4 rounded-lg">
            <?php
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
            ?>

            <div class="text-lg font-bold flex justify-between items-center">
                <div><?php echo e($month->name); ?></div>
                <div class="bg-indigo-500 text-white rounded-full w-8 h-8 flex justify-center items-center">
                    <div><?php echo e($clientsForYear->count()); ?></div>
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
                                <?php $__currentLoopData = $clientsForYear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
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
                                    ?>

                                    <tr>
                                        
                                        <td class="border-b border-gray-200 p-4 pl-8 text-slate-500">
                                            <a class="table-link"
                                                href="<?php echo e(url('clients/' . $client->id)); ?>"><?php echo e($client->name); ?></a>
                                        </td>

                                        
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            <?php echo e($analystInitials); ?>

                                        </td>

                                        
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            <?php echo e($auditDate ?? '—'); ?>

                                        </td>

                                        
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            <?php echo e($engagementDate); ?>

                                        </td>

                                        
                                        <td class="border-b border-gray-200 p-4 text-slate-500">
                                            <div class="h-2 rounded-full overflow-hidden"
                                                title="Approved <?php echo e($a); ?>% • Pending <?php echo e($p); ?>% • Rejected <?php echo e($r); ?>%" style="background: linear-gradient(
                                                to right,
                                                #10B981 0% <?php echo e($s1); ?>%,
                                                #3B82F6 <?php echo e($s1); ?>% <?php echo e($s2); ?>%,
                                                #EF4444 <?php echo e($s2); ?>% <?php echo e($s3); ?>%,
                                                #E5E7EB <?php echo e($s3); ?>% 100%
                                            );">
                                            </div>
                                            <!--<div class="mt-1 text-[11px] text-gray-500">
                                                                Approved <?php echo e($a); ?>% • Pending <?php echo e($p); ?>% • Rejected <?php echo e($r); ?>%
                                                            </div>-->
                                        </td>

                                        
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">
                                            <?php echo e($agencyName); ?>

                                        </td>

                                        
                                        <td class="border-b border-gray-200 p-4 pr-8 text-slate-500 text-center">
                                            <?php echo e($ratingAnalyst); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>

                        </table>
                    </div>

                    

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/dashboard/components/audit-new-dashboard.blade.php ENDPATH**/ ?>