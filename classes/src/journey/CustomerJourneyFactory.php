<?php

class CustomerJourneyFactory{
    
    protected $db;
    
    /**
     * 
     * @var CustomerJourneyItemListFactory
     */
    protected $plannedFactory;
    
    /**
     * 
     * @var CustomerJourneyItemListFactory
     */
    protected $visitedFactory;
    
    
    public function __construct( $db ) {
        $this->db = $db;      
        
        $this->plannedFactory = new CustomerJourneyItemListFactory( $db );
        $this->plannedFactory->setTablename( CustomerJourneyItemListFactory::PLANNED );
        
        $this->visitedFactory = new CustomerJourneyItemListFactory( $db );
        $this->visitedFactory->setTablename( CustomerJourneyItemListFactory::VISITED );                
    }
    
    /**
     * 
     * @param type $journeyId
     * @return \CustomerJourney
     */
    public function read( $journeyId ) {
        $out = new CustomerJourney( $journeyId );
        $sql = "SELECT id, user_id, ref_id FROM qu_cj_customer_journey WHERE id=" . $journeyId;
        $result = $this->db->query( $sql );        
        while( $line = $result->fetchAssoc() ) {
            $out->setJourneyId( 0 + $line[ 'id' ] );
            $out->setRefId( 0 + $line[ 'ref_id' ] );
            $out->setUserId( 0 + $line[ 'user_id' ] );
        }
        
        $visited = $this->visitedFactory->read( $journeyId );
        $out->setVisited( $visited );
        $planned = $this->plannedFactory->read( $journeyId );
        $out->setPlanned( $planned );
                
        return $out;
    }
    
    /**
     * 
     * @param CustomerJourney $journey
     */
    public function create( $journey ) {
        $sql = "INSERT INTO qu_cj_customer_journey"
                    . " SET ref_id=" . $journey->getRefId()
                    . "     , user_id=" . $journey->getUserId()
        ;
        $this->db->query( $sql );
        
        $sql = "SELECT id FROM qu_cj_customer_journey"
                    . " WHERE ref_id=" . $journey->getRefId()
                    . "  AND user_id=" . $journey->getUserId()
        ;        
        $result = $this->db->query( $sql );
        $id=0;
        while( $line = $result->fetchAssoc() ) {
            $id= 0 + $line[ 'id' ];
        }
        $journey->setJourneyId( $id );
        $visited = $journey->getVisited();
        $visited->setJourneyId( $id );
        $planned = $journey->getPlanned();
        $planned->setJourneyId( $id );
        $this->visitedFactory->create( $visited );
        $this->plannedFactory->create( $planned );
        
        return $journey;
    }
    
    /**
     * 
     * @param CustomerJourney $journey
     * @param bool $hardUpdate
     */
    public function update( $journey, $hardUpdate=false ) {
        if( $hardUpdate ) {
            $this->delete( $journey );
            $this->create( $journey );
        } else {
            $sql = "UPDATE qu_cj_customer_journey"
                    . " SET ref_id=" . $journey->getRefId()
                    . "     , user_id=" . $journey->getUserId()
                    . " WHERE id=" . $journey->getJourneyId()
            ;
            $this->db->query( $sql );
            $this->plannedFactory->update( $journey->getPlanned(), false );
            $this->visitedFactory->update( $journey->getVisited(), false );
        }
    }
    
    /**
     * 
     * @param CustomerJourney $journey
     */
    public function delete( $journey ) {
        $sql = "DELETE FROM qu_cj_customer_journey"
                . " WHERE id=" . $journey->getJourneyId()
        ;
        $this->db->query( $sql );
        $this->plannedFactory->delete( $journey->getJourneyId() );
        $this->visitedFactory->delete( $journey->getJourneyId() );
    }
}