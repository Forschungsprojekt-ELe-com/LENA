<?php

class CustomerJourneyItemListFactory{
    
    const VISITED = 'visited';
    const PLANNED = 'planned';
    
    protected $db;
    
    /**
     * 
     * @var string
     */
    protected $tablename;
    
    public function __construct( $db, $tablename=self::VISITED ) {
        $this->db        = $db;
        $this->tablename = $tablename;
    }
    
    /**
     * 
     * @return string
     */
    public function getTablename() {
        return $this->tablename;
    }

    /**
     * 
     * @param string $tablename
     * @return $this
     */
    public function setTablename( $tablename ) {
        $this->tablename = $tablename;
        return $this;
    }

    /**
     * 
     * @param type $journeyId
     * @return \CustomerJourneyItemList
     */
    public function read( $journeyId ) {
        $out = new CustomerJourneyItemList( $journeyId );
        $sql = "SELECT ref_id FROM qu_cj_customer_journey_" . $this->getTablename() . " WHERE journey_id=" . $journeyId . " ORDER BY id ASC";
        $result = $this->db->query( $sql );
        $values = array();
        while( $line = $result->fetchAssoc() ) {
            $values[] = $line[ 'ref_id' ];
        }
        $out->setRawData( $values );
        return $out;
    }
    
    /**
     * 
     * @param CustomerJourneyItemList $journeyItemList
     */
    public function create( $journeyItemList ) {
        $values = $journeyItemList->getRefIdList();
        foreach( $values as $refId ) {
            $sql = "INSERT INTO qu_cj_customer_journey_" . $this->getTablename() 
                    . " SET ref_id=" . $refId
                    . "     , journey_id=" . $journeyItemList->getJourneyId()
            ;
            $this->db->query( $sql );
        }
    }
    
    /**
     * 
     * @param CustomerJourneyItemList $journeyItemList
     * @param bool $hardUpdate
     */
    public function update( $journeyItemList, $hardUpdate=false ) {
        if( $hardUpdate ) {
            $this->delete( $journeyItemList );
            $this->create( $journeyItemList );
        } else {
            if( $journeyItemList->isAdded() ) {
                $values = $journeyItemList->getAdded();
                foreach( $values as $refId ) {
                    $sql = "INSERT INTO qu_cj_customer_journey_" . $this->getTablename() 
                            . " SET ref_id=" . $refId
                            . "     , journey_id=" . $journeyItemList->getJourneyId()
                    ;
//                    echo '<h1>:', $sql, ':</h1>';
                    $this->db->query( $sql );
                }
            }
        }
    }
    
    /**
     * 
     * @param CustomerJourneyItemList $journeyItemList
     */
    public function delete( $journeyItemList ) {
        $sql = "DELETE FROM qu_cj_customer_journey_" . $this->getTablename() 
                . " WHERE journey_id=" . $journeyItemList->getJourneyId()
        ;
        $this->db->query( $sql );
    }
}