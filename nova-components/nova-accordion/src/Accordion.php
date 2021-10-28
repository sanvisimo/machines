<?php

namespace Akka\Accordion;

use Laravel\Nova\Panel;

class Accordion extends Panel
{
    /**
     * Prepare the panel for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'component' => 'akka-accordion',
        ]);
    }
}
