<?php
    if( $_SERVER['REQUEST_METHOD']=='POST' ){
        ob_clean();


        /* process the addition of the polygon */
        if( !empty( $_POST['name'] ) && !empty( $_POST['path'] ) ){


            $dbhost =   'localhost';
            $dbuser =   'root'; 
            $dbpwd  =   'xxx'; 
            $dbname =   'gm_polygons';
            $db     =   new mysqli( $dbhost, $dbuser, $dbpwd, $dbname );


            $name=$_POST['name'];
            $path=json_decode( $_POST['path'] );



            /* insert new path */
            $sql='insert into polygon set `name`=?';
            $stmt=$db->prepare( $sql );

            if( !$stmt )exit( 'Error: query 1' );

            $stmt->bind_param('s',$name);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();


            /* get the ID for the newly inserted Polygon name */
            $id=$db->insert_id;




            /* add all the latlng pairs for the polygon */
            $sql='insert into `paths` ( `pid`, `lat`, `lng` ) values ( ?, ?, ? )';
            $stmt=$db->prepare( $sql );

            if( !$stmt )exit( 'Error: query 2' );

            $stmt->bind_param( 'idd', $id, $lat, $lng );

            foreach( $path as $obj ){
                $lat=$obj->lat;
                $lng=$obj->lng;
                $stmt->execute();
            }
            $stmt->close();

            echo json_encode(
                array(
                    'name'=>$name,
                    'points'=>count($path)
                )
            );

        }
        exit();
    }
?>
<html>
    <head>
        <meta charset='utf-8' />
        <title>Google Maps: Storing Polygons in database</title>
        <script async defer src='//maps.google.com/maps/api/js?key=AIzaSyBm46Na2pfh0csGP2bocMljHJ9q8xRbnk8&callback=initMap&region=GB&language=en'></script>
        <script>

            let map;
            let div;
            let bttn;
            let input;
            let options;
            let centre;
            let poly;
            let path;
            let polypath;

            function initMap(){

                const ajax=function( url, params, callback ){
                    let xhr=new XMLHttpRequest();
                    xhr.onload=function(){
                        if( this.status==200 && this.readyState==4 )callback( this.response )
                    };
                    xhr.open( 'POST', url, true );
                    xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
                    xhr.send( buildparams( params ) );
                };
                const buildparams=function(p){
                    if( p && typeof( p )==='object' ){
                        p=Object.keys( p ).map(function( k ){
                            return typeof( p[ k ] )=='object' ? buildparams( p[ k ] ) : [ encodeURIComponent( k ), encodeURIComponent( p[ k ] ) ].join('=')
                        }).join('&');
                    }
                    return p;
                };
                const createpoly=function(){
                    poly=new google.maps.Polygon({
                      strokeColor: '#FF0000',
                      strokeOpacity: 0.8,
                      strokeWeight: 3,
                      fillColor: '#FF0000',
                      fillOpacity: 0.35,
                      draggable:true,
                      editable:true
                    });
                    poly.setMap( map );
                    return poly;
                };

                centre=new google.maps.LatLng( 51.483719, -0.020037 );
                div=document.getElementById('map');
                input=document.querySelector('#container > form > input[name="polyname"]');
                bttn=document.querySelector('#container > form > input[type="button"]');

                options = {
                    zoom: 15,
                    center: centre,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: false,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                        mapTypeIds: [ 'roadmap', 'terrain', 'satellite', 'hybrid' ]
                    }
                };
                map = new google.maps.Map( div, options );



                createpoly();



                google.maps.event.addListener( map, 'click', e=>{
                    path=poly.getPath();
                    path.push( e.latLng );
                });

                google.maps.event.addListener( poly, 'rightclick', e=>{
                    poly.setMap( null );
                    createpoly();
                });

                bttn.addEventListener('click',e=>{
                    if( input.value!='' ){

                        path=poly.getPath();
                        polypath=[];

                        for( let i=0; i < path.length; i++ ){
                            let point=path.getAt( i );
                            polypath.push( { lat:point.lat(), lng:point.lng() } )
                        }
                        var length = google.maps.geometry.spherical.computeLength(path);
                        var computeArea = google.maps.geometry.spherical.computeArea(path);
                        let params={
                            path:JSON.stringify( polypath ),
                            length:length,
                            area:computeArea,
                            name:input.value
                        }


                        //[{"lat":17.899958518009452,"lng":75.01716107631769},{"lat":17.899687965980476,"lng":75.01726300026026},{"lat":17.89972114691189,"lng":75.01738638187494},{"lat":17.899786232567017,"lng":75.01736224199381},{"lat":17.899853870575484,"lng":75.01733810211267},{"lat":17.899921508558148,"lng":75.01730859781351},{"lat":17.900004460765846,"lng":75.01727372909632}]
                        let url=location.href;
                        let callback=function(r){
                            console.info( r );
                            input.value='';
                            poly.setMap( null );
                            createpoly();
                        };
                        /* send the polygon data */
                        ajax.call( this, url, params, callback );
                    }
                })
            }
        </script>
        <style>
            body{ background:white; }
            #container{
                width: 90%;
                min-height: 90vh;
                height:auto;
                box-sizing:border-box;
                margin: auto;
                float:none;
                margin:1rem auto;
                background:whitesmoke;
                padding:1rem;
                border:1px solid gray;
                display:block;
            }
            #map {
                width: 100%;
                height: 80%;
                clear:none;
                display:block;
                z-index:1!important;
                background:white;
                border:1px solid black;
            }
        </style>
    </head>
    <body>
        <div id='container'>
            <form method='post'>
                <input type='text' name='polyname' />
                <input type='button' value='Commit' title='Store the polygon' />
            </form>
            <div id='map'></div>
            <div id='data'></div>
        </div>
    </body>
</html>
