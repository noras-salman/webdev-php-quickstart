<?php

class Request{

    function post($url,$data,$is_json=true,$headers=[]){

        if($is_json){
            $data=json_encode( $data );
            if(!in_array('Content-Type: application/json',$headers)){
                array_push($headers,'Content-Type: application/json');
            }
        }
    
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $data );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $result;
    
    }
}

?>