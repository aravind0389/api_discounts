<?php
declare(strict_types=1);

namespace App\Domain\Discounts;

use App\Domain\DomainException\DomainRecordNotFoundException;

class DiscountsNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The Discounts you requested does not exist.';
}
