<?php

namespace BlueRockTEL\SDK\Entities;

use Carbon\Carbon;
use BlueRockTEL\SDK\Entities\Entity;

class Note extends Entity
{
    public function __construct(
        readonly public ?int $id = null,
        readonly public ?int $user_id = null,
        readonly public ?string $noteable_type = null,
        readonly public ?int $noteable_id = null,
        readonly public ?int $parent_id = null,
        readonly public ?string $title = null,
        readonly public ?string $body = null,
        readonly public ?int $task_id = null,
        readonly public int $priority = 999,
        readonly public bool $shared = false,
        readonly public bool $byMail = false,
        readonly public bool $bySms = false,
        readonly public bool $mail = false,
        readonly public bool $sms = false,
        readonly public ?Carbon $created_at = null,
        readonly public ?Carbon $updated_at = null,
    ) {
        //
    }
}