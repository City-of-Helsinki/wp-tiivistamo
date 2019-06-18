<?php namespace Evermade\Respa\Api;
/**
 * Hooks for the rest API.
 */



/**
 * Get all stores. Not pagination or any other fancy stuff since there are not that many items.
 *
 * @return void
 */
function updateSpaces() {

    // Get stores.
    $respa = new \Evermade\Respa\Respa();
    $spaces = $respa->updateSpaces();

    return ['success' => true];

}


/**
 * Get all stores. Not pagination or any other fancy stuff since there are not that many items.
 *
 * @return void
 */
function getSpaces() {

    // Get stores.
    $hyperIn = new \Evermade\Respa\Respa();
    $spaces = $hyperIn->getSpaces(true);

    // print_r($spaces);exit;

    if (!$spaces) {
        return [];
    }

    // Do some magic to transform API respose to be like WordPress post object.
    $spacesWp = [];
    array_walk($spaces, function($space) use (&$spacesWp) {

        array_push($spacesWp, [
            'ID' => $space->id,
            'post_title' => $space->name,
            'post_content' => $space->description,
            // 'permalink' => get_bloginfo('url') . '/event/' . $space->id . '/' . sanitize_title($space->name),
            'meta' => array(
                'opening_hours' => $space->opening_hours,
                'description' => $space->description,
                'type' => $space->type,
                'purposes' => $space->purposes,
                'id' => $space->id,
                'people_capacity' => $space->people_capacity
            )
        ]);
    });

    return $spacesWp;

}



add_action('rest_api_init', function () {

    register_rest_route( 'respa/v1', '/updatespaces', array(
        'methods' => 'GET',
        'callback' => '\Evermade\Respa\Api\updateSpaces',
    ));

    register_rest_route( 'respa/v1', '/spaces', array(
        'methods' => 'GET',
        'callback' => '\Evermade\Respa\Api\getSpaces',
    ));

});
