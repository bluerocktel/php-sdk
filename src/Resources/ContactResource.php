<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Contracts\Response;
use BlueRockTEL\SDK\Entities\Contact;
use BlueRockTEL\SDK\Endpoints\Contacts as Endpoints;

class ContactResource extends Resource
{
    public function index(
        string $contactable_type,
        int $contactable_id,
        array $query = [],
    ): Response {
        return $this->connector->send(
            new Endpoints\GetContactsRequest(
                contactableType: $contactable_type,
                contactableId: $contactable_id,
                params: $query,
            )
        );
    }

    public function show($id): Response
    {
        return $this->connector->send(
            new Endpoints\GetContactRequest($id)
        );
    }

    public function store(Contact $contact): Response
    {
        return $this->connector->send(
            new Endpoints\CreateContactRequest($contact)
        );
    }

    public function update(Contact $contact): Response
    {
        return $this->connector->send(
            new Endpoints\UpdateContactRequest($contact)
        );
    }

    public function save(Contact $contact): Response
    {
        return $contact->id
            ? $this->update($contact)
            : $this->store($contact);
    }

    public function delete(Contact $contact): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteContactRequest($contact)
        );
    }
}