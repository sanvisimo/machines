<?php

namespace Akka\ControlPlanField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\HasOne;

class ControlPlanField extends HasOne
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'control-plan-field';
}
