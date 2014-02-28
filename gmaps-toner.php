<?php
/*
   Google Maps API Plugin
   Author:  Josh Hannan
   Description:
      This plugin is a simple PHP include in the header.  Dependent on variables that are specified, calculates and finds #google-map and places in that div.  For directions, the div that needs to be specified is #g-directions.  Also, include a text input and a submit button with the following code where you want to display your directions:

      <form>

         <input type="text" id="start_address" />
         <input type="submit" onclick="calcRoute(); return false;" value="" />

      </form>

      Variables are:

         $location = 'latitude,longitude';
         $marker_url = 'custom_image_marker_url.jpg';
         $zoom = '10';
         $directions = 'yes';
         $styles = 'yes';
*/

/**
 * @var $location (string)
 * @var $marker_url (string)
 * @var $zoom (string)
 * @var $directions (string)
 * @var $styles (string)
 */

if( $location != '' ) :

   if(!isset($zoom) || $zoom == '' ) :
      $zoom = '10';
   endif;

   if(!isset($marker_url)) :
      $marker_url = '';
   endif;

   if(!isset($directions)) :
      $directions = '';
   endif;

   if(!isset($styles)) :
      $styles = '';
   endif;


   echo "<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'></script>";

   echo "<script type='text/javascript'>

      var directionsDisplay;
      var directionsService = new google.maps.DirectionsService();";

      if(is_array($location) ) :

         $i = 0;

         foreach( $location as $coordinate ) :
            $i++;
            echo "\rvar map_" . $i . ";\r";
         endforeach;

      else :

         echo "var map;";

      endif;

      if( $styles == 'yes' ) :

         echo "var styles = [
            {
               featureType: 'all',
               elementType: 'labels.text.fill',
               stylers: [
                  { color: '#2B261C' }
               ]
            },{
               featureType: 'water',
               elementType: 'geometry.fill',
               stylers: [
                  {color: '#326577' }
               ]
            },{
                 featureType: 'landscape.natural',
                 elementType: 'geometry.fill',
                 stylers: [
                     { color: '#8F9659' }
                 ]
             },{
                 featureType: 'poi.park',
                 elementType: 'geometry.fill',
                 stylers: [
                     { color: '#8F9659' }
                 ]
             },{
                 featureType: 'landscape.man_made',
                 elementType: 'all',
                 stylers: [
                     { hue: '#A69A75' },
                     { lightness: -25 }
                 ]
             },{
                featureType: 'road.arterial',
                elementType: 'geometry',
                stylers: [
                    { color: '#B5AB88' }
                ]
            },{
                featureType: 'road.local',
                elementType: 'geometry',
                stylers: [
                    { color: '#B5AB88' }
                ]
            },{
                featureType: 'road.local',
                elementType: 'geometry.fill',
                stylers: [
                    { hue: '#B5AB88' }
                ]
            },{
                featureType: 'road.highway',
                elementType: 'geometry.fill',
                stylers: [
                    { hue: '#B5AB88' },
                    { saturation: 100 },
                    { lightness: 25 }
                ]
            },{
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry.fill',
                stylers: [
                    { hue: '#B5AB88' },
                    { saturation: 100 },
                    { lightness: 25 }
                ]
            },{
               featureType: 'transit.station',
               elementType: 'labels.text.fill',
               stylers: [
                  { color: '#397588' }
               ]
            }
         ];";

      endif;

      echo "function initialize() {

         directionsDisplay = new google.maps.DirectionsRenderer();";

            if(is_array($location) ) :

               $i = 0;

               foreach( $location as $coordinate ) :
                  $i++;
                  echo "\r\nvar coordinates_".$i." = new google.maps.LatLng( " . $coordinate . " );";
                  echo "var mapOptions_".$i." = {
                     zoom: " . $zoom . ",";

                     if( $styles == 'yes' ) :
                        echo "
                        disableDefaultUI: true,
                        styles: styles,";
                     endif;

                  echo "mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                     },
                     center: coordinates_".$i.",
                     mapTypeId: google.maps.MapTypeId.ROADMAP
                  };";

                  echo "map_".$i." = new google.maps.Map(document.getElementById('google-map-".$i."'), mapOptions_".$i.");";

                  echo "var marker = new google.maps.Marker({
                     position: coordinates_" . $i . ",
                     map: map_".$i.",
                     title: 'Toner Cable Equipment, Inc.'
                  });";
               endforeach;

            else :

               echo "var coordinates = new google.maps.LatLng( " . $location . " );";

               echo "var mapOptions = {
                  zoom: " . $zoom . ",";

                  if( $styles == 'yes' ) :
                     echo "
                  disableDefaultUI: true,
                  styles: styles,";
                  endif;

               echo "mapTypeControlOptions: {
                     style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                  },
                  center: coordinates,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
               };";

               echo "map = new google.maps.Map(document.getElementById('google-map'), mapOptions);

                  directionsDisplay.setMap(map);";

               echo "var myLatLng = new google.maps.LatLng(" . $location . ");
               var jewelMarker = new google.maps.Marker({
                  position: myLatLng,
                  map: map";
                  if( $marker_url != '' ) :
                     echo ", icon: image";
                  endif;

               echo "});";

               echo "directionsDisplay.setPanel(document.getElementById('g-directions'));";

               if( $marker_url != '' ) :

                  echo "<br />var image = '" . $marker_url;

               endif;

            endif;

      echo "};";


      if( $directions == 'yes' ) :

         echo "function calcRoute() {
            var start = document.getElementById('start_address').value;
            var end = '" . $location . "';
            var request = {
               origin: start,
               destination: end,
               travelMode: google.maps.DirectionsTravelMode.DRIVING
            };

            directionsService.route(request, function(response, status) {

               if (status == google.maps.DirectionsStatus.OK) {
                  directionsDisplay.setDirections(response);
               }

            });

         }";

      endif;

      echo "google.maps.event.addDomListener(window, 'load', initialize);";

   echo "</script>";

endif;
