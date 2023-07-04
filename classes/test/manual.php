<html><body>
<?php
require_once __DIR__ . '/_all.php';

$db = new MyIliasPDO( "mysql:host=localhost;dbname=test", 'root', '' );


$usecaseFactory = new UseCaseFactory();
//$usecase = $usecaseFactory->createByUsecaseNumber( 1 );
$usecase = $usecaseFactory->createByRefIdNumber( 201 );
//print_r( $usecase );
// */

/*
$renderer = new RendererList( $db );

$journey = array( 1,2,3,4,5 );
$visited = new Visited( $journey );

$renderer->addVisited()
        ->addPlanned()
        ->setUsecase( $usecase )
        ->setVisited( $visited )
;
echo $renderer->render();
// */



    /*
    $factory = new SuggestionFactoryMock( $i, $i );
    print_r( $factory->execute() );
    // */
    
    
    $access = new AccessToken( 666 );
    $token = '';
    if( isset( $_REQUEST[ 'token' ] ) ) {
        $token = $_REQUEST[ 'token' ];
    } else {
        $token  = $access->createToken();
    }
        
    if( $access->evaluateToken( $token ) ) {
        $suggestion = $access->getSuggestion();
        echo '<pre>', print_r( $suggestion, true ), '</pre>';
        echo 'TOKEN: ' . $token . '<br />' . PHP_EOL;
        echo '<a href="http://localhost:8080/my/LENA/classes/test/manual.php?token=' . $token . '" target="_blank">clickme</a>';
    }
    // */
