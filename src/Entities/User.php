<?php

namespace BlueRockTEL\SDK\Entities;

use Carbon\Carbon;
use BlueRockTEL\SDK\Entities\Entity;

class User extends Entity
{
    public function __construct(
        readonly public ?int $id = null,
        readonly public ?bool $active = null,
        readonly public ?string $name = null,
        readonly public ?string $email = null,
        readonly public ?string $emailShown = null,
        readonly public ?string $avatar = null,
        readonly public ?int $role = null,
        readonly public ?string $location = null,
        readonly public ?string $phone = null,
        readonly public ?string $phoneDirect = null,
        readonly public ?string $mobilePhone = null,
        readonly public bool $manager = false,
        readonly public bool $technicalManager = false,
        readonly public bool $sales = false,
        readonly public bool $technical = false,
        readonly public bool $supportTeam = false,
        readonly public bool $salesAdmin = false,
        readonly public bool $admin = false,
        readonly public bool $businessFinder = false,
        readonly public ?Carbon $created_at = null,
        readonly public ?Carbon $updated_at = null,
    ) {
        //
    }
}