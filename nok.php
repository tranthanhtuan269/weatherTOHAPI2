<html>
  <head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
    <script src="https://api4.windy.com/assets/libBoot.js"></script>
    <style type="text/css">
        #windy {
            <?php
            if(isset($_GET["w"])){
                echo "width: " . $_GET["w"] . "px; ";
            }
            else{
                echo "width: 100%; ";
            }

            if(isset($_GET["h"])){
                echo "height: ". $_GET["h"] . "px; ";
            }
            else{
                echo "height: 100%; ";
            }
            ?>
        }
        #windy #bottom #progress-bar { display: none!important; }
        #mobile-ovr-select { display: none!important; }
        body{
            margin: 0!important;
        }
    </style>
  </head>
  <body>
    <div id="windy"></div>
    <script>
        const options = {

                    // Required: API key
                    key: 'GT9nQ1mvzxYKSAqGIkikE2KftW9zLrgv',

                    // Put additional console output
                    verbose: true,

                    // Optional: Initial state of the map
                    <?php
                    if(isset($_GET["lat"]))
                        echo "lat: ". $_GET["lat"] .",";
                    else
                        echo "lat: 50.4, ";
                    
                    if(isset($_GET["lng"]))
                        echo "lon: ". $_GET["lng"] .","; 
                    else
                        echo "lon: 14.3, ";
                    ?>
                    zoom: 5,
            }

        // Initialize Windy API
        windyInit( options, windyAPI => {
            // windyAPI is ready, and contain 'map', 'store',
            // 'picker' and other usefull stuff

            const { overlays, store } = windyAPI
            const { map } = windyAPI
            // .map is instance of Leaflet map

            // L.popup()
            //     .setLatLng([50.4, 14.3])
            //     .setContent("Hello World")
            //     .openOn( map );

            <?php
                if(isset($_GET["overlay"])){
                    echo "store.set('overlay', '".$_GET["overlay"]."'); \n";
                }

                if(isset($_GET["metric"])){
                    if($_GET["metric"] == "c" || $_GET["metric"] == "C"){
                        echo "overlays.temp.setMetric('°C');";
                    }else{
                        echo "overlays.temp.setMetric('°F');";
                    }
                }

                if(isset($_GET["metricWind"])){
                    if($_GET["metricWind"] == "ms"){
                        echo "overlays.wind.setMetric('m/s');";
                    }else if($_GET["metricWind"] == "kmh"){
                        echo "overlays.wind.setMetric('km/h');";
                    }else if($_GET["metricWind"] == "mph"){
                        echo "overlays.wind.setMetric('mph');";
                    }else if($_GET["metricWind"] == "bft"){
                        echo "overlays.wind.setMetric('bft');";
                    }else{
                        echo "overlays.wind.setMetric('kt');";
                    }
                }

                if(isset($_GET["metricPressure"])){
                    if($_GET["metricPressure"] == "hpa"){
                        echo "overlays.pressure.setMetric('hPa');";
                    }else if($_GET["metricPressure"] == "mmHg"){
                        echo "overlays.pressure.setMetric('mmHg');";
                    }else{
                        echo "overlays.pressure.setMetric('inHg');";
                    }
                }

                if(isset($_GET["metricClouds"])){
                    if($_GET["metricClouds"] == "mm"){
                        echo "overlays.clouds.setMetric('mm');";
                    }else{
                        echo "overlays.clouds.setMetric('in');";
                    }
                }

                if(isset($_GET["metricWaves"])){
                    if($_GET["metricWaves"] == "ft"){
                        echo "overlays.waves.setMetric('ft');";
                    }else{
                        echo "overlays.waves.setMetric('m');";
                    }
                }

                if(isset($_GET["metricRain"])){
                    if($_GET["metricRain"] == "in"){
                        echo "overlays.rain.setMetric('in');";
                    }else{
                        echo "overlays.rain.setMetric('mm');";
                    }
                }
            ?>
            map.off('click');
        })

        W.maps = new Map;
        W.maps.setView = function($lm){
		W.map.setView($lm);
        }
    </script>
  </body>
</html>


