<?php

class UseCaseFactory {

    const LOCATION = __DIR__ . '/../../../.lenacache/';
    
    /**
     * 
     * @param int $usecaseNumber
     * @return UseCase
     */
    public function createByUsecaseNumber( $usecaseNumber ) {
        $cacheFileName = UseCaseFactory::LOCATION . $usecaseNumber . '.php';
        if( is_file( $cacheFileName ) ) {
            $LENA_REF    = array(); 
            $LENA_OBJ    = array(); 
            $LENA_TITLES = array();
            $LENA_PARENTS= array();
            include $cacheFileName;
            $out = new UseCase( $usecaseNumber, $LENA_REF, $LENA_OBJ, $LENA_TITLES, $LENA_PARENTS );
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