<?php

class AccessToken {

    const LOCATION = __DIR__ . '/../../../.lenacache/api/';
    
    const NUMBER_OF_DAYS = 7;
    
    /**
     * 
     * @var int
     */
    protected int $userId;
    
    /**
     * 
     * @var string
     */
    protected string $userHash;
    
    /**
     * 
     * @var string
     */
    protected string $resultJson;
    
    /**
     * 
     * @var string
     */
    protected string $token;
    
    /**
     * 
     * @var int
     */
    protected int $usecase;
    
    /**
     * 
     * @param int $user_id
     */
    public function __construct( int $user_id = 0, int $usecase = 0 ): void {
        $this->userId     = $user_id;
        $this->usecase    = $usecase;
        
        $this->userHash   = $this->userId;
        $this->resultJson = '{}';
        $this->token      = '';        
    }
    
    /**
     * 
     * @return string
     */
    public function createToken(): string {        
        $filename = '';
        do {
            $filename = md5( 'carstenSuperHAXX0r' . $this->userId . time() . rand( 1, 10000 ) );
        } while( is_file( AccessToken::LOCATION . $filename . '.php' ) );
        
        $out = '<?php' . PHP_EOL
                . '$LENA_USER=' . $this->userId . ';' . PHP_EOL
                . '$LENA_HASH="' . $this->userHash . '";' . PHP_EOL
                . '$LENA_UC="' . $this->usecase . '";' . PHP_EOL
                . '$LENA_RESULT="{}";' . PHP_EOL
        ;
        file_put_contents( AccessToken::LOCATION . $filename . '.php', $out );
        return $filename;
    }
    
    /**
     * 
     * @param string $token
     */
    public function destroyToken( string $token = '' ): void {        
        $temp = '';
        if( strlen( $token ) > 0 ) {
            $temp = $token;
        }
        if( 
            ( strlen( $temp ) == 0 )
            && ( strlen( $this->token ) > 0 )
        ) {
            $temp = $this->token;
        }
        
        $filename = AccessToken::LOCATION . $temp . '.php';
        if( 
            ( strlen( $temp ) > 0 ) 
            && ( is_file( $filename ) )
        ) {
            unlink( $filename );
        }
    }
    
    /**
     * 
     * @param string $token
     * @return boolean
     */
    public function evaluateToken( string $token ): bool {
        $filename = AccessToken::LOCATION . $token . '.php';
        if( is_file( $filename ) ) {
            include $filename;
            $this->userId     = $LENA_USER;
            $this->userHash   = $LENA_HASH;
            $this->resultJson = $LENA_RESULT;
            $this->usecase    = $LENA_UC;
            $this->token      = $token;
            return true;
        }           
        EmilLogger::log( 'wrong token:' . $token );
        return false;
    }
    
    /**
     * 
     * @return Suggestion
     */
    public function getSuggestion(): Suggestion {             
        if( $this->isEmptyResult() ) {
//            $suggestionFactory = new SuggestionFactoryMock( $this->userId, $this->userHash );
            $suggestionFactory = new SuggestionFactory( $this->userId, $this->userHash );
            $suggestion       = $suggestionFactory->execute();

            if( $suggestion->isOk() ) {
                $this->resultJson = $suggestion->getJson();

                $filename = AccessToken::LOCATION . $this->token . '.php';
                $contents = file_get_contents( $filename );
                $contents .= PHP_EOL 
                            . '$LENA_RESULT=\'' . $this->resultJson . '\';' . PHP_EOL
                ;
                file_put_contents( $filename, $contents );
            } else {
                EmilLogger::log( 'suggestion not ok for user:' . $this->userId . ': ' . print_r( $suggestion, true ) );
            }
            return $suggestion;
        }
        return new Suggestion( $this->resultJson );
    }
    
    /**
     * 
     * @return bool
     */
    public function isEmptyResult(): bool {
        return ( strlen( $this->resultJson ) <= 2 );
    }  
    
    /**
     * deletes all tokens, that are older than 7 days.
     */
    public function cleanUpOldTokens(): void {        
        $timestamp = time() - ( 60 * 60 * 24  * AccessToken::NUMBER_OF_DAYS );
                
        $dir = scandir( AccessToken::LOCATION );
        foreach( $dir as $filename ) {
            if( 
                ( $filename == '.' )
                || ( $filename == '..' )
            ) {
                continue ; 
            }
            if( ! is_file( $filename ) ) {
                continue ;
            }
            $filetime = ctime( AccessToken::LOCATION . $filename );
            if( $filetime < $timestamp ) {
                unlink( AccessToken::LOCATION . '/' . $filename ); 
            }
        }
    }
    
    
    /**
     * deletes all tokens
     */
    public function cleanUpTokens(): void {                                
        $dir = scandir( AccessToken::LOCATION );        
        foreach( $dir as $filename ) {
            echo AccessToken::LOCATION . $filename . PHP_EOL;
            if( 
                ( $filename == '.' )
                || ( $filename == '..' )
                || ( $filename == '.gitkeep' )
            ) {
                continue ; 
            }
            if( ! is_file( $filename ) ) {
                continue ;
            }            
            
            unlink( AccessToken::LOCATION . $filename );             
        }
    }
    
    /**
     * 
     * @return int
     */
    public function getUsecaseId(): int {
        return $this->usecase;
    }
}