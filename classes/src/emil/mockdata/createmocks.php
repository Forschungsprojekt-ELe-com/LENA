<?php

// NOK
$meta = array();
$data = array();

$meta[ 'transmitted' ] = 'now() ;)';
$meta[ 'reason' ]      = 'keine lust';
$meta[ 'status' ]      = 'NOK';

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

$data[ 'recommend' ] = array( 123, 345, 567 );

$out = json_encode( array( 
    'meta' => $meta
    , 'data' => $data
), JSON_PRETTY_PRINT );
file_put_contents( __DIR__ . "/ok.json", $out );