<?php

namespace App\Services;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\ConsoleOutput;

class ContactService
{
    public function __construct(private ContactRepository $contactRepository)
    {
    }

    public function create(CreateContactRequest $request)
    {
        $image_path = $request->file('image')->store('images', 'public');

        $contact = new Contact([
            ...$request->validated(),
            'user_id' => Auth::id(),
            'image_path' => $image_path,
        ]);

        return $this->contactRepository->create($contact);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $contact = $this->contactRepository->getBy($id);

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
        return $this->contactRepository->getBy($id);
    }

    public function getAllByUser()
    {
        return $this->contactRepository->getAllByUser(Auth::id());
    }
}
