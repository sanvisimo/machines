<?php

namespace Akka\Nova;

use Laravel\Nova\Panel;

class APanels extends Panel
{
    /**
     * Prepare the panel for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'component' => 'akka-panels',
        ]);
    }
}
