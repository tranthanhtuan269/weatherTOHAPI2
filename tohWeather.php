<?php 
    $arr = ['com.wftab.weather.forecast', 'com.wftab.weather.forecast.pro'];
    if(isset($_GET["application_id"]) && in_array($_GET["application_id"], $arr)){
        $url = "http://45.79.69.97/index2.php?";
        foreach($_GET as $key => $value){
            $url .= $key . '=' . $value . '&';
        }
        $url = rtrim($url,'&');
        header("Location: " . $url);
    }else{
        $url = "http://radar.tohapp.com/en/radar-mobile2?";
        foreach($_GET as $key => $value){
            $url .= $key . '=' . $value . '&';
        }
        $url = rtrim($url,'&');
        header("Location: " . $url);
    }
?>