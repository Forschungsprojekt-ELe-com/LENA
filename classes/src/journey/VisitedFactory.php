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
SELECT ut_lp_marks.obj_id AS _obj_id
FROM ut_lp_marks
JOIN object_reference _or ON ( ut_lp_marks.ref_id=_or.ref_id )    
WHERE usr_id=" . $userId . "
  AND _or.deleted IS NULL
  AND status=2
  AND ut_lp_marks.obj_id IN ( " . $inString . " )
ORDER BY status_changed DESC
        ";
        $visited = array();
        $result  = $this->db->query( $sql );
        while( $line = $result->fetchAssoc() ) {
            $visited[] = $line[ '_obj_id' ];
        }
        return new Visited( $visited );
    }
}