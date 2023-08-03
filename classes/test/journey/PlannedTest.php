<?php
require_once __DIR__ . '/../_all.php';

use PHPUnit\Framework\TestCase;


class PlannedTest extends TestCase {
 
    protected static $runOnce = true;
    
    /**
     * 
     * @var Planned
     */
    protected $sut;
    
    protected function setUp(): void {        
        if( self::$runOnce ) {
            include __DIR__ . '/../.createMocks.php';
            self::$runOnce = false;
        }
        $this->sut = Planned::getInstance();
    }
        
    protected function tearDown(): void {
        $this->sut = null;
    }
    
    public function testGetObjIdList() {
        $temp = $this->sut->getObjIdList();
        $this->assertEquals( 5, count( $temp ) );
    }
    
    public function testIntegrity() {        
        $this->assertTrue( $this->sut->isPlanned( 1 ) );
        $this->assertTrue( $this->sut->isPlanned( 3 ) );
        $this->assertTrue( $this->sut->isPlanned( 5 ) );
        $this->assertTrue( $this->sut->isPlanned( 7 ) );
        $this->assertTrue( $this->sut->isPlanned( 9 ) );
        
        $this->assertFalse( $this->sut->isPlanned( 666 ) );
        
    }
}
