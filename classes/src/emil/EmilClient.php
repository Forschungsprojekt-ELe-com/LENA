<?php

class EmilClient {
    
    /**
     * 
     * @var int
     */
    protected $userId;
    
    /**
     * 
     * @var string
     */
    protected $url;
    
    public function __construct( $userId = 0 ) {
        $this->userId = $userId;
        $this->url    = 'https://elecom.codip.tu-dresden.de/aiservice/' . $this->userId . '/3';        
    }
    
    
    /**
     * 
     * @return string json-result
     */
    public function execute() {
        $out = '{}';
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
        
        return $out;
    }
}