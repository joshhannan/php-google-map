Google Maps API Plugin
==============

Simple PHP include for Google Maps.

Google Maps API Plugin<br/>
Author:  Josh Hannan<br/>
Description:<br/>
&nbsp;&nbsp;&nbsp;&nbsp;This plugin is a simple PHP include in the header.  Dependent on variables that are specified, calculates and finds #google-map and places in that div.  For multiple maps, the div id would be #google-map-1, #google-map-2, etc.
  
&nbsp;&nbsp;&nbsp;&nbsp;For directions, the div that needs to be specified is #g-directions.  Also, include a text input and a submit button with the following code where you want to display your directions:
  
&nbsp;&nbsp;&nbsp;&nbsp;If multiple $locations, specify by placing the 'lat,longs' into an array, as shown below.

  <form>
    <input type="text" id="start_address" />
    <input type="submit" onclick="calcRoute(); return false;" value="" />
  </form>

  Variables are:
<pre>
    $location = 'latitude,longitude';
    $location = array(
      'latitude,longitude',
      'latitude,longitude'
    );
    $marker_url = 'custom_image_marker_url.jpg';
    $zoom = '10';
    $directions = 'yes';
    $styles = 'yes';
</pre>
