
<?php
$base_url="http://localhost/map2/";
$max_select=2;
$cur='XEMXLINK';
$pricelist =array('4VJPWHRH+5V'=>5,'4VJPWHRH+4V'=>4,'4VJPWHRH+3V'=>3,'4VJPWHRH+2W'=>10,'4VJPWHRH+3W'=>42,'4VJPWHRH+2V'=>10);
$restricted_code=array('4VJPWHRH+6V');
$json_array=array('north'=>-34.36,'south'=>-47.35,'west'=>166.28,'east'=>175);

?>
			<script>
const NEW_ZEALAND_BOUNDS = {
  north: -34.36,
  south: -47.35,
  west: 166.28,
  east: -175.81,
};
const AUCKLAND = { lat: -37.06, lng: 174.58 };

var buytilelimit=<?=$max_select?>;
var restricted_code=Object.values(<?=json_encode($restricted_code)?>);
 var pricelist=Object.keys(<?=json_encode($pricelist)?>);
</script>

<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBm46Na2pfh0csGP2bocMljHJ9q8xRbnk8&libraries=geometry"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/usermap/openlocationcode.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/usermap/examples.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <link href='<?=base_url()?>assets/usermap/examples.css' rel='stylesheet' type='text/css'>





<div class="pasge-wrapper">
			<div class="page-content">

				<?php

$allexpences=$allaexpences=$allpexpences=0;

?><div class="rowd row-dcols-1 drow-colds-lg-2 row-codls-xl-12">

				<div class="col-lg-12">
						<div class="card radiuds-10">
							<div class="card-boddy">
								<div class="">
									
								<div id="content">
    
    <div id="map-canvas" class="map_frame" ></div>
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
      <form method='post' id="buyform" action='buy.php'>
      <input type='hidden' name='amount' id='amount'>
      <input type='hidden' name='currency' id='currency' value='XEMXLINK'>
      <input type='hidden' name='area' id='area'>
      <button class="btn btn-primary"  id='buy_button'  style="float:left;displasy:none" onclick="buy();">Buy</button>
      </form>
      <button class="btn btn-primary"  style="float:right;" onclick="clerpo();">Clear Selection</button>
      </div>
      
      <div id="form_container1"></div>
    </div>
  </div>


								</div>
								
							</div>
						</div>
					</div>


				</div>
             






				
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
function get_prize(selected_products,code)
{
var result1;
for( var i = 0, len = selected_products.length; i < len; i++ ) 
{
   if( selected_products[i][0] === code ) 
    {
        result1 = selected_products[i][1];
        return result1;
        break;
    }
    else
    {
      return false;
      
    }
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

function drawsqual(map, code, fill) 
{
    if (typeof fill == 'undefined') {
      fill = '#e51c23';
    }
  var codeArea = OpenLocationCode.decode(code);
  var sw = new google.maps.LatLng(codeArea.latitudeLo, codeArea.longitudeLo);
  var ne = new google.maps.LatLng(codeArea.latitudeHi, codeArea.longitudeHi);
  var bounds = new google.maps.LatLngBounds(sw, ne);
  

  var index1 = pricelist.indexOf(code);
  var index = codearray.indexOf(code);
  
  if(index1==-1)
  {
    codearray.splice(index1, 1);
    prizearray.splice(index1,1);
    othermsg('<h4 style="color:red;">Area Restircted OR Price Not Set</h4>');
    
    return false;
  }
  if(index!==-1)
  {
    codearray.splice(index, 1);
    prizearray.splice(index,1);
    return false;
  }
  else
  {
  
    const image ='<i class="fa fa-product-hunt" style="font-size:48px;color:red"></i>';

    var current = new google.maps.LatLng(codeArea.latitudeCenter, codeArea.longitudeCenter);
    markers.push(new google.maps.Marker({
        map: map,
        position: current,
        title: code,
        label:  {text: code, color: "white",fontweight: "bold",},
        icon: image,
        labelClass: "labels", 
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
       
       zoomTo(olcCode);
       
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
            url       : 'http://localhost/map2/rate.php', //Your form processing file URL
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
       zoom: 20,
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
      map.setTilt(0);
     // OlcRefinedGrid(map);
      // Add an event listener to display OLC boxes around clicks.
      google.maps.event.addListener(map, 'click', mapClickHandler);
      // Get the geocoder.
      geocoder = new google.maps.Geocoder();
    });
  </script>



