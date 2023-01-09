<?php
/*
  Template Name: Single event
*/

use Spatie\CalendarLinks\Link;
global $sitepress;
$lang = (isset($_GET['lang']) && in_array($_GET['lang'], array('fi', 'en', 'sv'))) ? $_GET['lang'] : 'fi';
if ($sitepress->get_current_language() != $lang) {
    $sitepress->switch_lang($lang, true);
}

// Get store details from LinkedEvents
$linkedEvents = new \Evermade\LinkedEvents\LinkedEvents();
$event = $linkedEvents->getStore(get_query_var('store_id'));

$external_links = $event->external_links != null ? $event->external_links : '';
$event_status = $event->event_status != "EventCancelled" ? '' : __("Event Cancelled" , 'swiss');

if ( $sitepress->get_current_language() ) {
    switch ($sitepress->get_current_language()) {
    case 'fi':
        $name = $event->name->fi;
        $desc = $event->description->fi;
        $short_desc = $event->short_description->fi;
        $info_url = $event->info_url != null ? $event->info_url->fi : '';
        $location_name = $event->location->name->fi;
        $location_address = $event->location->street_address->fi;
        $location_extra = $event->location_extra_info != null ? $event->location_extra_info->fi : '';
        break;
    case 'en':
        $name = $event->name->en;
        $desc = $event->description->en;
        $short_desc = $event->short_description->en;
        $info_url = $event->info_url != null ? $event->info_url->en : '';
        $location_name = $event->location->name->en;
        $location_address = $event->location->street_address->en;
        $location_extra = $event->location_extra_info != null ? $event->location_extra_info->en : '';
        break;
    case 'sv':
        $name = $event->name->sv;
        $desc = $event->description->sv;
        $short_desc = $event->short_description->sv;
        $info_url = $event->info_url != null ? $event->info_url->sv : '';
        $location_name = $event->location->name->sv;
        $location_address = $event->location->street_address->sv;
        $location_extra = $event->location_extra_info != null ? $event->location_extra_info->sv : '';
        break;
    default:
        $name = $event->name->fi;
        $desc = $event->description->fi;
        $short_desc = $event->short_description->fi;
        $info_url = $event->info_url != null ? $event->info_url->fi : '';
        $location_name = $event->location->name->fi;
        $location_address = $event->location->street_address->fi;
        $location_extra = $event->location_extra_info != null ? $event->location_extra_info->fi : '';
        break;
    }
}

// Set default timezone to Finnish timezone
date_default_timezone_set('Europe/Helsinki');
$tz = new DateTimeZone( 'Europe/Helsinki' );

$event_datetime = new DateTime($event->start_time);
$event_datetime = $event_datetime->setTimezone($tz);

$price = "";
if( isset( $event->offers ) ){
    if( isset( $event->offers[0] ) ){
        if( isset( $event->offers[0]->price ) ){
            if( isset( $event->offers[0]->price->fi ) ){
                $price = (string)($event->offers[0]->price->fi);
            }
        }

        if( isset( $event->offers[0]->info_url ) ){
            if( isset( $event->offers[0]->info_url->fi ) ){
                $ticket_link = (string)($event->offers[0]->info_url->fi);
            }
        }
    }
}

// Use CalendarLinks package to generate calendar links (duh)
$calendar_title = $name;
$calendar_description = $short_desc;
// TODO: Make an extra request for each event to get the address
$calendar_address = $location_address;
$calendar_from = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $event->start_time);
$calendar_to = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $event->end_time);

// If we can't actually format the dates...? TODO: Investigate why not?
// Are the source strings in different formats?
if ($calendar_from !== false && $calendar_to !== false) {
    $calendar_link = Link::create($calendar_title, $calendar_from, $calendar_to)
                   ->description($calendar_description)
                   ->address($calendar_address);

    // Generate a link to create an event on Google calendar
    $calendar_google = $calendar_link->google();

    // Generate a link to create an event on Yahoo calendar
    // echo $link->yahoo();

    // Generate a data uri for an ics file (for iCal & Outlook)
    $calendar_ics = $calendar_link->ics();
}


// Set globals to be used in our Yoast hooks
if ($event) {
    $GLOBALS['api_item_title'] = $name;
    $GLOBALS['api_item_description'] = $desc;
    $GLOBALS['api_item_image'] = $event->images[0]->url;
    if (isset($event->permalink)) $GLOBALS['api_item_url'] = $event->permalink;
}

/**
 * Output
 */
get_header();

if ($event) {
    include(get_template_directory().'/templates/api/event.php');
} else {
    include(get_template_directory().'/404.php');
}

get_footer();
