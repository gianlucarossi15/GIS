
var view = new ol.View ({
    center: ol.proj.fromLonLat([11.896250157856228, 45.404413176964475]),
    zoom:14,
    minZoom: 12,
    maxZoom: 22
});

var map = new ol.Map ({
    target: 'map',
    view: view,
   
});

var osm = new ol.layer.Tile ({
    title: 'Open Street Map',
    visible: true,
    source: new ol.source.OSM()
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
