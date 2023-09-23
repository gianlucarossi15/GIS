var view = new ol.View ({
    center: ol.proj.fromLonLat([11.896250157856228, 45.404413176964475]),
    zoom:13,
    minZoom: 1,//12
    maxZoom: 22
});

var map = new ol.Map ({
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
    src: 'images/location-pin.png', // Path to your custom marker icon
    scale: 0.5, // Adjust the size of the marker icon as needed
    offset: [0.5, 1], // Adjust the offset to align the marker correctly
    anchor: [0.5, 1], // Set the anchor point to the bottom center of the marker icon
}),
});


document.addEventListener("DOMContentLoaded",  () => {
    var lat = document.getElementById("latitude").value;
    var long = document.getElementById("longitude").value;
    var coordinate = [long, lat];

    console.log(coordinate);

    markerFeature = new ol.Feature({
        geometry: new ol.geom.Point(coordinate),
    });

    markerFeature.setStyle(markerStyle);

    markerLayer.getSource().addFeature(markerFeature);


});
  
