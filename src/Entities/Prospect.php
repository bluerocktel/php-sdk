<?php

namespace BlueRockTEL\SDK\Entities;

use Carbon\Carbon;
use BlueRockTEL\SDK\Entities\Entity;

class Prospect extends Entity
{
    public function __construct(
        readonly public ?int $id = null,
        readonly public int $brand_id = 1,
        readonly public ?int $representative_id = null,
        readonly public ?string $customerAccount = null,
        readonly public ?string $accountsReference = null,
        readonly public ?string $name = null,
        readonly public ?string $brand = null,
        readonly public ?string $cluster = null,
        readonly public ?string $registrationNumber = null,
        readonly public ?string $taxRegistrationNumber = null,
        readonly public ?string $mainContactFirstName = null,
        readonly public ?string $mainContactLastName = null,
        readonly public ?string $type = null,
        readonly public ?string $capital = null,
        readonly public ?string $activityCode = null,
        readonly public ?int $sector_id = null,
        readonly public ?int $origin_id = null,
        readonly public ?string $mainAddressLine1 = null,
        readonly public ?string $mainAddressLine2 = null,
        readonly public ?string $mainAddressPostalCode = null,
        readonly public ?string $mainAddressCity = null,
        readonly public ?string $mainAddressCountry = null,
        readonly public bool $abroad = false,
        readonly public int $zone = 0,
        readonly public ?string $emailAddress = null,
        readonly public ?string $accountEmailAddress = null,
        readonly public ?string $website = null,
        readonly public ?string $phone = null,
        readonly public ?string $mobilePhone = null,
        readonly public ?string $fax = null,
        readonly public ?string $logo = null,
        readonly public bool $active = true,
        readonly public ?string $activity = null,
        readonly public ?string $category = null,
        readonly public ?string $qualification = null,
        readonly public int $prospection_code_id = 1,
        readonly public bool $acceptEmails = true,
        readonly public bool $acceptCalls = true,
        readonly public bool $chargeVAT = true,
        readonly public ?string $language = null,
        readonly public bool $mergeInvoices = false,
        readonly public ?string $numberForEligibility = null,
        readonly public ?string $comment = null,
        readonly public bool $quickSearchIndex = false,
        readonly public ?Carbon $created_at = null,
        readonly public ?Carbon $updated_at = null,
    ) {
        //
    }
}