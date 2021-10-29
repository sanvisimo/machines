<?php

namespace Akka\ButtonGroup;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Select;

class ButtonGroup extends Select
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'button-group';
}
