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
    
    /**
     * 
     * @var int[]
     */
    protected $parentList;
    
    /**
     * 
     * @var int[]
     */
    protected $testList;
    
    public function __construct( $db ) {
        $this->db = $db;
        $this->ref_ids  = array();
        $this->obj_ids  = array();                        
        $this->titles   = array();                        
        $this->testList = array();                        
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
        
        $out .= '$LENA_PARENTS = array();' . PHP_EOL;
        foreach( $this->parentList as $child_obj_id => $parent_obj_id ) {                        
            $out .= '$LENA_PARENTS[ ' . $child_obj_id . ' ] = ' . $parent_obj_id . ';' . PHP_EOL;            
        }
        
        $out .= PHP_EOL 
                . '$LENA_TESTS = array();' . PHP_EOL;
                
        foreach( $this->testList as $ref_id => $obj_id ) {                        
            $out .= '$LENA_TESTS[ ' . $ref_id . ' ] = ' . $obj_id . ';' . PHP_EOL;            
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
  , _t.parent AS _parent_ref_id
  , _or2.obj_id AS _parent_obj_id
  , _od2.title AS _parent_title
  , _od.type AS _type
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id AND _or.deleted IS NULL)
  JOIN object_data _od ON ( _od.obj_id=_or.obj_id )  
  JOIN object_reference _or2 ON ( _t.parent=_or2.ref_id AND _or2.deleted IS NULL )
  JOIN object_data _od2 ON ( _od2.obj_id=_or2.obj_id )  
WHERE _t.path LIKE '" . $path . "'
        ";
        $result = $this->db->query( $sql );
        
        while( $line = $result->fetchAssoc() ) {
            $this->ref_ids[ $line[ '_ref_id' ] ] = $line[ '_obj_id' ];
            $this->obj_ids[ $line[ '_obj_id' ] ] = $line[ '_ref_id' ];
            $this->titles[ $line[ '_ref_id' ] ]  = $line[ '_title' ];

            $this->titles[ $line[ '_parent_ref_id' ] ]  = $line[ '_parent_title' ];
            $this->parentList[ $line[ '_obj_id' ] ] = $line[ '_parent_ref_id' ];
            if( $line[ '_type' ] == 'tst' ){
                $this->testList[ $line[ '_ref_id' ] ] = $line[ '_obj_id' ];
            }
        }
    }
    
    public function getTitles( $ref_id ) {
        if( $this->issetObj( $ref_id ) ) {
            return $this->titles[ $ref_id ];
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
        if( empty( $ref_id ) ){
            return false;
        }
        return isset( $this->ref_ids[ $ref_id ] );
    }
    
    /**
     * 
     * @param int $obj_id
     * @return bool
     */
    public function issetObj( $obj_id ) {
        if( empty( $obj_id ) ) {
            return false;
        }
        return isset( $this->obj_ids[ $obj_id ] );
    }
    
    
    /**
     * 
     * @param int $ref_id
     */
    public function serializePlan( $ref_id ) {
  
        // besser 2 schleifen: 1. schleife: alle ordner typ: "fold" und 2. schleife: alle objekte unter ordner "copa" | "tst"
        // $childs = $tree->getChildsByType( $ref_id );                
        
        $allHeadings = array();
        $plan = array();

        $debug = '';
        
        // find headings
        $sql = "SELECT 1
  , _t.child AS _ref_id
  , _od.title AS _title
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id )    
  JOIN object_data _od ON ( _or.obj_id=_od.obj_id)
WHERE _t.tree = 1
  AND _od.type = 'fold'
  AND _or.deleted IS NULL
  AND _t.parent = " . $ref_id . " 
        ";
        $result = $this->db->query( $sql );
        while( $line = $result->fetchAssoc() ) {
            $allHeadings[ $line[ '_ref_id' ] ] = $line[ '_title' ];
        }

        
        foreach( $allHeadings as $id => $title ) {
            $sql = "SELECT 1
  , _od.type AS _type
  , _orParent.obj_id AS _parentOBJID
  
  , _t.child AS _ref_id
  , _or.obj_id AS _obj_id
  , _od.title AS _title  
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id )  
  JOIN object_reference _orParent ON ( _t.parent=_orParent.ref_id)
  JOIN object_data _od ON ( _or.obj_id=_od.obj_id)
  JOIN container_sorting _cs ON ( _t.child=_cs.child_id AND _orParent.obj_id=_cs.obj_id )
WHERE _t.tree = 1
  AND _or.deleted IS NULL
  AND _t.parent = " . $id . " 
ORDER BY _cs.position
            ";
            $debug .= PHP_EOL . PHP_EOL . $sql;
            $result = $this->db->query( $sql );        
            while( $line = $result->fetchAssoc() ) {            
                $plan[ $line[ '_obj_id' ] ] = $line[ '_ref_id' ];
            }                               
        }
        
        /*
        $sql = "SELECT 1
  , _t.child AS _ref_id
  , _or.obj_id AS _obj_id
  , _od.title AS _title
FROM tree _t
  JOIN object_reference _or ON ( _t.child=_or.ref_id )  
  JOIN object_data _od ON ( _or.obj_id=_od.obj_id)
WHERE _t.tree = 1
  AND _od.type = 'tst'
  AND _or.deleted IS NULL
  AND _t.parent = " . $id . " 
ORDER BY lft
            ";
        $result = $this->db->query( $sql );        
        while( $line = $result->fetchAssoc() ) {            
            $plan[ $line[ '_obj_id' ] ] = $line[ '_ref_id' ];
        }               
        // */
        
        $out = '<?php' . PHP_EOL
               . '$LENA_PLAN=array();' . PHP_EOL
        ;
        
        foreach( $plan as $obj_id => $ref_id ) {            
            $out .= '$LENA_PLAN[ ' . $obj_id . ' ] = ' . $ref_id . ';' . PHP_EOL;
        }       

        if( strlen( $debug ) > 0 ) {
            file_put_contents( __DIR__ . '/../../../.lenacache/debug.txt', $debug );  
        }

        
        file_put_contents( UseCaseFactory::LOCATION . 'planned.php', $out );        
    }
    
    
    
    
    /**
     * 
     * @param int $ref_id
     */
    public function serializePlanOld( $ref_id ) {
  
        // besser 2 schleifen: 1. schleife: alle ordner typ: "fold" und 2. schleife: alle objekte unter ordner "copa" | "tst"
        // $childs = $tree->getChildsByType( $ref_id );                
        
        $allHeadings = array();
        $plan = array();

        $debug = '';
        
        global $DIC;
        $tree = $DIC->repositoryTree();
        $foldList = $tree->getChildsByType( $ref_id, 'fold' );
        
        /*
        $sortedFolderList = ilContainerSorting::_getInstance( $this->getObjId( $ref_id ) );
        $sortedFolders    = $sortedFolderList->sortItems( array( 'my_ref' => $foldList ) );
        $foldList         = $sortedFolders['my_ref'];
        // */
        
//        $debug .= 'FOLD LIST---------------------' . print_r( $foldList, true ) . PHP_EOL;
        
        foreach( $foldList as $fold ) {
            $id = $fold[ 'child' ];
            $debug .= 'FOLD: ' . $fold[ 'title' ] . PHP_EOL;
            $copaList = $tree->getChildsByType( $id, 'copa' );
            
            /*
            $sortedCopaList = ilContainerSorting::_getInstance( $this->getObjId( $fold ) );
            $sortedCopa     = $sortedCopaList->sortItems( array( 'my_ref' => $copaList ) );
            $copaList       = $sortedFolders[ 'my_ref' ];
            // */
            
            
            
//            $debug .= 'COPA LIST---------------------' . print_r( $copaList, true ) . PHP_EOL;            
            foreach( $copaList as $copa ) {
                $copa_id = $copa[ 'child' ];
                $plan[ $this->getObjId( $copa_id ) ] = $copa_id;
                $debug .= '     COPA: ' . $copa[ 'title' ] . PHP_EOL;
            }
            $testList = $tree->getChildsByType( $id, 'tst' );
//            $debug .= 'TEST LIST---------------------' . print_r( $testList, true ) . PHP_EOL;
            foreach( $testList as $test ) {
                $test_id = $test[ 'child' ];
                $plan[ $this->getObjId( $test_id ) ] = $test_id;
                $debug .= '     TEST: ' . $test[ 'title' ] . PHP_EOL;
            }
        }
        if( strlen( $debug ) > 0 ) {
            file_put_contents( __DIR__ . '/../../../.lenacache/debug.txt', $debug );  
        }
        // */        
        
        $out = '<?php' . PHP_EOL
               . '$LENA_PLAN=array();' . PHP_EOL
        ;
        
        foreach( $plan as $obj_id => $ref_id ) {            
            $out .= '$LENA_PLAN[ ' . $obj_id . ' ] = ' . $ref_id . ';' . PHP_EOL;
        }       
        
        file_put_contents( UseCaseFactory::LOCATION . 'planned.php', $out );        
    }
}