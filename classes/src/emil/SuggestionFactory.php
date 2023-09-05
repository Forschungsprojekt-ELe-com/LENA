<?php

class SuggestionFactory {
    
    /**
     * 
     * @var int
     */
    protected $userId;
    
    /**
     * 
     * @var string
     */
    protected $userUrl;
    
    public function __construct( $userId = 0, $userUrl = "" ) {
        $this->userId  = $userId;
        $this->userUrl = $userUrl;
    }
    
    
    public function execute() {        
//        $temp = '{}';
        $emil = new EmilClient( $this->userId );
        $temp = $emil->execute();        
        return new Suggestion( $temp );
    }
}