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
        public readonly ?int $id = null,
        public readonly ?int $user_id = null,
        public readonly ?int $customer_id = null,
        public readonly ?int $contact_id = null,
        public readonly ?int $ticket_id = null,
        public readonly ?string $direction = null,
        public readonly ?string $status = null,
        public readonly bool $answered = true,
        public readonly ?string $subject = null,
        public readonly ?string $body = null,
        public readonly ?string $number_from = null,
        public readonly ?string $number_to = null,
        public readonly ?string $recording_file = null,
        public readonly ?Carbon $started_at = null,
        public readonly ?Carbon $ended_at = null,
        public readonly ?string $transcription = null,
        public readonly ?string $transcription_diarized = null,
        public readonly ?string $summary = null,
        public readonly ?string $summary_detailed = null,
        public readonly ?array $sentiments = null,
        public readonly ?array $topics = null,
        public readonly ?array $segments = null,
        public readonly ?Carbon $created_at = null,
        public readonly ?Carbon $updated_at = null,
    ) {
        //
    }
}
