<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Http\Response;
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

    public function show(int $id): Response
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

    public function upsert(Contact $contact): Response
    {
        return $contact->id
            ? $this->update($contact)
            : $this->store($contact);
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteContactRequest($id)
        );
    }

    /**
     * @deprecated Use upsert instead.
     */
    public function save(Contact $contact): Response
    {
        return $this->upsert($contact);
    }
}