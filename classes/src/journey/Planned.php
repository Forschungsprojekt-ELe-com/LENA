<?php

class Planned {
    
    /**
     * 
     * @var Planned
     */
    private static Planned $instance;
    
    /**
     * 
     * @var int[]
     */
    protected array $plannedList;

    /**
     * Use this to create the Planned Instance.
     *
     * @param bool $mockdata
     * @return Planned
     */
    public static function getInstance(): Planned {
        if( self::$instance == null ) {
            self::$instance = new Planned();
        }
        return self::$instance;
    }    
    
    private function __construct() {
        $this->plannedList = array();
        if( is_file( __DIR__ . '/../../../.lenacache/planned.php' ) ) {
            $LENA_PLAN = array();
            include __DIR__ . '/../../../.lenacache/planned.php';
            $this->plannedList = $LENA_PLAN;
        }
    }
           
    /**
     * 
     * @param int $obj_id
     * @return bool
     */
    public function isPlanned( int $obj_id ): bool {        
        return isset( $this->plannedList[ $obj_id ] ); 
    }
    
    /**
     * 
     * @return int[]
     */
    public function getObjIdList(): array {
        return array_keys( $this->plannedList );
    }
    
    /**
     * 
     * @return array   obj_id => ref_id
     */
    public function getPlannedList(): array {
        return $this->plannedList;
    }
}