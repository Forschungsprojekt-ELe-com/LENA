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
     * 
     * @var int[]
     */
    protected $lookup;

    /**
     * Use this to create the Planned Instance.
     *
     * @param bool $mockdata
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
        $this->lookup      = array();
        if( is_file( __DIR__ . '/../../../.lenacache/planned.php' ) ) {
            include __DIR__ . '/../../../.lenacache/planned.php';
            $this->plannedList = $LENA_PLAN;
            foreach( $LENA_PLAN as $ref_id ) {
                $this->lookup[ $ref_id ] = 1;
            }
        }
    }
           
    /**
     * 
     * @param int $obj_id
     * @return bool
     */
    public function isPlanned( $obj_id ) {
        return isset( $this->lookup( $ref_id ) );
        return isset( $this->plannedList[ $obj_id ] ); 
    }
    
    /**
     * 
     * @return int[]
     */
    public function getObjIdList() {
        return $this->plannedList;
        return array_keys( $this->plannedList );
    }
}