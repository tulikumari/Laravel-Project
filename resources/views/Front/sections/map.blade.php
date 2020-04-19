@extends('layouts.app-cm')
@section('title', 'Cases')
@section('content')

<?php
$user = auth()->user();
$case_id = Request::segment(2); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">

    #map_canvas {
    width: 100%;
    height: 502px;
    border: solid 1px green;
    top: 50px;
    left: 50px;
}

#map {
        height: 500px;
      }
      .maps_content{
         height: 550px;
      }
      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 320px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 22px;
        font-weight: 500;
        padding: 6px 12px;
      }
           #markers{
           height: 300px;
        overflow-y: scroll;

      }
      #markers p{
        margin-bottom: 0rem;
        margin-bottom: 0px;

      }

      .pencil_button{
    font-size: 12px;
    margin: 4px;
    color:blue;
      }


.active-result {
  border: 1px solid lightgray;
  display: block;
  padding: 5px;
}
#results-control-ui .active-result {
  background-color: #eef;
}

p.result-id {
    display: none;
}
p.result-formatted-address {
  cursor: pointer;
  color: #000;
}

p.result-description {
  color: #444;
}

p.result-bounds {
  color: #600;
}

p.result-viewport {
  color: #006;
}

.hidden {
  display: none;
  visibility: hidden;
}

.warn {
  color: red;
}
#pac-container{ margin-top:15px; }
.pac-card{ width:350px; }
</style>

<div class="inner-info">
    <div class="container">
       <!--  <h3 class="info-head addspc">Map</h3> -->
        <div class="inner-info-content maps_content">
            <div class="blocked_spaced">
                <div class="container">
                    <div class="row">


                        <input type="hidden" name="case_id" id="case_id" value="<?php echo $case_id?>">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->id;?>">
                      
                       <div id="map_canvas">
                           <div id="map"></div>
                       </div>

                          <div class="pac-card" id="pac-card">
      <div>
        <div id="title">
          Autocomplete your search here..
        </div>
      </div>
     <div style="display: none;">
        <div id="type-selector" class="pac-controls">
          <input type="radio" name="type" id="changetype-all" checked="checked">
          <label for="changetype-all">All</label>

          <input type="radio" name="type" id="changetype-establishment">
          <label for="changetype-establishment">Establishments</label>

          <input type="radio" name="type" id="changetype-address">
          <label for="changetype-address">Addresses</label>

          <input type="radio" name="type" id="changetype-geocode">
          <label for="changetype-geocode">Geocodes</label>
        </div>
        <div id="strict-bounds-selector" class="pac-controls">
          <input type="checkbox" id="use-strict-bounds" value="">
          <label for="use-strict-bounds">Strict Bounds</label>
        </div>
      </div>
      <div id="pac-container">
                <input id="pac-input" type="text"
            placeholder="Enter a location">
      </div>
      <div id="markers">
     

      </div>

       <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div>
                         </div>

    </div>

                    </div>
                </div>
            </div>
        </div>


</div>
  <script type="text/javascript">

    var xhttp = new XMLHttpRequest();
    var map;
    var user_id = document.getElementById('user_id').value;
    var case_management_id = document.getElementById('case_id').value;
    var markers = [];

   

    function initMap() {      
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.0593325, lng: 15.1854451},
            zoom: 2
        });

        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);
            google.maps.event.addListener(map, 'rightclick', function(event) {
            var note = prompt("Enter your note on the place.").replace(/'/g, "\\'").replace(/"/g, '\\"');
            console.log(note.replace(/'/g, "\'"));   
            if (note != null) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
            delete options.headers['X-CSRF-TOKEN'];
            delete options.headers['Content-Type'];
            delete options.headers['Access-Control-Allow-Headers'];
          });
            $.ajax({url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&key=AIzaSyDfgRpKGIMRU-4PctxRR50kvr3sjkRlB_Q', 
          crossDomain: true ,success: function(result){          
          var address = result.results[0].formatted_address;          
           var title = "<div><strong>" + address + "</strong><br><br>" + note +"</div>"; 
            addMarker(event.latLng, map, title);
          $.ajax({url: URL +'/saveMap?latitude='+lat+'&longitude='+lng+'&address='+address+'&description='+note+'&index_map=1&caseManagementId='+ case_management_id, success: function(result){          
           load_Data();
          }});
          }});
            }
            
  
             
        });

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }      
        
 
          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }
          var latitude = place.geometry.location.lat();
          var longitude = place.geometry.location.lng();          
          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);

          var pretty_address =  place.name+" "+address   ;
          var description  = "";         
          addMarker(place.geometry.location, map, description);

          $.ajax({url: URL +'/saveMap?latitude='+latitude+'&longitude='+longitude+'&address='+pretty_address+'&description='+description+'&index_map=1&caseManagementId='+ case_management_id, success: function(result){
           // alert(result);
           load_Data();

          }});

        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });

        // When a user clicks on the map a marker appears, each marker is assigned the first free index            
        // Adds a marker to the map
        function addMarker(location, map, note) {
            var marker = new google.maps.Marker({              
                position: location,                
                map: map,
                draggable: true,
                editable: true
             });
            attachNote(marker, note);
        }
    }

    function attachNote(marker, note) {
        var inwindow = new google.maps.InfoWindow({
            content: note
        });
        marker.addListener('click', function() {
            inwindow.open(marker.get('map'), marker);
        });

   }

$(document).ready(function() {
   console.log(localStorage.getItem('google_map_api_key'));
  load_Data();
 });

function refreshMap(){
        var myLatlng = new google.maps.LatLng(51.0593325,15.1854451);
        map.setCenter(myLatlng);
        map.setZoom(2);
}
 function edit_desc(id,desc){
  var hash_id = "#"+id;   
  $(hash_id).empty();  
  if (desc == "null") {
  var textarea = $('<input id="'+hash_id+'" type="text" placeholder="Edit description" value=""><span style="cursor: pointer;" onclick="save_desc('+id+')"><i class="fa fa-check" style="font-size: 25px;color:green"></i></span><span style="cursor: pointer;" onclick="load_Data()"><i class="fa fa-close" style="font-size: 25px;color:red"></span>')  
  }else{
     var textarea = $('<input id="'+hash_id+'" type="text" value="'+desc+'"><span style="cursor: pointer;" onclick="save_desc('+id+')"><i class="fa fa-check" style="font-size: 25px;color:green"></i></span><span style="cursor: pointer;" onclick="load_Data()"><i class="fa fa-close" style="font-size: 25px;color:red"></span>')
  } 
    $(hash_id).append(textarea);
  }


  function save_desc(id){
    var hash_id = "#"+id;
    var edited_desc = document.getElementById(hash_id).value.replace(/'/g, "\\'").replace(/"/g, '\\"');; 
    console.log(edited_desc);   
    $.ajax({url: URL +'/updateMap?map_id='+id+'&description='+edited_desc, success: function(data){ load_Data();
      refreshMap();}});
  }
  
  function deleteMarker(id){ 
     if (confirm("Are you sure you want to delete Marker?")) { 
    $.ajax({url: URL +'/delete-mapdetail?map_id='+id, success: function(data){setMapOnAll(null);
                      markers = []; load_Data() ;
                      refreshMap();
       }});
  }
  return false;
  }  


  function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }  


      function getMarker(latitude,longitude,description,address) {
        var myLatlng = new google.maps.LatLng(latitude,longitude);
        map.setCenter(myLatlng);
        map.setZoom(11);
        var marker = new google.maps.Marker({
                          position: myLatlng                         
                      });        
        if (description == "undefined" || description == null ){
                        var showDesc = "" ;
                      }else{
                        var showDesc = description ;
                      }


        var note = "<div><strong>" + address + "</strong><br>" + showDesc +"</div>";
        attachNote(marker, note);
        marker.setMap(map);
        marker.setVisible(true);
      }

function load_Data(){
    $.ajax({url: URL +'/Getmapdata/'+ case_management_id, success: function(data){           
                $("#markers").empty();
                 setMapOnAll(null);
                markers = [];
                console.log(data);
                    data.forEach(function(item) {
                      console.log(item.description)

                      if (item.description == "undefined" || item.description == null ){
                        var showDesc = "Edit Description" ;
                        var showNote = "" ;
                      }else{
                        var showDesc = item.description ;
                        var showNote = item.description  ;
                      }
                    
                    var element = $('<div class="active-result"  onclick="getMarker('+item.latitude+','+item.longitude+ ',\''+  item.description+'\',\''+ item.address +'\')"> <table width="100%"><tbody> <tr valign="top"> <td style="padding: 2px" width="40"> <span style="display:block;background-image:url(https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png);width:26px;height:42px;"></span> </td><td style="padding: 2px;"> <p class="result-id">'+item.id+'</p><p class="result-formatted-address"> <strong>Address:</strong> '+ item.address +'</p><p class="result-description" id="'+item.id+'"> '+ showDesc+'<span onclick="edit_desc('+ item.id + ',\''+ item.description+'\')" style="padding: 10px;font-size: 15px;cursor: pointer;" ><i class="fa fa-pencil" style="color:blue"></i></span><span onclick="deleteMarker('+item.id +')" style="padding: 10px;font-size: 15px;"><i class="fa fa-trash-o" style="color:red;cursor: pointer;"></i><span></p></td></tr></tbody></table></div>');                     
                      $("#markers").append(element);
                                           
                      var location = {lat: parseFloat(item.latitude), lng: parseFloat(item.longitude)};                     
                      var note = "<div><strong>" + item.address + "</strong><br><br>" + showNote +"</div>";
                      addMarker(location, map, note);
                     function addMarker(location, map, note) {
                      var marker = new google.maps.Marker({               
                          position: location,                
                          map: map                
                       });
                      markers.push(marker);
                      attachNote(marker, note);
        }    

    function attachNote(marker, note) {
        var inwindow = new google.maps.InfoWindow({
            content: note
        });
        marker.addListener('click', function() {
            inwindow.open(marker.get('map'), marker);
        });

   }
                    });
      }});

}
</script>

<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfgRpKGIMRU-4PctxRR50kvr3sjkRlB_Q&libraries=places&callback=initMap"
         ></script>
@endsection
