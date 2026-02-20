<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = Contact::all();

        foreach ($contacts as $contact) {
            $contact->name = $contact->firstname . ' ' . $contact->lastname;
            $contact->save();
        }
    }
}
