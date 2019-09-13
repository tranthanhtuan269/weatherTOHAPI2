﻿<!DOCTYPE html>
<html>
<head>
    <title>Leaflet-OpenWeatherMap Example</title>
    <meta charset="utf-8" />
    <style>
        html, body, #map {
            height: 100%;
            margin: 0px;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/leaflet.css" />
    <link rel="stylesheet" href="css/leaflet-owm.css" />
    <link rel="stylesheet" href="css/iconLayers.css" />
</head>
<body>

    <div id="map"></div>
 
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
    <script src="js/leaflet-src.js"></script>
    <script src="js/leaflet-owm.js"></script>
    <script src="js/iconLayer.js"></script>
    <script>
        var providers = {};

        providers['OSM'] = {
            title: 'OSM',
            icon: 'img/layers-osm.png',
            layer: L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            })
        };

        providers['Satellite'] = {
            title: 'MODIS',
            icon: 'img/layers-satellite.png',
            layer: L.tileLayer('http://{s}.sat.owm.io/sql/{z}/{x}/{y}?select=b1,b4,b3&from=modis&order=last&color=modis&appid=d22d9a6a3ff2aa523d5917bbccc89211', {
                maxZoom: 18,
                attribution: '&copy; <a href="http://owm.io">VANE</a>'
            })
        };

        function returnAndroid() {
            if (typeof Android === 'undefined') {
              return;
            }else{
              return Android.returnAndroid('{"layouts" : [{"name" : "clouds"}, {"name" : "rain"}, {"name" : "pressure"}, {"name" : "wind"}, {"name" : "temp"}]}');
            }
        }
        returnAndroid();


    </script>
    <script>
        var lat = <?php if(isset($_GET["lat"])) { echo $_GET["lat"]; }else { echo "21.0012507"; }?>;
        var lng = <?php if(isset($_GET["lng"])) { echo $_GET["lng"]; }else { echo "105.7938183"; }?>;
        var zoom = <?php if(isset($_GET["z"])) { echo $_GET["z"]; }else { echo "8"; }?>;
        var map = L.map('map').setView([lat, lng], zoom);

        
        //http://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png?appid=d9cfe451d5a775abaf178aec4951b4b0

        var Temp = L.tileLayer('http://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png?appid=d22d9a6a3ff2aa523d5917bbccc89211', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://owm.io">VANE</a>',
            id: 'temp'
        }),

        Precipitation = L.tileLayer('http://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=d22d9a6a3ff2aa523d5917bbccc89211', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://owm.io">VANE</a>'
        }),

        Wind = L.tileLayer('http://tile.openweathermap.org/map/wind_new/{z}/{x}/{y}.png?appid=d22d9a6a3ff2aa523d5917bbccc89211', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://owm.io">VANE</a>'
        }),

        Pressure = L.tileLayer('http://tile.openweathermap.org/map/pressure_new/{z}/{x}/{y}.png?appid=d22d9a6a3ff2aa523d5917bbccc89211', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://owm.io">VANE</a>'
        }),


        Clouds = L.tileLayer('http://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png?appid=d22d9a6a3ff2aa523d5917bbccc89211', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://owm.io">VANE</a>'
        });

        var owm = new L.OWMLayer({key: 'b1b15e88fa797225412429c1c50c122a1'});
        map.addLayer(owm);

        // [{"name" : "clouds"}, {"name" : "rain"}, {"name" : "pressure"}, {"name" : "wind"}, {"name" : "temp"}]
        <?php
            if($_GET["overlay"] == "clouds"){
                echo "Clouds.addTo(map);";
            }else if($_GET["overlay"] == "rain"){
                echo "Precipitation.addTo(map);";
            }else if($_GET["overlay"] == "pressure"){
                echo "Pressure.addTo(map);";
            }else if($_GET["overlay"] == "wind"){
                echo "Wind.addTo(map);";
            }else{
                echo "Temp.addTo(map);";
            }    
        ?>

        var W = new Object();
        W.store = new Object();
        W.store.set = function(overlay){
            if(overlay == "clouds"){
                Clouds.addTo(map);
                Precipitation.onRemove(map);
                Pressure.onRemove(map);
                Wind.onRemove(map);
                Temp.onRemove(map);
            }else if(overlay == "rain"){
                Precipitation.addTo(map);
                Clouds.onRemove(map);
                Pressure.onRemove(map);
                Wind.onRemove(map);
                Temp.onRemove(map);
            }else if(overlay == "pressure"){
                Clouds.addTo(map);
                Precipitation.onRemove(map);
                Pressure.onRemove(map);
                Wind.onRemove(map);
                Temp.onRemove(map);
            }else if(overlay == "wind"){
                Wind.addTo(map);
                Clouds.onRemove(map);
                Precipitation.onRemove(map);
                Pressure.onRemove(map);
                Temp.onRemove(map);
            }else{
                Wind.onRemove(map);
                Clouds.onRemove(map);
                Precipitation.onRemove(map);
                Pressure.onRemove(map);
                Temp.addTo(map);
            }    
        }


        Clouds.onRemove(map);
        Temp.addTo(map);

        var overlays = {"Temperature": Temp, "Precipitation": Precipitation, "Clouds": Clouds, "Pressure": Pressure, "Wind": Wind};

        L.control.layers(overlays, null, {collapsed:false}).addTo(map);

        var layers = [];
            for (var providerId in providers) {
                layers.push(providers[providerId]);
            }

        L.control.iconLayers(layers).addTo(map);
    </script>


</body>
</html>