<?php

class VisitedFactory {
    
    protected $db;
    
    public function __construct( $db ) {
        $this->db = $db;
    }
    
    /**
     * 
     * @param UseCase $usecase
     * @param int     $userId
     * @return Visited
     */
    public function create( $usecase, $userId ) {
        $inString = $usecase->getObjIdInstring();
        $sql = "
SELECT obj_id AS _obj_id
FROM ut_lp_marks
WHERE usr_id=" . $userId . "  
  AND status=2
  AND obj_id IN ( " . $inString . " )
ORDER BY status_changed ASC
        ";
        $visited = array();
        $result  = $this->db->query( $sql );
        while( $line = $result->fetchAssoc() ) {
            $visited[] = $line[ '_obj_id' ];
        }
        return new Visited( $visited );
    }
}