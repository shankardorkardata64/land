<style>
    /* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
#map {
  height: 100%;
}
/* Optional: Makes the sample page fill the window. */
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}
</style>

<input size="100" id='acf-field_5e59146d57037' value='[{"lat":17.899958518009452,"lng":75.01716107631769},{"lat":17.899687965980476,"lng":75.01726300026026},{"lat":17.89972114691189,"lng":75.01738638187494},{"lat":17.899786232567017,"lng":75.01736224199381},{"lat":17.899853870575484,"lng":75.01733810211267},{"lat":17.899921508558148,"lng":75.01730859781351},{"lat":17.900004460765846,"lng":75.01727372909632}]' />



<div id="map"></div>
<!-- Replace the value of the key parameter with your own API key. -->
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBm46Na2pfh0csGP2bocMljHJ9q8xRbnk8&callback=initMap">
</script>



<script>
    var map;
var bounds;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 5,
    center: {
      lat: 24.886,
      lng: -70.268
    },
    mapTypeId: 'terrain'
  });
  bounds = new google.maps.LatLngBounds();
  polytest = document.getElementById('acf-field_5e59146d57037').value;
  console.log(polytest);
  polytest =JSON.parse(polytest);
  for (var i=0; i<polytest.length; i++) {
    bounds.extend(polytest[i])
  }
  map.fitBounds(bounds);
  addPolygon(polytest);
}

function addPolygon(polytest) {
  polytototo = new google.maps.Polygon({
    path: polytest,
    map: map,
    draggable: false,
    geodesic:true,
    editable: false,
    label:'fdsdfsdf'
  });
  polytototo.setMap(map);
}

    </script>