<?php
require_once __DIR__ . '/../_all.php';

use PHPUnit\Framework\TestCase;


class PlannedRendererTest extends TestCase {
 
    protected static $runOnce = true;
    
    /**
     * 
     * @var PlannedRenderer
     */
    protected $sut;
    
    protected function setUp(): void {        
        if( self::$runOnce ) {
            include __DIR__ . '/../.createMocks.php';
            self::$runOnce = false;
        }
        $renderer = new PlannedRenderer( null );
        
        $factory = new UseCaseFactory();
        $usecase = $factory->createByRefIdNumber( 1 );
        
        $journey = array( 1,2,3 );
        $visited = new Visited( $journey );

        $renderer->setUsecase( $usecase )
                ->setVisited( $visited )
        ;
        $this->sut = $renderer;
    }
        
    protected function tearDown(): void {
        $this->sut = null;
    }
    
    public function testNext() {
        $temp = $this->sut->next();
        $this->assertEquals( 5, $temp );
    }
}
