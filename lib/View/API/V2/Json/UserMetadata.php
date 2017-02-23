<?php
/**
 * Created by PhpStorm.
 * User: fregini
 * Date: 23/02/2017
 * Time: 13:52
 */

namespace API\V2\Json;


use Users\MetadataStruct;

class UserMetadata {

    /**
     * @param $collection MetadataStruct[]
     *
     * @return array
     */
    public static function renderMetadataCollection( $collection ) {
        $out = array() ;

        $returnable = array('gplus_picture');

        foreach( $collection as $metadata ) {
            if ( in_array($metadata->key, $returnable ) ) {
                $out[ $metadata->key ] = $metadata->value ;
            }
        }

        return $out;

    }


}