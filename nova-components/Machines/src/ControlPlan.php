<?php

namespace Akka\Machines;

use Laravel\Nova\ResourceTool;

class ControlPlan extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return __('Control Plan');
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'control-plan';
    }
}
