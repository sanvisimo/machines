<?php

namespace Akka\AkkaDate;

use Laravel\Nova\Fields\Date;

class AkkaDate extends Date
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'akka-date';
}
