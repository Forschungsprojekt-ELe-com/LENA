<?php

class EmilLogger {
    
    const LOCATION = __DIR__ . '/../../../.lenacache/api_log.txt';
    
    /**
     * 
     * @param string $message
     */
    public static function log( $message ) {
        if( ! is_file( EmilLogger::LOCATION ) ) {
            file_put_contents( EmilLogger::LOCATION, '' );
        }
        $file = fopen( EmilLogger::LOCATION, "a" ) or die( "Unable to open file!" );        
        fwrite( $file, PHP_EOL 
                        . date( "Y-m-d H:i:s" ) 
                        . '|' 
                        . $message 
        );
        fclose( $file );
    }
    
    /**
     * 
     * @param int $numberOfLinesRemain
     */
    public static function cleanup( $numberOfLinesRemain = 100 ) {
        if( is_file( EmilLogger::LOCATION ) ) {
            $lines = file( EmilLogger::LOCATION );
            $log = array();
            for( $i=0; $i < $numberOfLinesRemain; ++$i ) {
                $log[] = array_pop( $lines );
            }            
            $out = implode( PHP_EOL, array_reverse( $log ) );
            file_put_contents( EmilLogger::LOCATION, $out );
        }
    }
}