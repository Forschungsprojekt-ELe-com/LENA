<?php

class CustomerJourney {

    /**
     * 
     * @var int
     */
    protected $userId;

    /**
     * 
     * @var int
     */
    protected $journeyId;
    
    /**
     * 
     * @var int
     */
    protected $refId;
    
    /**
     * 
     * @var CustomerJourneyItemList
     */
    protected $planned;

    /**
     * 
     * @var CustomerJourneyItemList
     */
    protected $visited;

    /**
     * empty
     */
    public function __construct() {

    }
    
    public function nextElement() {
        $planned = $this->getPlanned()->getRefIdList();        
        $nextElement = 0;
        foreach( $planned as $refId ) {
//            echo $refId . '<br />';
            if( $nextElement > 0 ) {
                continue;
            }
            if( ! $this->isVisited( $refId ) ) {
                $nextElement = $refId;
            }
        }
        
        return $nextElement;
    }
    
    /**
     * 
     * @param int $refId
     * @return bool
     */
    public function isPlanned( $refId ) {
        return $this->planned->isset( $refId );
    }
    
    /**
     * 
     * @param int $refId
     * @return bool
     */
    public function isVisited( $refId ) {
        return $this->visited->isset( $refId );
    }
    
    /**
     * 
     * @param int $refId
     * @return $this
     */
    public function addPlanned( $refId ) {
        $this->planned->add( $refId );
        return $this;
    }
    
    /**
     * 
     * @param int $refId
     * @return $this
     */
    public function addVisited( $refId ) {
        $this->visited->add( $refId );
        return $this;
    }
    
    /**
     * 
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * 
     * @return int
     */
    public function getJourneyId() {
        return $this->journeyId;
    }
    
    /**
     * 
     * @return int
     */
    public function getRefId() {
        return $this->refId;
    }

    /**
     * 
     * @return CustomerJourneyItemList
     */
    public function getPlanned() {
        return $this->planned;
    }

    /**
     * 
     * @return CustomerJourneyItemList
     */
    public function getVisited() {
        return $this->visited;
    }

    /**
     * 
     * @param int $userId
     * @return $this
     */
    public function setUserId( $userId ) {
        $this->userId = $userId;
        return $this;
    }

    /**
     * 
     * @param int $journeyId
     * @return $this
     */
    public function setJourneyId( $journeyId ) {
        $this->journeyId = $journeyId;
        return $this;
    }
    
    /**
     * 
     * @param int $refId
     * @return $this
     */
    public function setRefId( $refId ) {
        $this->refId = $refId;
        return $this;
    }

    /**
     * 
     * @param CustomerJourneyItemList $planned
     * @return $this
     */
    public function setPlanned( $planned ) {
        $planned->setJourneyId( $this->getJourneyId() );
        $this->planned = $planned;
        return $this;
    }

    /**
     * 
     * @param CustomerJourneyItemList $visited
     * @return $this
     */
    public function setVisited( $visited ) {
        $visited->setJourneyId( $this->getJourneyId() );
        $this->visited = $visited;
        return $this;
    }
}