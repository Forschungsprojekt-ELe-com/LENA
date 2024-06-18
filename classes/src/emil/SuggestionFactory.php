<?php

class SuggestionFactory {
    
    /**
     * 
     * @var int
     */
    protected int $userId;
    
    /**
     * 
     * @var string
     */
    protected string $userUrl;
    
    public function __construct( int $userId = 0, string $userUrl = "" ) {
        $this->userId  = $userId;
        $this->userUrl = $userUrl;
    }
    
    
    public function execute(): Suggestion {
//        $temp = '{}';
        $emil = new EmilClient( $this->userId );
        $temp = $emil->execute();        
        return new Suggestion( $temp );
    }
}