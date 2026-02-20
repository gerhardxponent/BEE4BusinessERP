<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;

class MakeClientBoardsPoly extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boards = Board::all();

        foreach ($boards as $board) {
            if ($board->client_id != null) {
                $board->boardable_id = $board->client_id;
                $board->boardable_type = 'App\Models\Clients';

                $board->save();
            }
        }
    }
}
