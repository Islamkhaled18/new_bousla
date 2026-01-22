<?php

namespace App\Observers;

use App\Helpers\IconMapper;
use App\Models\JobTitle;

class JobTitleObserver
{
    /**
     * Handle the JobTitle "creating" event.
     */
    public function creating(JobTitle $jobTitle): void
    {
        // Auto-map icon to Flutter format
        if ($jobTitle->icon && empty($jobTitle->icon_unicode)) {
            $flutterIcon = IconMapper::toFlutter($jobTitle->icon);
            $jobTitle->icon_unicode = $flutterIcon['unicode'];
            $jobTitle->icon_family = $flutterIcon['family'];
        }
    }

    /**
     * Handle the JobTitle "updating" event.
     */
    public function updating(JobTitle $jobTitle): void
    {
        // Update Flutter icon if Font Awesome icon changed
        if ($jobTitle->isDirty('icon')) {
            $flutterIcon = IconMapper::toFlutter($jobTitle->icon);
            $jobTitle->icon_unicode = $flutterIcon['unicode'];
            $jobTitle->icon_family = $flutterIcon['family'];
        }
    }
}