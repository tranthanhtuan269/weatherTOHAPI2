<!DOCTYPE html>
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
        var currentOverlay = "temp";

        
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
        W.maps = new Object();
        W.maps.setView = function(latlng){
            window.location.href = "http://radar.tohapp.com/en/apiv2/tohWeather.php?lat="+latlng[0]+"&lng="+latlng[1]+"&z=8&overlay="+currentOverlay;
        }

        W.store.set = function(key, value){
            if(key == "overlay" && value == "clouds"){
                currentOverlay = "clouds";
                Clouds.removeTo(map);
                Precipitation.removeTo(map);
                Pressure.removeTo(map);
                Wind.removeTo(map);
                Temp.removeTo(map);

                Clouds.addTo(map);
            }else if(key == "overlay" && value == "rain"){
                currentOverlay = "rain";
                Clouds.removeTo(map);
                Precipitation.removeTo(map);
                Pressure.removeTo(map);
                Wind.removeTo(map);
                Temp.removeTo(map);

                Precipitation.addTo(map);
            }else if(key == "overlay" && value == "pressure"){
                currentOverlay = "pressure";
                Clouds.removeTo(map);
                Precipitation.removeTo(map);
                Pressure.removeTo(map);
                Wind.removeTo(map);
                Temp.removeTo(map);

                Pressure.addTo(map);
            }else if(key == "overlay" && value == "wind"){
                currentOverlay = "wind";
                Clouds.removeTo(map);
                Precipitation.removeTo(map);
                Pressure.removeTo(map);
                Wind.removeTo(map);
                Temp.removeTo(map);

                Wind.addTo(map);
            }else if(key == "overlay" && value == "temp"){
                currentOverlay = "temp";
                Clouds.removeTo(map);
                Precipitation.removeTo(map);
                Pressure.removeTo(map);
                Wind.removeTo(map);
                Temp.removeTo(map);

                Temp.addTo(map);
            }    
        }

        // setInterval(test2, 3000);

        function test(){
            var rand = Math.floor(Math.random() * 4) + 1;
            if(rand == 1){
                alert("temp");
                W.store.set("overlay", "temp");
            }else if(rand == 2){
                alert("wind");
                W.store.set("overlay", "wind");
            }else if(rand == 3){
                alert("pressure");
                W.store.set("overlay", "pressure");
            }else if(rand == 4){
                alert("rain");
                W.store.set("overlay", "rain");
            }else{
                alert("clouds");
                W.store.set("overlay", "clouds");
            }
        }

        function test2(){
            var rand = Math.floor(Math.random() * 4) + 1;
            alert(rand);
            if(rand == 1){
                W.maps.setView([21.0012507, 105.7938183]);
            }else if(rand == 2){
                W.maps.setView([-6.2297279, 106.6890855]);
            }else if(rand == 3){
                W.maps.setView([40.6971477, -74.2605596]);
            }else if(rand == 4){
                W.maps.setView([51.5283063, -0.3824692]);
            }
        }

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
