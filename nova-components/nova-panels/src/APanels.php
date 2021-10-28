<?php

namespace Akka\Nova;

use Illuminate\Http\Resources\MergeValue;
use Illuminate\Http\Resources\MissingValue;
use Laravel\Nova\Contracts\ListableField;
use Laravel\Nova\Panel;

class APanels extends Panel
{
    /**
     * Prepare the given fields.
     *
     * @param  \Closure|array $fields
     * @return array
     */
    protected function prepareFields($tabs)
    {
        foreach ($tabs as $tab=>$fields) {
            collect(is_callable($fields) ? $fields() : $fields)->each(function ($fields, $key) use ($tab) {
                if (is_string($key) && is_array($fields)) {
                    $fields = new Panel($key, $fields);
                }
                $this->addPanels($fields, $tab);
            });
        }
            return $this->data;
    }

    /**
     * @param  Panel|\Laravel\Nova\Contracts\ListableField $panel
     * @return \Akka\Nova\APanels
     */
    public function addPanels($panel, $tab): self
    {
        if ($panel instanceof ListableField) {
            $panel->panel = $this->name;

            $panel->withMeta([
                'pan' => $panel->name,
                'panComponent' => $panel->component(),
                'tab' => $tab,
                'listable' => false,
                'listableTab' => true
            ]);
            $this->data[] = $panel;
        } elseif ($panel instanceof Panel) {
            $panel->withMeta([
                'panComponent' => $panel->component()
            ]);
            $this->data[] = $panel;
            $this->addFields($panel->name, $panel->data, $panel->component(), $tab);
        } else {
            throw new RuntimeException('Only listable fields or Panel allowed.');
        }

        return $this;
    }

    /**
     * Add fields to the Tab.
     *
     * @param  string $pan
     * @param  array $fields
     * @param  string $component
     * @param  number $tab
     * @return \Akka\Nova\APanels
     */
    public function addFields($pan, array $fields, $component, $tab)
    {
        foreach ($fields as $field) {
            if($field instanceof MissingValue) {
                continue;
            }
            if ($field instanceof ListableField || $field instanceof Panel) {
                $this->addPanels($field);
                continue;
            }

            if ($field instanceof MergeValue) {
                $this->addFields($pan, $field->data);
                continue;
            }

            $field->panel = $this->name;

            $field->withMeta([
                'pan' => $pan,
                'tab' => $tab,
                'panComponent' => $component,
            ]);
        }

        return $this;
    }

    /**
     * Prepare the panel for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'component' => 'akka-panels',
//            'boh' => $fields,
            'showToolbar' => $this->showToolbar,
        ]);
    }
}
