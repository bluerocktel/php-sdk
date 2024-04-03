<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\Note;
use BlueRockTEL\SDK\Endpoints\Notes as Endpoints;

class NoteResource extends Resource
{
    public function index(
        string $noteable_type,
        int $noteable_id,
        array $query = [],
    ): Response {
        return $this->connector->send(
            new Endpoints\GetNotesRequest(
                noteableType: $noteable_type,
                noteableId: $noteable_id,
                params: $query,
            )
        );
    }

    public function show(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\GetNoteRequest($id)
        );
    }

    public function store(Note $note): Response
    {
        return $this->connector->send(
            new Endpoints\CreateNoteRequest($note)
        );
    }

    public function update(Note $note): Response
    {
        return $this->connector->send(
            new Endpoints\UpdateNoteRequest($note)
        );
    }

    public function upsert(Note $note): Response
    {
        return $note->id
            ? $this->update($note)
            : $this->store($note);
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteNoteRequest($id)
        );
    }

    /**
     * @deprecated Use upsert instead.
     */
    public function save(Note $note): Response
    {
        return $this->upsert($note);
    }
}