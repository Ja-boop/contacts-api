<?php

namespace App\Services;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactService
{
    public function create(CreateContactRequest $request)
    {
        $image_path = $request->file('image')->store('images', 'public');

        $contact = new Contact([
            ...$request->validated(),
            'user_id' => Auth::id(),
            'image_path' => $image_path,
        ]);

        return Contact::create($contact->toArray());
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::delete($contact->image_path);
            $image_path = $request->file('image')->store('images', 'public');
            $contact->update([
                'image_path' => $image_path
            ]);
        }

        return $contact->update($request->validated());
    }

    public function getBy($id)
    {
        return Contact::findOrFail($id);
    }

    public function getAllByUser()
    {
        return User::find(Auth::id())->contacts;
    }
}
