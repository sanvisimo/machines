<?php

namespace Akka\Machines;

use Laravel\Nova\ResourceTool;

class Activities extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return __('Activities');
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'activities';
    }
}
