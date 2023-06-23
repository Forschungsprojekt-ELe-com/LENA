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
    
    public function __construct( $db ) {
        $this->db = $db;
        $this->ref_ids = array();
        $this->obj_ids = array();                        
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
        
        file_put_contents( __DIR__ . '/../../../.lenacache/' . $usecaseNo . '.php', $out );
        
        
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
        $sql = "SELECT 1
  , _t.child AS _ref_id
  , _or.obj_id AS _obj_id
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id )
WHERE _t.path LIKE '%." . $ref_id . ".%'
        ";
        $result = $this->db->query( $sql );
        
        while( $line = $result->fetchAssoc() ) {
            $this->ref_ids[ $line[ '_ref_id' ] ] = $line[ '_obj_id' ];
            $this->obj_ids[ $line[ '_obj_id' ] ] = $line[ '_ref_id' ];
        }
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
}