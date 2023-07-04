<?php

class AccessToken {
    
    /**
     * 
     * @var int
     */
    protected $userId;
    
    /**
     * 
     * @var string
     */
    protected $userHash;
    
    /**
     * 
     * @var string
     */
    protected $resultJson;
    
    /**
     * 
     * @var string
     */
    protected $token;
    
    /**
     * 
     * @param int $user_id
     */
    public function __construct( $user_id = 0 ) {
        $this->userId     = $user_id;
        $this->userHash   = $this->userId;
        $this->resultJson = '{}';
        $this->token      = '';
    }
    
    /**
     * 
     * @return string
     */
    public function createToken() {
        $location = __DIR__ . '/../../../.lenacache/api/';
        $filename = '';
        do {
            $filename = md5( 'carstenSuperHAXX0r' . $this->userId . time() . rand( 1, 10000 ) );
        } while( is_file( $location . $filename . '.php' ) );
        
        $out = '<?php' . PHP_EOL
                . '$LENA_USER=' . $this->userId . ';' . PHP_EOL
                . '$LENA_HASH="' . $this->userHash . '";' . PHP_EOL
                . '$LENA_RESULT="{}";' . PHP_EOL
        ;
        file_put_contents( $location . $filename . '.php', $out );
        return $filename;
    }
    
    /**
     * 
     * @param string $token
     * @return boolean
     */
    public function evaluateToken( $token ) {
        $filename = __DIR__ . '/../../../.lenacache/api/' . $token . '.php';
        if( is_file( $filename ) ) {
            include $filename;
            $this->userId     = $LENA_USER;
            $this->userHash   = $LENA_HASH;
            $this->resultJson = $LENA_RESULT;
            $this->token      = $token;
            return true;
        }           
        return false;
    }
    
    /**
     * 
     * @return Suggestion
     */
    public function getSuggestion() {        
        if( $this->isEmptyResult() ) {
            $suggestionFactory = new SuggestionFactoryMock( $this->userId, $this->userHash );
//            $suggestionFactory = new SuggestionFactory( $this->userId, $this->userHash );
            $suggestion       = $suggestionFactory->execute();
            
            $this->resultJson = $suggestion->getJson();

            $filename = __DIR__ . '/../../../.lenacache/api/' . $this->token . '.php';
            $contents = file_get_contents( $filename );
            $contents .= PHP_EOL 
                        . '$LENA_RESULT=\'' . $this->resultJson . '\';' . PHP_EOL
            ;
            file_put_contents( $filename, $contents );
            return $suggestion;
        }
        return new Suggestion( $this->resultJson );
    }
    
    /**
     * 
     * @return bool
     */
    public function isEmptyResult() {
        return ( strlen( $this->resultJson ) <= 2 );
    }    
}