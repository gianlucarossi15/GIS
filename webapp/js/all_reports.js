var view = new ol.View ({
    center: ol.proj.fromLonLat([11.896250157856228, 45.404413176964475]),
    zoom:13,
    minZoom: 1,//12
    maxZoom: 22
});

const container = document.getElementById('popup');
const content = document.getElementById('popup-content');
const closer = document.getElementById('popup-closer');

const overlay = new ol.Overlay({
    element: container,
    autoPan: {
      animation: {
        duration: 250,
      },
    },
  });
  
/**
 * Add a click handler to hide the popup.
 * @return {boolean} Don't follow the href.
 */
closer.onclick = function () {
overlay.setPosition(undefined);
closer.blur();
return false;
};

var map = new ol.Map ({
    overlays: [overlay],
    target: 'map',
    view: view,
    controls : ol.control.defaults({
        attribution : false
    })
});

var osm = new ol.layer.Tile ({
    title: 'Open Street Map',
    visible: true,
    source: new ol.source.OSM({
    })
        
});

map.addLayer(osm);

var roads= new ol.layer.Tile({
    title: "strade",
    source: new ol.source.TileWMS({
        url: 'http://localhost:8080/geoserver/GIS_EXAM/wms',
        params: {'LAYERS':'GIS_EXAM:roads', 'TILED': true},
        serverType: 'geoserver',
        visible: true
    })
});

map.addLayer(roads);

var shed= new ol.layer.Tile({
title: "shed",
source: new ol.source.TileWMS({
    url: 'http://localhost:8080/geoserver/GIS_EXAM/wms',
    params: {'LAYERS':'GIS_EXAM:shed', 'TILED': true},
    serverType: 'geoserver',
    visible: true
})
});

map.addLayer(shed);

var markerLayer = new ol.layer.Vector({
    source: new ol.source.Vector(),
});

map.addLayer(markerLayer);

var markerFeature;

var markerStyle = new ol.style.Style({
    image: new ol.style.Icon({
        src: 'images/location-pin.png',
        scale: 0.5, 
        offset: [0.5, 1], 
        anchor: [0.5, 1], 
    }),
});




var markerCoordinates=[], markers=[];

document.addEventListener("DOMContentLoaded",  () => {
    
    var coordinate;
    var id_arr=document.getElementById("id").value.split(",");
    var lat_arr = document.getElementById("latitude").value.split(",");
    var long_arr = document.getElementById("longitude").value.split(",");
    var hole_arr= document.getElementById("hole").value.split(",");
    var photo_arr=document.getElementById("photo").value.split(",");
    
    var i;
    
    for (i = 0; i <lat_arr.length; i++) {

        coordinate = [parseFloat(long_arr[i]), parseFloat(lat_arr[i])];
        
        markerFeature = new ol.Feature({
            geometry: new ol.geom.Point(coordinate),
        });
        
        
        markerFeature.setStyle(markerStyle);
        markers[i]=markerFeature;

        markerLayer.getSource().addFeature(markerFeature);
        
    }   
    console.log("end");

    var j=0; 
    map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel,
          function(feature) {
            return feature;
          });

        for(let j=0; j<markers.length; j++)
        {
            if(markers[j]==feature){
                coordinate=feature.getProperties().geometry.A;
                var holeType = hole_arr[j];
                var photo = photo_arr[j];
                var id = id_arr[j]; 
                var url = "info_report.php?id=" + id; 
                content.innerHTML = "<h5><p class='text-center'> Report: " + id + " , Hole type: " + holeType + " , photo: " + photo + " <a href='" + url + "'><button>more info</button></a></p></h5>";

                overlay.setPosition(coordinate);
            }
        }
    });
});
  
