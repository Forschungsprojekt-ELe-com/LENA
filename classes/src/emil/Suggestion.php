<?php


class Suggestion {

    /**
     * 
     * @var bool
     */
    protected bool $metaStatus;
    
    /**
     * 
     * @var string
     */
    protected string $metaReason;
    
    /**
     * 
     * @var string
     */
    protected string $metaTransmitted;
    
    /**
     * 
     * @var int[]
     */
    protected array $recommend;
    
    /**
     * 
     * @var string
     */
    protected string $reason;
    
    /**
     * 
     * @var string
     */
    protected string $json;
    
    /**
     * 
     * @param string $json
     */
    public function __construct( string $json ) {
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
            if( isset( $meta->transmitted_at ) ) {
                $this->metaTransmitted = '' . $meta->transmitted_at;
            }
        }
        
        $this->recommend = array();
        $this->reason     = '';        
        if( isset( $result->data ) ) {
            $data = $result->data;
            
            if( isset( $data->MLE_ref_id ) ) {
                $recommendList = $data->MLE_ref_id;
                foreach( $recommendList as $id => $recommend ) {
                    $this->recommend[ 0 + $id ] = '' . $recommend;
                }
            }
            
            if( isset( $data->recommendation_reason ) ) {
                $this->reason = '' . $data->recommendation_reason;
            }
        }
    }
    
    /**
     * 
     * @return bool
     */
    public function isOk(): bool {
        return ( count( $this->recommend ) > 0 );
//        return ( $this->metaStatus == 'OK' );
    }

    /**
     * 
     * @return string
     */
    public function getMetaReason(): string {
        return $this->metaReason;
    }

    /**
     * 
     * @return string
     */
    public function getMetaTransmitted(): string {
        return $this->metaTransmitted;
    }


    /**
     * 
     * @return int[]
     */
    public function getRecommend(): array {
        return $this->recommend;
    }

    /**
     * 
     * @return string
     */
    public function getReason(): string {
        return $this->reason;
    }    
    
    /**
     * 
     * @return string
     */
    public function getJson(): string {
        return $this->json;
    }
}