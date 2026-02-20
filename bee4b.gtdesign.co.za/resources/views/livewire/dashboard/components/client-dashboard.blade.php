<div>
    {{-- <div class="not-prose relative bg-gray-200 rounded-xl overflow-hidden dark:bg-slate-800/25">
        <div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
        <div class="relative rounded-xl overflow-auto">
            <div class="shadow-sm overflow-hidden my-8">
                <table class="border-collapse table-auto w-full text-sm">
                    <thead>
                    <tr>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Song</th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Artist</th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Year</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800">
                    <tr>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">Malcolm Lockyer</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">1961</td>
                    </tr>
                    <tr>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">Witchy Woman</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">The Eagles</td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">1972</td>
                    </tr>
                    <tr>
                        <td class="border-b border-slate-200 dark:border-slate-600 p-4 pl-8 text-slate-500 dark:text-slate-400">Shining Star</td>
                        <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">Earth, Wind, and Fire</td>
                        <td class="border-b border-slate-200 dark:border-slate-600 p-4 pr-8 text-slate-500 dark:text-slate-400">1975</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
    </div> --}}
    
    <div class="grid grid-cols-3 gap-4">
        @forelse ($this->months as $month)
            <div class="bg-white p-4 rounded-lg">
                <div class="text-lg font-bold flex justify-between items-center">
                    <div>{{ $month->name }}</div>
                    <div class="bg-indigo-500 text-white rounded-full w-8 h-8 flex justify-center items-center">
                        <div>{{ count($month->clients) }}</div>
                    </div>
                </div>

                <div>
                    @if (count($month->clients) != 0)
                        <div class="border border-gray-200 rounded-lg overflow-hidden my-8">
                            <table class="border-collapse table-fixed w-full text-sm">
                                <thead>
                                    <tr>
                                        <th class="border-b font-medium py-3 pl-8 text-slate-400 text-left">Client</th>
                                        <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Analyst</th>
                                        <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Audit Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    {{-- @foreach ($month->clients()->paginate($perPage, ['*'], 'page_' . $month->id) as $client) --}}
                                    @foreach ($month->clients as $client)
                                    <tr>
                                        <td class="border-b border-gray-200 p-4 pl-8 text-slate-500">
                                            <a class="table-link" href="./clients/{{ $client->id }}">{{ $client->name }}</a>
                                        </td>
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center">{{ $client->getAnalyst != null ? $this->generateInitials($client->getAnalyst->name) : '' }}</td>
                                        <td class="border-b border-gray-200 p-4 pr-8 text-slate-500">{{ $client->next_audit }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- <div wire:pagination>
                            {{ $month->clients()->paginate($perPage, ['*'], 'page_' . $month->id)->links() }}
                        </div> --}}
                    @else 
                        <div class="w-full flex justify-center items-center pt-8">
                            <div class="text-gray-500">There are no audits planned for this month</div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
