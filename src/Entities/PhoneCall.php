<?php

namespace BlueRockTEL\SDK\Entities;

use Carbon\Carbon;
use BlueRockTEL\SDK\Entities\Entity;

class PhoneCall extends Entity
{
    protected static $arrayCast = [
        'answered' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function __construct(
        readonly public ?int $id = null,
        readonly public ?int $user_id = null,
        readonly public ?int $contact_id = null,
        readonly public ?int $ticket_id = null,
        readonly public ?string $direction = null,
        readonly public ?string $status = null,
        readonly public bool $answered = true,
        readonly public ?string $subject = null,
        readonly public ?string $body = null,
        readonly public ?string $number_from = null,
        readonly public ?string $number_to = null,
        readonly public ?string $recording_file = null,
        readonly public ?Carbon $started_at = null,
        readonly public ?Carbon $ended_at = null,
        readonly public ?string $transcription = null,
        readonly public ?string $transcription_diarized = null,
        readonly public ?string $summary = null,
        readonly public ?string $summary_detailed = null,
        readonly public ?array $sentiments = null,
        readonly public ?array $topics = null,
        readonly public ?array $segments = null,
        readonly public ?Carbon $created_at = null,
        readonly public ?Carbon $updated_at = null,
    ) {
        //
    }
}