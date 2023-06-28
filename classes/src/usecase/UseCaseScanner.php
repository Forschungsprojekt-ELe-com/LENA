<?php


class UseCaseScanner {
    
    protected $db;
    
    /**
     * 
     * @var int[]
     */
    protected $ref_ids;
    
    /**
     * 
     * @var int[]
     */
    protected $obj_ids;
    
    /**
     * 
     * @var string[]
     */    
    protected $titles;
    
    public function __construct( $db ) {
        $this->db = $db;
        $this->ref_ids = array();
        $this->obj_ids = array();                        
        $this->titles  = array();                        
    }
    
    public function serializeUseCase( $usecaseNo, $ref_id ) {
        $this->ref_ids = array();
        $this->obj_ids = array();                        
        $this->scanTreeForIds( $ref_id );
                        
        $out = '<?php' . PHP_EOL
            . PHP_EOL
            . '$LENA_REF = array();' . PHP_EOL
            . '$LENA_OBJ = array();' . PHP_EOL
            . PHP_EOL
        ;
        foreach( $this->ref_ids as $ref_id => $obj_id ) {
            $out .= '$LENA_REF[ ' . $ref_id . ' ] = ' . $obj_id . ';' . PHP_EOL;
            $out .= '$LENA_OBJ[ ' . $obj_id . ' ] = ' . $ref_id . ';' . PHP_EOL;
        }                
        
        $out .= PHP_EOL
                . PHP_EOL
                . '$LENA_TITLES = array();' . PHP_EOL
                . PHP_EOL
        ;
        foreach( $this->titles as $obj_id => $title ) {
            $out .= '$LENA_TITLES[ ' . $obj_id . ' ] = "' . $title . '";' . PHP_EOL;            
        }                
        
        
        
        file_put_contents( __DIR__ . '/../../../.lenacache/' . $usecaseNo . '.php', $out );
        
        /*
        echo '<h1>usecase:' . $usecaseNo . ':</h1><pre>';
        echo 'ref_ids:'; print_r( $this->ref_ids ); echo PHP_EOL . '<br />' . PHP_EOL;
        echo 'obj_ids:'; print_r( $this->obj_ids ); echo PHP_EOL . '<br />' . PHP_EOL;
        echo '<textarea rows="30" cols="80">' . $out . '</textarea>';
        // */
    }
    
    /**
     * 
     * @param int $ref_id
     */
    public function scanTreeForIds( $ref_id ) {
        $path = '';
        $sql = "SELECT path FROM tree WHERE child=" . $ref_id;
        $result = $this->db->query( $sql );
        if( $line = $result->fetchAssoc() ) {
            $path = $line[ 'path' ] . '.%';
        }
        
        $sql = "SELECT 1
  , _t.child AS _ref_id
  , _or.obj_id AS _obj_id
  , _od.title AS _title
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id )
  JOIN object_data _od ON ( _od.obj_id=_or.obj_id )
WHERE _t.path LIKE '" . $path . "'
        ";
        $result = $this->db->query( $sql );
        
        while( $line = $result->fetchAssoc() ) {
            $this->ref_ids[ $line[ '_ref_id' ] ] = $line[ '_obj_id' ];
            $this->obj_ids[ $line[ '_obj_id' ] ] = $line[ '_ref_id' ];
            $this->titles[ $line[ '_obj_id' ] ]  = $line[ '_title' ];
        }
    }
    
    public function getTitles( $obj_id ) {
        if( $this->issetObj( $obj_id ) ) {
            return $this->titles[ $obj_id ];
        }
        return "";
    }
    
    /**
     * 
     * @param int $ref_id
     * @return int obj_id or 0
     */
    public function getObjId( $ref_id ) {
        if( $this->issetRef( $ref_id ) ) {
            return $this->ref_ids[ $ref_id ];
        }
        return 0;
    }
    
    /**
     * 
     * @param int $obj_id
     * @return int obj_id or 0
     */
    public function getRefId( $obj_id ) {
        if( $this->issetObj( $obj_id ) ) {
            return $this->obj_ids[ $obj_id ];
        }
        return 0;
    }
    
    /**
     * 
     * @param int $ref_id
     * @return bool
     */        
    public function issetRef( $ref_id ) {
        return isset( $this->ref_ids[ $ref_id ] );
    }
    
    /**
     * 
     * @param int $obj_id
     * @return bool
     */
    public function issetObj( $obj_id ) {
        return isset( $this->obj_ids[ $obj_id ] );
    }
    
    /**
     * 
     * @param int $ref_id
     */
    public function serializePlan( $ref_id ) {
        $path = '';
        $sql = "SELECT path FROM tree WHERE child=" . $ref_id;
        $result = $this->db->query( $sql );
        if( $line = $result->fetchAssoc() ) {
            $path = $line[ 'path' ] . '.%';
        }
        
        $sql = "SELECT 1
  , _t.child AS _ref_id
  , _or.obj_id AS _obj_id
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id )  
WHERE _t.path LIKE '" . $path . "'
ORDER BY _t.lft
        ";
        $result = $this->db->query( $sql );
        
        $plan = array();
        while( $line = $result->fetchAssoc() ) {            
            $plan[ $line[ '_obj_id' ] ] = $line[ '_ref_id' ];            
        }
        
        $out = '<?php' . PHP_EOL
               . '$LENA_PLAN=array();' . PHP_EOL
        ;
        
        foreach( $plan as $obj_id => $ref_id ) {            
            $out .= '$LENA_PLAN[ ' . $obj_id . ' ] = ' . $ref_id . ';' . PHP_EOL;
        }       
        
        file_put_contents( __DIR__ . '/../../../.lenacache/planned.php', $out );        
    }
}