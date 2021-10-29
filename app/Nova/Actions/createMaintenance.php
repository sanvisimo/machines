<?php

namespace App\Nova\Actions;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class createMaintenance extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return __('Take charge');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $resource = str_contains($model->activitable_type, 'Maintenance') ? 'maintenances' : 'control-plans';
            if($resource === "maintenances"){
                $maintenance = \App\Models\Maintenance::find($model->activitable_id);
                $maintenance->opening_date = Carbon::now();
                $maintenance->save();
                return Action::push("/resources/{$resource}/{$model->activitable_id}/edit");
            } else {
                return Action::push("/resources/machines/{$model->machine_id}?measurement=true");
            }

        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
