<?php

namespace BlueRockTEL\SDK\Entities;

use Carbon\Carbon;
use BlueRockTEL\SDK\Entities\Entity;

class Contact extends Entity
{
    public function __construct(
        readonly public ?int $id = null,
        readonly public ?int $user_id = null,
        readonly public ?string $contactable_type = null,
        readonly public ?int $contactable_id = null,
        readonly public ?int $civility = null,
        readonly public ?string $firstName = null,
        readonly public ?string $lastName = null,
        readonly public ?string $emailAddress = null,
        readonly public ?string $mobilePhone = null,
        readonly public ?string $landlinePhone = null,
        readonly public ?string $role = null,
        readonly public ?int $profunction_id = null,
        readonly public ?int $service = null,
        readonly public bool $active = true,
        readonly public bool $legalRepresentative = false,
        readonly public bool $invoicesRecipient = false,
        readonly public bool $newslettersRecipient = false,
        readonly public bool $technicalContact = false,
        readonly public bool $is_signer_contract = false,
        readonly public bool $is_signer_iban = false,
        readonly public bool $myClient = false,
        readonly public bool $myClientAdmin = false,
        readonly public bool $ticketingDoNotNotify = false,
        readonly public bool $ticketingCopyToSales = false,
        readonly public bool $api = false,
        readonly public ?string $cfd_token = null,
        readonly public ?string $cfd_authorised_hosts = null,
        readonly public ?string $familiarity = null,
        readonly public string $source = 'admin',
        readonly public ?string $comment = null,
        readonly public ?Carbon $created_at = null,
        readonly public ?Carbon $updated_at = null,
    ) {
        //
    }
}