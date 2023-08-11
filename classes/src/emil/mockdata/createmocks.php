<?php

// NOK
$meta = array();
$data = array();

$meta[ 'transmitted' ] = 'now() ;)';
$meta[ 'reason' ]      = 'keine lust';
$meta[ 'status' ]      = 'NOK';

$data[ 'recommend' ] = array();

$out = json_encode( array( 
    'meta' => $meta
    , 'data' => $data
), JSON_PRETTY_PRINT );
file_put_contents( __DIR__ . "/nok.json", $out );

// OK
$meta = array();
$data = array();

$meta[ 'transmitted' ] = 'now() ;)';
$meta[ 'status' ]      = 'OK';

$data[ 'recommend' ] = array( 123 => "MLE1", 345 => "MLE2", 567 => "MLE3" );

$out = json_encode( array( 
    'meta' => $meta
    , 'data' => $data
), JSON_PRETTY_PRINT );
file_put_contents( __DIR__ . "/ok.json", $out );