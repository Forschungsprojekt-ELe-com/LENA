<?php

class Planned {
    
    /**
     * 
     * @var Planned
     */
    private static $instance;
    
    /**
     * 
     * @var int[]
     */
    protected $plannedList;

    /**
     * Use this to create the Planned Instance.
     * 
     * @return Planned
     */
    public static function getInstance() {
        if( self::$instance == null ) {
            self::$instance = new Planned();
        }
        return self::$instance;
    }    
    
    private function __construct() {
        $this->plannedList = array();
        if( is_file( __DIR__ . '/../../../.lenacache/planned.php' ) ) {
            include __DIR__ . '/../../../.lenacache/planned.php';
            $this->plannedList = $LENA_PLAN;
        }
                
    }
           
    /**
     * 
     * @param int $obj_id
     * @return bool
     */
    public function isPlanned( $obj_id ) {
        return isset( $this->plannedList[ $obj_id ] ); 
    }
    
    /**
     * 
     * @return int[]
     */
    public function getObjIdList() {
        return array_keys( $this->plannedList );
    }
}