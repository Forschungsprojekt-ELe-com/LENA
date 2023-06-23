<?php

class UseCase {
    
    protected $refIdList;
    
    protected $objIdList;
    
    public function __construct( $refIdList = array(), $objIdList = array() ) {
        $this->refIdList = $refIdList;
        $this->objIdList = $objIdList;
    }
    
    /**
     * 
     * @param int $crs_obj_id
     * @return int
     */
    public function getRefId( $crs_obj_id ) {
        if( $this->issetObj( $crs_obj_id ) ) {
            return $this->objIdList[ $crs_obj_id ];
        }
        return 0;
    }
    
    /**
     * 
     * @param int $crs_ref_id
     * @return int
     */
    public function getObjId( $crs_ref_id ) {
        if( $this->issetRef( $crs_ref_id ) ) {
            return $this->refIdList[ $crs_ref_id ];
        }
        return 0;
    }
    
    /**
     * 
     * @param int $crs_ref_id
     * @return bool
     */
    public function issetRef( $crs_ref_id ) {
        return isset( $this->refIdList[ $crs_ref_id ] ); 
    }
    
    /**
     * 
     * @param int $crs_obj_id
     * @return bool
     */
    public function issetObj( $crs_obj_id ) {
        return isset( $this->objIdList[ $crs_obj_id ] ); 
    }
    
}