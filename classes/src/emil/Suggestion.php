<?php


class Suggestion {

    /**
     * 
     * @var bool
     */
    protected $metaStatus;
    
    /**
     * 
     * @var string
     */
    protected $metaReason;
    
    /**
     * 
     * @var string
     */
    protected $metaTransmitted;
    
    /**
     * 
     * @var int[]
     */
    protected $recommend;
    
    /**
     * 
     * @var string
     */
    protected $reason;
    
    /**
     * 
     * @var string
     */
    protected $json;
    
    /**
     * 
     * @param string $json
     */
    public function __construct( $json ) {
        $this->json = $json;
        $result = json_decode( $json );
        
        $this->metaStatus      = false;
        $this->metaReason      = '';
        $this->metaTransmitted = '';         
        if( isset( $result->meta ) ) {
            $meta = $result->meta;
            if( isset( $meta->status ) ) {
                if( '' . $meta->status == 'OK' ) {
                    $this->metaStatus = true;
                }
            }
            if( isset( $meta->reason ) ) {
                $this->metaReason = '' . $meta->reason;
            }
            if( isset( $meta->transmitted ) ) {
                $this->metaTransmitted = '' . $meta->transmitted;
            }
        }
        
        $this->recommend = array();
        $this->reason     = '';        
        if( isset( $result->data ) ) {
            $data = $result->data;
            
            if( isset( $data->recommend ) ) {
                $recommendList = $data->recommend;
                foreach( $recommendList as $id => $recommend ) {
                    $this->recommend[ 0 + $id ] = '' . $recommend;
                }
            }
            
            if( isset( $data->reason ) ) {
                $this->reason = '' . $data->reason;
            }
        }
    }
    
    /**
     * 
     * @return bool
     */
    public function isOk() {
        return ( $this->metaStatus == 'OK' );
    }

    /**
     * 
     * @return string
     */
    public function getMetaReason() {
        return $this->metaReason;
    }

    /**
     * 
     * @return string
     */
    public function getMetaTransmitted() {
        return $this->metaTransmitted;
    }


    /**
     * 
     * @return int[]
     */
    public function getRecommend() {
        return $this->recommend;
    }

    /**
     * 
     * @return string
     */
    public function getReason() {
        return $this->reason;
    }    
    
    /**
     * 
     * @return string
     */
    public function getJson() {
        return $this->json;
    }
}