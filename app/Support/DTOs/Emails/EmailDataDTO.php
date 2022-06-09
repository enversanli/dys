<?php

namespace App\Support\DTOs\Emails;

use Spatie\DataTransferObject\DataTransferObject;

class EmailDataDTO extends DataTransferObject
{

    /** @var string */
    public $email;

    /** @var string */
    public $view;

    /** @var string */
    public $subject;

    /** @var array */
    public  $data = null;
}
