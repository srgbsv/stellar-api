<?php

/**
 * Adds a new signer to an existing account
 */


require '../vendor/autoload.php';

use \ZuluCrypto\StellarSdk\Keypair;
use \ZuluCrypto\StellarSdk\Server;
use \ZuluCrypto\StellarSdk\Model\Asset;
use \phpseclib\Math\BigInteger;


$server = Server::publicNet();

// Check if an account exists

$nativeAsset = new Asset();
$centusAsset = new Asset('CENTUS', 'GAKMVPHBET4T7DPN32ODVSI4AA3YEZX2GHGNNSBGFNRQ6QEVKFO4MNDZ');

try {
    $trades = $server->getTradesAggregation()->assets($nativeAsset, $centusAsset)->resolution(60000)->call();

    print_r($trades);
}
// If there's an exception it could be a temporary error, like a connection issue
// to Horizon, so we cannot tell for sure if the account exists or not
catch (\Exception $e) {
    print "Error: " . $e->getMessage() . PHP_EOL;
}
