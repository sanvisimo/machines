<?php

namespace Beyondcode\NuovaCard;

use Laravel\Nova\Card;

class NuovaCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    public function blink($blink = true)
    {
        return $this->withMeta([
            'blink' => $blink
        ]);
    }

    public function withSeconds($blink = true)
    {
        return $this->withMeta([
            'withSeconds' => $blink
        ]);
    }

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'nuova-card';
    }
}
