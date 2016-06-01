<?php


class TimeZone {
    
    public function converToTz($time,$toTz) {   
        
        $date = new DateTime($time, new DateTimeZone($toTz));
        $date->setTimezone(new DateTimeZone('Europe/London'));
        $time= $date->format('Y-m-d H:i:s');
        return $time;

    }

    public function convertDateToTzUser($timeDB,$timeZoneUser) {

    	$date = new DateTime($timeDB, new DateTimeZone('Europe/London'));
        $date->setTimezone(new DateTimeZone($timeZoneUser));
        $time= $date->format('Y-m-d H:i:s');
        return $time;

   	}

}