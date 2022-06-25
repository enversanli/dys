<?php

namespace App\Support\DTOs\Dues;

use Spatie\DataTransferObject\DataTransferObject;

class DuesDTO extends DataTransferObject
{
    /** @var integer */
    public $id = 0;

    /** @var integer */
    public $year = 0;

    /** @var integer */
    public $month = 0;

    /** @var string */
    public $month_translated;

    /** @var integer */
    public $fee = 0;

    /** @var string */
    public $status;


    public $approved_at;

    public $paid_at;




}
