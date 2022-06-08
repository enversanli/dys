<?php

namespace App\Support\DTOs\Emails;

use Spatie\DataTransferObject\DataTransferObject;

class StoredUserDTO extends DataTransferObject
{
    /** @var string */
    public $view;

    /** @var string */
    public $subject;

    /** @var array */
    public  $data = null;
}
