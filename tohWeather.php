<?php 
    $arr = ['com.wftab.weather.forecast', 'com.wftab.weather.forecast.pro', 'com.tohsoft.weather.sunrise.sunset.gen2', 'com.tohsoft.weather.sunrise.sunset.gen2.pro'];
    if(isset($_GET["application_id"]) && in_array($_GET["application_id"], $arr)){
        $url = "http://45.79.69.97/index2.php?";
        foreach($_GET as $key => $value){
            $url .= $key . '=' . $value . '&';
        }
        $url = rtrim($url,'&');
        header("Location: " . $url);
    }else{
        $url = "http://radar.tohapp.com/en/radar-mobile?";
        foreach($_GET as $key => $value){
            $url .= $key . '=' . $value . '&';
        }
        $url = rtrim($url,'&');
        header("Location: " . $url);
    }
?>