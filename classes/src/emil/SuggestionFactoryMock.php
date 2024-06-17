<?php

class SuggestionFactoryMock extends SuggestionFactory {
    
    public function execute(): Suggestion {
        $filename = "ok";
        $temp = rand( 0, 100 );
//        if(false ) //( $temp > 101 ) 
//        {
//            $filename = "nok";
//        }
        $mockjson = file_get_contents( __DIR__ . '/mockdata/' . $filename . '.json' );
                
        return new Suggestion( $mockjson );
    }
}