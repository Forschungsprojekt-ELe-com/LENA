<?php
require_once __DIR__ . '/../_all.php';

use PHPUnit\Framework\TestCase;


class VisitedTest extends TestCase {
 
    /**
     * 
     * @var Visited
     */
    protected $sut;
    
    protected function setUp(): void {
        $journey = array( 1,2,3 );        
        $this->sut = new Visited( $journey );
    }
        
    protected function tearDown(): void {
        $this->sut = null;
    }
    
    public function testGetVisitedList() {
        $temp = $this->sut->getVisitedList();
        $this->assertEquals( 3, count( $temp ) );        
    }
    
    public function testIsVisited() {        
        $this->assertTrue( $this->sut->isVisited( 1 ) );
        $this->assertTrue( $this->sut->isVisited( 2 ) );
        $this->assertTrue( $this->sut->isVisited( 3 ) );
        $this->assertFalse( $this->sut->isVisited( 666 ) );
    }
    
    public function testSetRawData() {        
        $visited = array( 1 );        
        $this->sut->setRawData( $visited );
        $this->assertTrue( $this->sut->isVisited( 1 ) );
        $this->assertFalse( $this->sut->isVisited( 2 ) );
    }
}

