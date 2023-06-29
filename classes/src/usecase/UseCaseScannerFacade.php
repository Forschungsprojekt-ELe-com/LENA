<?php

class UseCaseScannerFacade {
    
    protected $db;
    
    /**
     * 
     * @var int[]
     */
    protected $useCaseData;
    
    /**
     * 
     * @var int
     */
    protected $plannedId;
    
    public function __construct( $db ) {
        $this->db          = $db;
        $this->useCaseData = array();
        $this->plannedId   = 0;
    }
    
    /**
     * 
     * @param int $useCaseId
     * @param int $ref_id
     * @return $this
     */
    public function addScanner( $useCaseId, $ref_id ) {
        if( $useCaseId == 2 ) {
            $this->plannedId = $ref_id;
        }
        $this->useCaseData[ $useCaseId ] = $ref_id;
        return $this;
    }
    
    public function execute() {
        $scanner = new UseCaseScanner( $this->db );
        foreach( $this->useCaseData as $usecaseNo => $ref_id ) {
            $scanner->serializeUseCase( $usecaseNo, $ref_id );
        }
        if( $this->plannedId > 0 ) {
            $scanner->serializePlan( $this->plannedId );
        }
    }
}