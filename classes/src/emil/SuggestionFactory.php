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
    
    public function __construct( int $userId = 0, string $userUrl = "" ): void {
        $this->userId  = $userId;
        $this->userUrl = $userUrl;
    }
    
    
    public function execute(): void {        
//        $temp = '{}';
        $emil = new EmilClient( $this->userId );
        $temp = $emil->execute();        
        return new Suggestion( $temp );
    }
}