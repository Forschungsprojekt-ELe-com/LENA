<html><body><pre>
<?php
require_once __DIR__ . '/_all.php';

$db = new MyIliasPDO( "mysql:host=localhost;dbname=test", 'root', '' );


$usecaseFactory = new UseCaseFactory();
//$usecase = $usecaseFactory->createByUsecaseNumber( 1 );
$usecase = $usecaseFactory->createByRefIdNumber( 201 );
//print_r( $usecase );
// */

$renderer = new RendererList( $db );

$journey = array( 1,2,3,4,5 );
$visited = new Visited( $journey );

$renderer->addVisited()
        ->addPlanned()
        ->setUsecase( $usecase )
        ->setVisited( $visited )
;
echo $renderer->render();


