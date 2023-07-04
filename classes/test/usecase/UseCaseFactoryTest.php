<?php
require_once __DIR__ . '/../_all.php';

use PHPUnit\Framework\TestCase;


class UseCaseFactoryTest extends TestCase {
 
    protected static $runOnce = true;
    
    /**
     * 
     * @var UseCaseFactory
     */
    protected $sut;
    
    protected function setUp(): void {        
        if( self::$runOnce ) {
            include __DIR__ . '/../.createMocks.php';
            self::$runOnce = false;
        }
        $this->sut = new UseCaseFactory();
    }
    
    protected function tearDown(): void {
        $this->sut = null;
    }
    
    public function testCreateByUsecaseNumber() {
        $temp = $this->sut->createByUsecaseNumber( 1 );
        $this->assertEquals( 1, $temp->getUsecaseNumber() );
    }
    
    public function testCreateByUsecaseNumberNegative() {
        $temp = $this->sut->createByUsecaseNumber( 666 );
        $this->assertEquals( null, $temp );
    }
    
    public function testCreateByRefIdNumber() {
        $temp = $this->sut->createByRefIdNumber( 101 );
        $this->assertEquals( 1, $temp->getUsecaseNumber() );
    }
    
    public function testCreateByRefIdNumberNegative() {
        $temp = $this->sut->createByUsecaseNumber( 666 );
        $this->assertEquals( null, $temp );
    }
}