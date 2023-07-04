<?php
require_once __DIR__ . '/../_all.php';

use PHPUnit\Framework\TestCase;


class UseCaseTest extends TestCase {
    
    /**
     * 
     * @var UseCase
     */
    protected $sut;
    
    protected function setUp(): void {
        $ref = array(
              101 => 1
            , 102 => 2
            , 103 => 3
        );
        $obj = array(
              1 => 101
            , 2 => 102
            , 3 => 103
        );
        $titles = array(
              1 => 'MLE1'
            , 2 => 'MLE2'
            , 3 => 'MLE3'
        );
        
        $this->sut = new UseCase( 666, $ref, $obj, $titles );
    }
    
    protected function tearDown(): void {
        $this->sut = null;
    }
    
    public function testGetRefId() {        
        $this->assertEquals( 101, $this->sut->getRefId( 1 ) );
        $this->assertEquals( 102, $this->sut->getRefId( 2 ) );
    }
    
    public function testGetObjd() {        
        $this->assertEquals( 1, $this->sut->getObjId( 101 ) );
        $this->assertEquals( 2, $this->sut->getObjId( 102 ) );
    }
    
    public function testGetTitle() {
        $this->assertEquals( 'MLE1', $this->sut->getTitle( 1 ) );
        $this->assertEquals( 'MLE2', $this->sut->getTitle( 2 ) );        
    }
    
    public function testGetRefIdList() {
        $temp = $this->sut->getRefIdList();
        $this->assertEquals( 3, count( $temp ) );
        $this->assertTrue( isset( $temp[ 101 ] ) );
        $this->assertTrue( isset( $temp[ 102 ] ) );
        $this->assertTrue( isset( $temp[ 103 ] ) );
    }
    
    public function testGetObjIdList() {
        $temp = $this->sut->getObjIdList();
        $this->assertEquals( 3, count( $temp ) );
        $this->assertTrue( isset( $temp[ 1 ] ) );
        $this->assertTrue( isset( $temp[ 2 ] ) );
        $this->assertTrue( isset( $temp[ 3 ] ) );
    }
    
    public function testGetRefIdInstring() {
        $temp = $this->sut->getRefIdInstring();
        $this->assertEquals( '101,102,103', $temp );
    }
    
    public function testGetObjIdInstring() {
        $temp = $this->sut->getObjIdInstring();
        $this->assertEquals( '1,2,3', $temp );
    }
}