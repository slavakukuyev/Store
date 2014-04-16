<?php

namespace Store\Service;

class GreetingService {

    public function getMyStoreGreeting() { 
        $suffix=", and welcome to MyStore!";
        $prefix="";
        if (date("H") <= 11) {
            $prefix= "Good morning"; 
        } else if (date("H") > 11 && date("H") < 17) {
            $prefix= "Hello"; 
        } else {
            $prefix= "Good evening"; 
        }
        return $prefix.$suffix;
    }

}

?>
