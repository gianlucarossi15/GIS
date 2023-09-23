
var view = new ol.View ({
    center: ol.proj.fromLonLat([11.896250157856228, 45.404413176964475]),
    zoom:13,
    minZoom: 12,
    maxZoom: 22
});

/**
 * Elements that make up the popup.
 */
const container = document.getElementById('popup');
const content = document.getElementById('popup-content');
const closer = document.getElementById('popup-closer');
const lat_el=document.getElementById('latitude');
const long_el=document.getElementById('longitude');
/**
 * Create an overlay to anchor the popup to the map.
 */
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



/**
 * Add a click handler to the map to render the popup.
 */
map.on('singleclick', function (evt) {
    
    const coordinate = evt.coordinate;
    console.log(coordinate);
    const lat=coordinate[1];
    const long=coordinate[0];
    //const extent = map.getView().calculateExtent();
    //const bounds = ol.proj.transformExtent(extent,'EPSG:3857','EPSG:4326')
    //alert(bounds);
    //to handle more precisely
    // if(lat<1322204.343 || lat>1328293 || long<5682172 || long>5688435)
    // //if(lat<4.914300142921022 || lat>4.973577611756982 || long<44.97376873286308 || long>45.01758931303594)
    //   alert("Out of the available map legal coordinates!! Choose the coordinate inside of it");
    // else
    {
      content.innerHTML = '<p>You clicked here: ' + long+" , "+lat;
      lat_el.value = lat;
      long_el.value = long;
      overlay.setPosition(coordinate);

      if (markerFeature)
        markerLayer.getSource().removeFeature(markerFeature);

      markerFeature = new ol.Feature({
        geometry: new ol.geom.Point(coordinate),
      });

      markerFeature.setStyle(markerStyle);

      markerLayer.getSource().addFeature(markerFeature);
      
     
    }
    
   
  });


  
var osm = new ol.layer.Tile ({
    title: 'Open Street Map',
    visible: true,
    source: new ol.source.OSM({
    })
        
});

map.addLayer(osm);

var roadLayer= new ol.layer.Tile({
    title: "strade",
    source: new ol.source.TileWMS({
        url: 'http://localhost:8080/geoserver/GIS_EXAM/wms',
        params: {'LAYERS':'GIS_EXAM:roads', 'TILED': true},
        serverType: 'geoserver',
        visible: true
    })
});

map.addLayer(roadLayer);

// var roadLayer = new ol.layer.Vector({
//   source: new ol.source.Vector({
//       format: new ol.format.GeoJSON(),
//       url: function (extent) {
//           return 'http://localhost:8080/geoserver/GIS_EXAM/wfs?service=WFS&' +
//               'version=2.0.0&request=GetFeature&typeNames=GIS_EXAM:roads&' +
//               'outputFormat=application/json&srsname=EPSG:4326&' +
//               'bbox=' + extent.join(',') + ',EPSG:4326';
//       },
//       strategy: ol.loadingstrategy.bbox
//   })
// });

// map.addLayer(roadLayer);



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


document.addEventListener("DOMContentLoaded", () => {
  
  navigator.geolocation.getCurrentPosition(position =>{
    const {latitude, longitude}= position.coords;
    coordinate=ol.proj.transform([longitude,latitude], 'EPSG:4326','EPSG:3857');
    long_el.value = coordinate[0];
    lat_el.value = coordinate[1];
    content.innerHTML = '<p>You clicked here: ' + coordinate[0]+" , "+coordinate[1],"</p>";


    
    // view.setCenter(coordinate);
    
    overlay.setPosition(coordinate);
    if (markerFeature)
      markerLayer.getSource().removeFeature(markerFeature);

    markerFeature = new ol.Feature({
      geometry: new ol.geom.Point(coordinate),
    });

    markerFeature.setStyle(markerStyle);

    markerLayer.getSource().addFeature(markerFeature);
    
  });
  
});
