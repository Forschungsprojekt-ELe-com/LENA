<?php

class UseCaseFactory {
    
    protected $db;
    
    public function __construct() {
    }
    
    /**
     * 
     * @param int $usecaseNumber
     * @return UseCase
     */
    public function createByUsecaseNumber( $usecaseNumber ) {
        $cacheFileName = __DIR__ . '/../../../.lenacache/' . $usecaseNumber . '.php';
        if( isset( $cacheFileName ) ) {
            $LENA_REF    = array(); 
            $LENA_OBJ    = array(); 
            $LENA_TITLES = array();
            include $cacheFileName;
            $out = new UseCase( $usecaseNumber, $LENA_REF, $LENA_OBJ, $LENA_TITLES );
            return $out;
        }
        
        return null;
    }
    
    /**
     * 
     * @param int $crs_ref_id
     * @return UseCase
     */
    public function createByRefIdNumber( $crs_ref_id ) {
        for( $usecase = 1; $usecase <= 4; ++$usecase ) {
            $temp = $this->createByUsecaseNumber( $usecase );
            if( $temp !== null ) {
                if( $temp->issetRef( $crs_ref_id ) ) {
                    return $temp;
                }
            }
        }        
        return null;
    }
    
}