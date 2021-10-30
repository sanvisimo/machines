<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\ControlPlan;
use App\Models\Maintenance;

class ActivityObserver
{
    /**
     * Handle the Activity "created" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function created(Activity $activity)
    {
        switch($activity->type) {
            case "maintenance":
            case "maintenance_no":

                $maintenance = $activity->element_type::where('id', $activity->activitable_id)->first();
                if(!$maintenance) {
                    $model = new Maintenance;
                    $model->machine_id = $activity->machine_id;
                    $model->component_id = $activity->element_type === 'App\Models\Component' ? $activity->element_id : null;
                    $model->managed_article_id = $activity->element_type === 'App\Models\ManagedArticle' ? $activity->element_id : null;
                    $model->type = $activity->type;
                    $model->periodicity = $activity->periodicity;
                    $model->save();

                    $activity->activitable_id = $model->id;
                    $activity->activitable_type = 'App\Models\Maintenance';
                    $activity->save();
                }
                break;
        }



    }

    /**
     * Handle the Activity "updated" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function updated(Activity $activity)
    {
        //
    }

    /**
     * Handle the Activity "deleted" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function deleted(Activity $activity)
    {
        //
    }

    /**
     * Handle the Activity "restored" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function restored(Activity $activity)
    {
        //
    }

    /**
     * Handle the Activity "force deleted" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function forceDeleted(Activity $activity)
    {
        //
    }
}
