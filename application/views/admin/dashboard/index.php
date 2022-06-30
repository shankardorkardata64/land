<?php
/****************************** */
//https://gist.github.com/graydon/11198540
//https://simplemaps.com/data/at-cities

$base_url=base_url();
$setting=setting();
$max_select=$setting['max_tile_rate_select'];
$zoom=19;
$cur='XEMXLINK';

$this->db->select('code');
$this->db->select('prize');
$this->db->where('sold',0);
$p=$this->db->get('landprize')->result_array();
$r=array();
foreach($p as $key=>$vl)
{
$r=array_merge($r,array($vl['code']=>$vl['prize']));
}
// print_r($r);
$pricelist=$r;
$pricelist1 =array('4VJPWHRH+5V'=>5,'4VJPWHRH+4V'=>4,'4VJPWHRH+3V'=>3,'4VJPWHRH+2W'=>10,'4VJPWHRH+3W'=>42,'4VJPWHRH+2V'=>10);


//{north: 9.47996951665,south:  46.4318173285,west: 16.9796667823,east: 49.0390742051}


$this->db->select('code');
$this->db->select('prize');
$this->db->where('sold',1);
$p=$this->db->get('landprize')->result_array();
$r=array();
foreach($p as $key=>$vl)
{
$r=array_merge($r,array($vl['code']));
}
// print_r($r);
$restricted_code=$r;


$json_array=array('north'=>-34.36,'south'=>-47.35,'west'=>166.28,'east'=>175);
/****************************** */
?>
<script>
// const NEW_ZEALAND_BOUNDS = '<?=json_encode($json_array)?>';

//{north: -34.36,south: -47.35,west: 166.28,east: -175.81}
const NEW_ZEALAND_BOUNDS = <?=$setting['BOUNDS_LIMIT'];?>;
const AUCKLAND = <?=$setting['map_center_lat_long'];?>;

var buytilelimit=<?=$max_select?>;
var cur='<?=$cur?>';
var restricted_code=Object.values(<?=json_encode($restricted_code)?>);

var plist=<?=json_encode($pricelist)?>;
var pricelist=Object.keys(plist);
</script>

<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <script src="https://maps.googleapis.com/maps/api/js?key=<?=$setting['mapkey'];?>&libraries=geometry"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/adminmap/openlocationcode.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/adminmap/examples.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <link href='<?=base_url()?>assets/adminmap/examples.css' rel='stylesheet' type='text/css'>


	<!--start page wrapper -->
		<div class="pagse-wrapper">
			<div class="page-content">
			
				<div class="row">

					<div class="col-xl-8 mx-autos">
						<h6 class="text-uppercase">Set Prices for Virtual Land </h6>
								<div id="simple-map" class="gmaps"></div>
					</div>
          <div class="col-xl-4 mx-asuto">
          <div id="messageBox">
      <div id="message_header"><h4>Please select Land with Click </h4></div>
      <div id="other_msg"></div>
      <div id="clear"></div>
      <div id="form_container"></div>
    </div>

    <div id="messageBoxright">
    <div id="limit_error"></div>
      <div id="message_header1"></div>
      
     
      
      <div id="clear1">
      <form method='post' id="buyform" action='<?=base_url('place-order')?>'>
      <input type='hidden' name='amount' id='amount'>
      <input type='hidden' name='currency' id='currency' value='XEMXLINK'>
      <input type='hidden' name='area' id='area'>
      <!-- <button class="btn btn-primary"  id='buy_button'  style="float:left;displasy:none" onclick="buy();">Confirm order</button> -->
      </form>
      <button class="btn btn-primary"  style="float:right;" onclick="clerpo();">Clear Selection</button>
      </div>
      
      <div id="form_container1"></div>
       </div>

          </div>
					
        
        </div>
					
					</div>
				</div>

    
  

				<!--end row-->
			</div>
		</div>
		<!--end page wrapper -->
	
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script type="text/javascript">
    var map;
    var geocoder;
    var placeMarker;
    var olcCode;
    var codeFragment;
    var localityAddress;
    var markers = [];
    $('#buy_button').hide();

var total=0;


function sold(map)
{
  var markers11=[];
  fill = '#03f537';


for (var key in restricted_code) 
{
   var value= restricted_code[key];
   var code=value.toString();
   var codeArea = OpenLocationCode.decode(code);
   var sw = new google.maps.LatLng(codeArea.latitudeLo, codeArea.longitudeLo);
   var ne = new google.maps.LatLng(codeArea.latitudeHi, codeArea.longitudeHi);
   var bounds = new google.maps.LatLngBounds(sw, ne);
   var image ='sdfsd';
   var current = new google.maps.LatLng(codeArea.latitudeCenter, codeArea.longitudeCenter);
   markers11.push(new google.maps.Marker({
        map: map,
        position: current,
        title: code,
        label:  {text: 'SOLD', color:"white", className: "labels1"},
        icon: image,
        
        labelClass: "labels1",
        optimized: true
    }));

      var rectangle = new google.maps.Rectangle({
      bounds: bounds,
      strokeColor: 'red',
      strokeOpacity: 1.0,
      strokeWeight: 2,
      fillColor: fill,
      fillOpacity: 0.3,
      clickable: false,
      map: map,
      content:'sdsdsd'
      });
     // olygons.push(rectangle);

    }


}


function buy()
{
  $("#buyform").submit();
}


 function othermsg(text)
 {
    var messageHeader = document.getElementById('other_msg');
    messageHeader.innerHTML = text;

 }

 var codearray=[];
 var prizearray =[]; 
 function  clerpo()
 {
    clearPolygons();
    codearray=prizearray=[];
    var messageHeader = document.getElementById('message_header');
    messageHeader.innerHTML = '<h4>Please Select the Land by clicking on the map</h4>';
     othermsg('');
    //var markers = [];
    for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];



var messageHeader = document.getElementById('message_header1');
messageHeader.innerHTML = '';
}


function allsw(map)
{
  var markers1=[];
  fill = '#0d6efd';


for (var key in plist) 
{
    var value = plist[key];
    
    console.log(key, value);


  var code=key.toString();
  var cost=value.toString()+'\n';
  var codeArea = OpenLocationCode.decode(code);
  var sw = new google.maps.LatLng(codeArea.latitudeLo, codeArea.longitudeLo);
  var ne = new google.maps.LatLng(codeArea.latitudeHi, codeArea.longitudeHi);
  var bounds = new google.maps.LatLngBounds(sw, ne);
  var image ='sdfsd';
    var current = new google.maps.LatLng(codeArea.latitudeCenter, codeArea.longitudeCenter);
    markers1.push(new google.maps.Marker({
        map: map,
        position: current,
        title: code,
        // label:  {text: code, className: "labels1"},
        label:  {text: cost, className: "labels1",color:"white"},
        icon: image,
        
        labelClass: "labels1",
        optimized: true
    }));

      var rectangle = new google.maps.Rectangle({
      bounds: bounds,
      strokeColor: 'white',
      strokeOpacity: 1.0,
      strokeWeight: 2,
      fillColor: fill,
      fillOpacity: 0.3,
      clickable: false,
      map: map,
      content:'sdsdsd'
      });
     // olygons.push(rectangle);

    }


}

function drawsqual(map, code, fill) 
{
    if (typeof fill == 'undefined') 
    {
      fill = '#e51c23';
    }
    fill = '#03f537';
  var codeArea = OpenLocationCode.decode(code);
  var sw = new google.maps.LatLng(codeArea.latitudeLo, codeArea.longitudeLo);
  var ne = new google.maps.LatLng(codeArea.latitudeHi, codeArea.longitudeHi);
  var bounds = new google.maps.LatLngBounds(sw, ne);
  var index1 = pricelist.indexOf(code);
  var index = codearray.indexOf(code);
  if(index1!==-1)
  {
   // codearray.splice(index1, 1);
    //prizearray.splice(index1,1);
  //  othermsg('<h4 style="color:red;">Area Restircted OR Price allerady Set</h4>');
    //return false;
  }
  if(index!==-1)
  {
    codearray.splice(index, 1);
    prizearray.splice(index,1);
    return false;
  }
  else
  {
    var image ='sdfsd';
    var current = new google.maps.LatLng(codeArea.latitudeCenter, codeArea.longitudeCenter);
    markers.push(new google.maps.Marker({
        map: map,
        position: current,
        title: code,
        label:  {text: code, className: "labels1"},
        icon: image,
        labelClass: "labels1",
        optimized: true
    }));
      codearray.push(code);
      var rectangle = new google.maps.Rectangle({
      bounds: bounds,
      strokeColor: '#fff',
      strokeOpacity: 1.0,
      strokeWeight: 2,
      fillColor: fill,
      fillOpacity: 0.3,
      clickable: false,
      map: map,
      content:'sdsdsd'
      });
  return rectangle;  
  }
}


       function mapClickHandler(event)
       {
       var messageHeader = document.getElementById('message_header');
       var element=codearray.length+1;
      



       if(buytilelimit<element)
       {
        $("#message_header").html('<h4 style="color:red;">You can select maximum only '+buytilelimit+' tiles</h4>');
        return false;   
       }
       else
       {
        olcCode = OpenLocationCode.encode(event.latLng.lat(), event.latLng.lng());





        var index_restricted_code = restricted_code.indexOf(olcCode);
        if(index_restricted_code!=-1)
       {
        othermsg('<h4 style="color:red;">You can\'t Buy this land. this land is allready buy or restriscted</h4>');
        return false;
       }
       else
       {
        othermsg('');
       }
       
      // zoomTo(olcCode);
       
       var drq=drawsqual(map, olcCode);
       if(drq!=false)
       {
       polygons.push(drq);
       if (codearray.length === 0) 
       {
       messageHeader.innerHTML = '<h4>Please Select the Land by clicking on the map</h4>';
       }
       else
       {

        $.ajax({ //Process the form using $.ajax()
            type      : 'POST', //Method type
            url       : '<?=base_url('ajaxadminsetrate')?>', //Your form processing file URL
            data      : {code:olcCode,codearray:codearray}, //Forms name
            dataType  : 'json',
            success   : function(response) 
            {
             $("#message_header1").html(response.table);
           
              if(response.total!='')
              {
                $('#buy_button').show();
                $("#amount").val(response.total);
                $("#area").val(response.list);
              }
             //$("#message_header").html(''); 
            //$('#message_header').css('display','none');

             if(response.error!='')
              {  $('#buy_button').hide();
               
                $("#message_header1").html(response.error);
                $("#message_header").html(''); 
                $('#message_header').css('display','none');
              }
              if(response.limit_error!='')
              {  $('#buy_button').hide();
                $("#limit_error").html(response.error);
                $("#message_header").html(''); 
                $('#message_header').css('display','none');
              }
            }
          });

       }
       }
       else
       {
       messageHeader.innerHTML = '<h4>You have selected this  tiles allready</h4>';
       }

      // othermsg(prizearray);
    }


      // While working through this, don't display the form.
      document.getElementById('form_container').style.display = 'none';
    }

    /**
      * Using Google Maps API, do a reverse geocode on the center of the OLC
      * code. NB runs async.
      */
    function reverseGeocodeOLC() {
      var codeArea = OpenLocationCode.decode(olcCode);

      // Call the geocoder to shorten the code.
      geocodeLatLng(codeArea.latitudeCenter, codeArea.longitudeCenter, olcCode,
          // Callback function to geocode the address and shorten the code.
          function(code, address) {
              localityAddress = address;
              var messageHeader = document.getElementById('message_header');
              
          });
    }


    



    /**
      * Geocodes the address to a point and shortens the OLC code.
      */
    function shortenOLCbyAddress() {
      geocodeAddress(olcCode, localityAddress,
          function(code, address, lat, lng) {
            /* Here is where the magic happens. We have the full code and we
             * have the lat,lng from geocoding the address information.
             * Using the OpenLocationCode.shortenBy4() function, we can try to
             * shorten the OLC code using this location.
             */
            var shortCode = OpenLocationCode.shorten(code, lat, lng);
            var messageHeader = document.getElementById('message_header');
            if (shortCode != olcCode) {
              messageHeader.innerHTML = '';
              document.getElementById('code_fragment').value = shortCode;
              document.getElementById('address').value = address;
            } else {
              messageHeader.innerHTML = '';
            }
            document.getElementById('form_container').style.display = 'block';
          });
    }

    /**
      * Check the entered code is valid, and display an appropriate message.
      */
    function processCode() {
      clearPolygons();
      codeFragment = document.getElementById('code_fragment').value;
      address = document.getElementById('address').value;
      var messageHeader = document.getElementById('message_header');
      if (codeFragment.length > 7) {
        messageHeader.innerHTML = '<p>The code, <em>' + codeFragment + '</em>, ' +
            'is too long. Short codes are a maximum of seven characters long.</p>';
        return;
      }
      if (!OpenLocationCode.isValid(codeFragment)) {
        messageHeader.innerHTML = '<p>The code, <em>' + codeFragment + '</em>, ' +
            'is not a valid part of an OLC code.</p>';
        return;
      }
      document.getElementById('form_container').style.display = 'none';
      messageHeader.innerHTML = '<p>The first step is to work out the location ' +
          'of the address. To do this, we are using the ' +
          '<a href="https://developers.google.com/maps/documentation/javascript/">Google Maps API</a>' +
          ' geocoding service.</p>' +
          '<p>Once we have the location, we can use that to recover the original OLC code.</p>' +
          '<button class="button" style="float:right;" onclick="geocodeEnteredAddress();">' +
          '<span class="button_label">Next</span></button>';
    }

    function geocodeEnteredAddress() {
      document.getElementById('form_container').style.display = 'block';
      var codeFragment = document.getElementById('code_fragment').value;
      var address = document.getElementById('address').value;
      var messageHeader = document.getElementById('message_header');
      geocodeAddress(codeFragment, address,
          function(codeFragment, address, lat, lng) {
            if (placeMarker != null) {
              placeMarker.setMap(null);
            }
            placeMarker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: map,
                title: address
            });

            try {
              var fullCode = OpenLocationCode.recoverNearest(
                  codeFragment, lat, lng);
            } catch (e) {
              messageHeader.innerHTML = '<p>The code, <em>' + codeFragment + '</em>, ' +
                  'is not a valid part of an OLC code.</p>';
              return;
            }

            zoomTo(fullCode);
            polygons.push(displayOlcArea(map, fullCode));

            messageHeader.innerHTML = '<p>The location that the address ' +
                'information geocodes to is indicated with a marker (you ' +
                'might have to zoom out to see it). Using that location ' +
                'the OLC code can be extended to <em>' + fullCode + '</em>.</p>' +
                '<p>It is possible that you can edit the address to be ' +
                'shorter, and still be able to recover the original code.</p>' +
                '<p>You might even be able to find a better, closer address. ' +
                'Note that this doesn\'t have to be a town or city, it could be ' +
                'a prominent landmark or natural feature.</p>';
          });
    }
  </script>

  <script type="text/javascript">

google.maps.event.addDomListener(window, 'load', function() {

      map = new google.maps.Map(
          document.getElementById('simple-map'),
          {
       center:AUCKLAND,
       zoom: <?=$zoom?>,
       fullscreenControl: false,
       zoomControlOptions: {
       position: google.maps.ControlPosition.LEFT_TOP
      },

      restriction: {
      latLngBounds: NEW_ZEALAND_BOUNDS,
      strictBounds: false,
    },
       mapTypeId: google.maps.MapTypeId.SATELLITE,
       scaleControl: true


        });
      map.setTilt(0); var zoomopt = { minZoom: <?=$zoom-1?>, maxZoom: <?=$zoom+2?> }; map.setOptions(zoomopt);
   
     // OlcRefinedGrid(map);
      // Add an event listener to display OLC boxes around clicks.
      google.maps.event.addListener(map, 'click', mapClickHandler);
      // Get the geocoder.
      geocoder = new google.maps.Geocoder();

      allsw(map);
	  sold(map);
    });
  </script>