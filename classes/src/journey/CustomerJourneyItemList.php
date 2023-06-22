<?php

class CustomerJourneyItemList {
    
    /**
     * 
     * @var int
     */
    protected $journeyId=0;
    
    /**
     * 
     * @var int[]
     */
    protected $refIdList=array();
    
    /**
     * 
     * @var array(id=>id)
     */
    protected $lookup=array();
    
    /**
     * 
     * @var array(int)
     */
    protected $added=array();
    
    /**
     * 
     * @param int $journeyId
     */
    public function __construct( $journeyId=0 ) {
        $this->journeyId = $journeyId;
    }

    /**
     * 
     * @param int[] $values
     * @return $this
     */
    public function setRawData( $values ) {
        $this->refIdList = $values;
        foreach( $values as $value ) {
            $this->lookup[ $value ] = $value;
        }
        return $this;
    }
    
    /**
     * 
     * @param int $refId
     * @return bool
     */
    public function isset( $refId ) {
        return isset( $this->lookup[ $refId ] );
    }
    
    /**
     * 
     * @param int $refId
     * @return $this
     */
    public function add( $refId ) {
        $this->added[] = $refId;
        $values        = $this->getRefIdList();
        $values[]      = $refId;
        $this->setRawData( $values );
        return $this;
    }
    
    /**
     * 
     * @return bool
     */
    public function isAdded() {
        return ( count( $this->added ) > 0 );
    }
    
    /**
     * 
     * @param int $journeyId
     * @return $this
     */
    function setJourneyId( $journeyId ) {
        $this->journeyId = $journeyId;
        
        return $this;
    }

    /**
     * 
     * @return int
     */
    public function getJourneyId(): int {
        return $this->journeyId;
    }

    /**
     * 
     * @return int[]
     */
    public function getRefIdList() {
        return $this->refIdList;
    }    
    
    /**
     * 
     * @return int[]
     */
    public function getAdded() {
        return $this->added;
    }
}