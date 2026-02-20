<?php

namespace App\Http\Livewire\Clients\Components;

use App\Models\Activity as ModelsActivity;
use App\Models\Clients;
use Carbon\Carbon;
use Livewire\Component;

class Activity extends Component
{
    protected $listeners = ['refreshActivity' => '$refresh'];
    public $client;

    public function mount($clientID)
    {
        $this->client = Clients::find($clientID);
    }

    public function render()
    {
        return view('livewire.clients.components.activity');
    }

    public function activityTime($time)
    {
        $humanDate = $time->day . ' ' . $time->englishMonth . ' ' . $time->year;
        $humanTime = ($time->hour < 10 ? '0' . $time->hour : $time->hour) . ':' . (($time->minute < 10) ? ('0' . $time->minute) : ($time->minute));

        if(Carbon::now()->diffInDays($time) == 0) {
            if(Carbon::now()->diffInHours($time) == 0) {
                if(Carbon::now()->diffInMinutes($time) == 0) {
                    return Carbon::now()->diffInSeconds($time) . ' seconds ago';
                }else {
                    return Carbon::now()->diffInMinutes($time) . ' minutes ago';
                }
            }else {
                return Carbon::now()->diffInHours($time) . ' hours ago';
            }
        }else {
            if(Carbon::now()->diffInDays($time) >= 5) {
                return $humanDate . ', ' . $humanTime;
            }else {
                return Carbon::now()->diffInDays($time) . ' days ago';
            }
        }

        return 'right now';
    }

    protected function generateInitials($name)
    {
        $words = explode(" ", $name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }
}
