<?php

namespace Bookkeeper\Observers;

use Bookkeeper\Finance\Job;

class JobObserver
{

    /**
     * Handle the job "saved" event.
     *
     * @param  \Bookkeeper\Finance\Job  $job
     * @return void
     */
    public function saved(Job $job)
    {
        // We do this here to be able to store for both creation and updating
        if(!is_null($uploadedOffer = request()->file('offer')))
        {
            $info = [
                'name' => $uploadedOffer->getClientOriginalName(),
                'store_name' => 'offer-' . $job->getKey() . '.' . $uploadedOffer->extension()
            ];

            $uploadedOffer->storeAs('offers', $info['store_name']);

            // This is to prevent firing model events again
            Job::flushEventListeners();
            $job->update(['offer' => json_encode($info)]);
        }
    }

    /**
     * Handle the job "deleted" event.
     *
     * @param  \Bookkeeper\Finance\Job  $job
     * @return void
     */
    public function deleted(Job $job)
    {
        if($info = json_decode($job->offer)) {
            \Storage::delete('offers/' . $info->store_name);
        }
    }

}
