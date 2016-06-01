<?php 

class RandomKey {
	
	public function randomKey() {
    	$key = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" , mt_rand( 0 ,20 ) ,1 ).substr( md5( time() ), 1);
        return $key;
    }

}

