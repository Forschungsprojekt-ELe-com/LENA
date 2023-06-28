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
     * @param string $json
     */
    public function __construct( $json ) {
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
        if( isset( $result->recommend ) ) {
            $recommendList = $result->recommend;
            foreach( $recommendList as $recommend ) {
                $this->recommend[] = 0 + $recommend;
            }
        }
        if( isset( $result->data ) ) {
            $data = $result->data;
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
        return $this->metaStatus;
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
}