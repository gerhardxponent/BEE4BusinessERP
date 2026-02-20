<?php

namespace App\Http\Livewire\Contacts;

use App\Jobs\CommentMentionEmail;
use App\Jobs\TestJob;
use App\TokenStore\TokenCache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Microsoft\Graph\Graph;

class ContactIndex extends Component
{
    public $open = false;
    public $showArchives = false;

    protected $listeners = [
        'createContact'
    ];

    public function mount()
    {
        // $response = Http::get('https://edgetrainingconsultancy.co.za/erp/webservice.php?operation=getchallenge&username=admin');
        // $response = json_decode($response->body());

        // $accessKey = md5($response->result->token . 'u6pivui7tqpzhg78', true);

        // $newLink = 'https://edgetrainingconsultancy.co.za/erp/webservice.php?operation=login&username=admin&accessKey=' . $accessKey;
        // // dd($newLink);
        // $newRes = Http::asForm()->post($newLink);       

        // dd($newRes->body());
    }

    public function render()
    {
        return view('livewire.contacts.contact-index')
            ->layoutData([
                'title' => 'Contacts',
                'buttonPermission' => 'create contacts',
                'buttonAction' => 'toggleCreateContactModal',
                'buttonText' => 'Create Contact'
            ]);
    }

    public function createContact() { return redirect()->to('/contacts/create'); }

    // public function sendEmail()
    // {
    //     dispatch(new CommentMentionEmail('keshav.badul06@gmail.com', Auth::user()->name, 'this is a test'));
    // }
}
