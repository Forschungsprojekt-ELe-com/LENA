<?php

for( $i=1; $i<5; ++$i ) {
    $out = '<?php' . PHP_EOL
            . '$LENA_REF = array();' . PHP_EOL
            . '$LENA_OBJ = array();' . PHP_EOL
            . '$LENA_TITLES = array();' . PHP_EOL
    ;
    for( $id = 1; $id < 11; ++ $id ) {
        $ref_id = ( $i*100 ) + $id;        
        $out .= '$LENA_REF[ ' . $ref_id . ' ] = ' . $id . ';' . PHP_EOL;
        $out .= '$LENA_OBJ[ ' . $id . ' ] = ' . $ref_id . ';' . PHP_EOL;
        $out .= '$LENA_TITLES[ ' . $id . ' ] = "MLE-' . $id . '";' . PHP_EOL;
    }      
    file_put_contents( __DIR__ . '/../../.lenacache/' . $i . '.php', $out );
}

$out = '<?php' . PHP_EOL
        . '$LENA_PLAN = array();' . PHP_EOL
        . '$LENA_PLAN[ 1 ] = 201;' . PHP_EOL
        . '$LENA_PLAN[ 3 ] = 203;' . PHP_EOL
        . '$LENA_PLAN[ 5 ] = 205;' . PHP_EOL
        . '$LENA_PLAN[ 7 ] = 207;' . PHP_EOL
        . '$LENA_PLAN[ 9 ] = 209;' . PHP_EOL        
;
file_put_contents( __DIR__ . '/../../.lenacache/planned.php', $out );