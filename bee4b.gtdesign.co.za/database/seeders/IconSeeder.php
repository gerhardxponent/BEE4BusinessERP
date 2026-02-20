<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Seeder;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $icons = [
            ['name' => 'finanace', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-businessplan" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><ellipse cx="16" cy="6" rx="5" ry="3"></ellipse><path d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path><path d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path><path d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path><path d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path><path d="M5 15v1m0 -8v1"></path></svg>'],
            ['name' => 'books', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-books" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><rect x="5" y="4" width="4" height="16" rx="1"></rect><rect x="9" y="4" width="4" height="16" rx="1"></rect><path d="M5 8h4"></path><path d="M9 16h4"></path><path d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z"></path><path d="M14 9l4 -1"></path><path d="M16 16l3.923 -.98"></path></svg>'],
            ['name' => 'computer', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-devices-2" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 15h-6a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h6"></path><rect x="13" y="4" width="8" height="16" rx="1"></rect><line x1="7" y1="19" x2="10" y2="19"></line><line x1="17" y1="8" x2="17" y2="8.01"></line><circle cx="17" cy="16" r="1"></circle><line x1="9" y1="15" x2="9" y2="19"></line></svg>'],
            ['name' => 'check', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-discount-check" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1"></path><path d="M9 12l2 2l4 -4"></path></svg>'],
            ['name' => 'office-building', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="3" y1="21" x2="21" y2="21"></line><line x1="9" y1="8" x2="10" y2="8"></line><line x1="9" y1="12" x2="10" y2="12"></line><line x1="9" y1="16" x2="10" y2="16"></line><line x1="14" y1="8" x2="15" y2="8"></line><line x1="14" y1="12" x2="15" y2="12"></line><line x1="14" y1="16" x2="15" y2="16"></line><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path></svg>'],
            ['name' => 'people', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="9" cy="7" r="4"></circle><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path></svg>'],
            ['name' => 'bar-graph', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-bar" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><rect x="3" y="12" width="6" height="8" rx="1"></rect><rect x="9" y="8" width="6" height="12" rx="1"></rect><rect x="15" y="4" width="6" height="16" rx="1"></rect><line x1="4" y1="20" x2="18" y2="20"></line></svg>'],
            ['name' => 'business', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report-money" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path><rect x="9" y="3" width="6" height="4" rx="2"></rect><path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path><path d="M12 17v1m0 -8v1"></path></svg>'],
        ];

        Icon::insert($icons);
    }
}
