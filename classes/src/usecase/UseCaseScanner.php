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
    
    /**
     * Writes the temp-files
     * 
     * @param int $usecaseNo
     * @param int $ref_id
     */
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
            $out .= '$LENA_TITLES[ ' . $obj_id . ' ] = \'' . $title . '\';' . PHP_EOL;            
        }                
        
        
        
        file_put_contents( UseCaseFactory::LOCATION . $usecaseNo . '.php', $out );
        
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
        
//        $sql = "SELECT 1
//  , _t.child AS _ref_id
//  , _or.obj_id AS _obj_id
//FROM tree _t
//  JOIN object_reference _or ON ( _t.child=_or.ref_id )  
//WHERE _t.path LIKE '" . $path . "'
//ORDER BY _t.lft
//        ";
        
        $sql = "SELECT 1
  , _t.child AS _ref_id
  , _or.obj_id AS _obj_id
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id )  
  JOIN object_data _od ON ( _or.obj_id=_od.obj_id)
WHERE _od.type='copa'
   AND _or.deleted IS NULL
   AND _t.path LIKE '" . $path . "'   
   AND _od.obj_id IN (1618,1668,1552,892,893,894,998,895,896,897,898,899,900,901,902,903,904,905,906,907,908,909,910,911,912,913,914,915,916,917,918,919,920,921,922,923,924,925,926,927,928,929,930,931,932,933,934,935,936,937,938,939,940,941,1319,1233,1235,1237,1239,1240,1241,1242,1243,1244,1245,1253,1324,1325,1151,1444,1333,1255,1669,1331,1376,1326,1567,1445,1332,1219,1379,1327,1568,1451,1296,1461,1221,1328,1569,1294,1447,1415,1434,1329,1570,1416,1466,1218,1479,1330)
   
ORDER BY _t.lft, _t.path
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
        
        file_put_contents( UseCaseFactory::LOCATION . 'planned.php', $out );        
    }
}