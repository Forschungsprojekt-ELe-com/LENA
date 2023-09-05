<?php
require_once __DIR__ . '/src/_all.php';
if( ! isset( $_REQUEST[ 'token' ] ) ) {
    EmilLogger::log( 'api, no token' );
    die();
}

$token = $_REQUEST[ 'token' ];
$access = new AccessToken();

if( ! $access->evaluateToken( $token ) ) {
    EmilLogger::log( 'api, wrong token: ' . $token );
    die();
}

$status    = 'NOK';
$reason    = '';
$recommend = array();

//if( ! $access->isEmptyResult() ) 
{    
    $suggestion = $access->getSuggestion();
    if( $suggestion->isOk() ) 
    {
        $status      = 'OK';
        $reason      = '' . $suggestion->getReason();
        $recommend   = $suggestion->getRecommend();
        /*
        $temp   = $suggestion->getRecommend();
        $usecase = null;
        $out = array();
        foreach( $temp as $item ) {
            if( $usecase == null ) {
                $usecaseFactory = new UseCaseFactory();
                $usecase = $usecaseFactory->createByUsecaseNumber( $access->getUsecaseId() );
            }
            $out[] = $usecase->getRefId( $item );
        }
        $recommend = $out;
        // */
    }
}


$result = array( 
      'meta' => array(
                    'status' => $status
                )
    , 'data' => array(
                      'reason'    => $reason
                    , 'recommend' => $recommend
                )
);

header( 'Content-Type: application/json; charset=utf-8' );
echo json_encode( $result );