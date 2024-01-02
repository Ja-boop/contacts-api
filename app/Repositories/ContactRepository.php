<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactRepository
{
    public function getBy($id)
    {
        $contact = Contact::where('id', $id)->first();

        if (!$contact) {
            throw new ModelNotFoundException('Contact not found');
        }

        return $contact;
    }

    public function getAllByUser(string $id)
    {
        return Contact::where('user_id', $id)->get();
    }

    public function create(Contact $contact)
    {
        return Contact::create($contact->toArray());
    }
}
