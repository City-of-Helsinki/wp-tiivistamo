<?php namespace Evermade\Respa;

// Schedule hourly event to update stores list.
if (!wp_next_scheduled('respa_cron_hook')) {
    wp_schedule_event(time(), 'hourly', 'respa_cron_hook');
}
add_action('respa_cron_hook', '\Evermade\Respa\updateSpaces');



/**
 * Update spaces.
 *
 * @return void
 */
function updateSpaces() {

    $respa = new \Evermade\Respa\Respa();
    $spaces = $respa->updateSpaces();

}
