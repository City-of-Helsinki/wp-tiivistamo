<?php namespace Evermade\Respa;



/**
 * Class for querying hyperin api.
 */
class Respa {


    const TRANSIENT_NAME = 'respa-spaces';


    /**
     * Update stores and save to transiend.
     *
     */
    public function updateSpaces() {

        // Use actual Oodi unit ID for this
        $spaces = $this->query('resource', ['unit' => 'tprek:51342', 'page_size' => 100]);

        // print_r($spaces);
        // die();

        if ($spaces) {
            $spaces = $spaces->results;
        }

        // Extend with single store information.
        array_walk($spaces, function(&$space) {
            $space = $this->getSpace($space->id);
        });

        // Save to cache for an hour.
        update_option($this::TRANSIENT_NAME, json_encode($spaces));

    }



    /**
     * Return list of stores.
     *
     * NOTE: Parameters are deprecated. The list is always returned from cache
     * and it always has the full info.
     *
     * @param Boolean $fullInfo DEPRECATED If set to true, full store details are provided. This perform multiple API requests so and the response will be cached.
     * @param Boolean @enableCache DEPRECATED Disable/enable caching.
     */
    public function getSpaces($fullInfo = false, $enableCache = true) {

        // Get from cache.
        $cachedSpaces = get_option($this::TRANSIENT_NAME);

        // Cached exists => return.
        if ($cachedSpaces != false) {
            return json_decode($cachedSpaces);
        } else {
            return [];
        }

    }



    /**
     * Return single store
     *
     * @param String $spaceId Space's id.
     * @return Array Space details.
     */
    public function getSpace($spaceId) {

        $space = $this->query('resource/'.$spaceId);

        // print_r($space);
        // die();

        if (!$space) {
            return false;
        }

        // Map images.
        // $space = $space->store;
        // $space->storeOwnerURL = false;
        // $space->storeSignatureURL = false;
        // if (isset($space->tenantImages)) {

        //     $spaceOwner = array_filter($space->tenantImages, function($image) {
        //         return count($image->tags) && $image->tags[0] == 'store-owner';
        //     });
        //     $space->storeOwnerURL = $spaceOwner ? array_pop($spaceOwner)->url : false;

        //     $spaceSignature = array_filter($space->tenantImages, function($image) {
        //         return count($image->tags) && $image->tags[0] == 'store-signature';
        //     });
        //     $space->storeSignatureURL = $spaceSignature ? array_pop($spaceSignature)->url : false;

        // }

        // $space->offers = $this->getOffers($space->id);

        return $space;

    }



    /**
     * Perform API query.
     *
     * @param String $endPoint Endpoint command like 'stores' or 'offers'.
     * @param Array $args Associative array of optional parameters.
     * @return StdClass representation of the returned json. False on error.
     */
    private function query($endPoint, $args = []) {

        $urlParams = '';
        array_walk($args, function($value, $key) use (&$urlParams) {
            $urlParams .= $key . '=' . $value . '&';
        });

        $url = 'https://api.hel.fi/respa/v1/'.$endPoint.'?'.$urlParams.'&format=json';
        $data = file_get_contents($url);

        if ($data) {
            return json_decode($data);
        } else {
            return false;
        }

    }



}
