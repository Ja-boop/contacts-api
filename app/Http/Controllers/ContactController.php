<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Services\ContactService;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService)
    {
    }

    public function create(CreateContactRequest $request)
    {
        return $this->contactService->create($request);
    }

    public function getAll()
    {
        return $this->contactService->getAllByUser();
    }

    public function getById($id)
    {
        return $this->contactService->getBy($id);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        return $this->contactService->update($request, $id);
    }
}
