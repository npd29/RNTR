<?php
//TODO:CITE
//https://github.com/smartystreets/smartystreets-php-sdk/blob/master/examples/UsStreetSingleAddressExample.php

require_once(dirname(__FILE__) . '/SmartyStreets/src/ClientBuilder.php');
require_once(dirname(__FILE__) . '/SmartyStreets/src/US_Street/Lookup.php');
require_once(dirname(__FILE__) . '/SmartyStreets/src/StaticCredentials.php');

use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;

$authId = 'b7c14f59-dc48-c4ef-e91d-614ad97ce03f';
$authToken = 'bc0mrEoTXoRNBm5bLclz';

// We recommend storing your secret keys in environment variables instead---it's safer!
//        $authId = getenv('SMARTY_AUTH_ID');
//        $authToken = getenv('SMARTY_AUTH_TOKEN');
$staticCredentials = new StaticCredentials($authId, $authToken);
$client = (new ClientBuilder($staticCredentials))
//                        ->viaProxy("http://localhost:8080", "username", "password") // uncomment this line to point to the specified proxy.
    ->buildUsStreetApiClient();

// Documentation for input fields can be found at:
// https://smartystreets.com/docs/cloud/us-street-api
$lookup = new Lookup();
$lookup->setStreet($address1);
$lookup->setSecondary($address2);
$lookup->setCity($city);
$lookup->setState($state);
$lookup->setZipcode($zip);
$lookup->setMatchStrategy("invalid"); // "invalid" is the most permissive match,
// this will always return at least one result even if the address is invalid.
// Refer to the documentation for additional MatchStrategy options.

try {
    $client->sendLookup($lookup);
    $results = $lookup->getResult();
    $firstCandidate = $results[0];

    $num=$firstCandidate->getComponents()->getPrimaryNumber();
    $street=$firstCandidate->getComponents()->getStreetName();
    $suffix=$firstCandidate->getComponents()->getStreetSuffix();
    $address1=$num.$street.$suffix;
    $designator=$firstCandidate->getComponents()->getSecondaryDesignator();
    $secNum=$firstCandidate->getComponents()->getSecondaryNumber();
    $extra=$firstCandidate->getComponents()->getExtraSecondaryDesignator();
    $extraNum=$firstCandidate->getComponents()->getExtraSecondaryNumber();
    $address2=$designator.$secNum.$extra.$extraNum;
    $city=$firstCandidate->getComponents()->getCityName();
    $state=$firstCandidate->getComponents()->getStateAbbreviation();
    $zip=$firstCandidate->getComponents()->getZipcode();

}
catch (SmartyException $ex) {
    print '<p>'.($ex->getMessage()).'</p>';
}
catch (Exception $ex) {
    print '<p>'.($ex->getMessage()) . '</p>';
}