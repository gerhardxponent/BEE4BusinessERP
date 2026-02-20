<?php

namespace Database\Seeders;

use App\Models\BoardItem;
use Illuminate\Database\Seeder;

class SetTaskStatusId extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = BoardItem::all();
        foreach ($items as $item) {
            switch ($item->status) {
                case 'active': 
                    $item->status_id = 1;
                    break;
                case 'inactive':
                    $item->status_id = 2;
                    break;
                case 'complete':
                    $item->status_id = 3;
                    break;
                default:
                    $item->status_id = 2;
            }

            $item->save();
        }
    }
}
