var map;
var ajaxRequest;
var plotlist;
var plotlayers=[];
var markerList = [];
var markers = L.markerClusterGroup({
	animate: true,
	disableClusteringAtZoom: 11
});

function initmap(myPlaceCoords) {
	map = new L.Map('map');
	var osmUrl='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});
	if ( myPlaceCoords != "" )
	{
		var latlng = myPlaceCoords.split(",");
		map.setView(new L.LatLng(latlng[0],latlng[1]),14);
	}
	else
	{
		map.setView(new L.LatLng(59.968,30.301),9);
		map.locate({setView: true, maxZoom: 12})
			.on('locationerror', function(e){
					console.log(e);
			});
	}
	map.addLayer(osm);

	if ( myPlaceCoords != "" )
	{
		var latlng = myPlaceCoords.split(",");
		var marker = new L.marker(latlng);
		markers.addLayer(marker);
		markerList.push(marker);
		map.addLayer(markers);
	}
}
function getXmlHttpObject() {
	if (window.XMLHttpRequest) { return new XMLHttpRequest(); }
	if (window.ActiveXObject)  { return new ActiveXObject("Microsoft.XMLHTTP"); }
	return null;
}
function onLocationFound(e) {
}
function onLocationError(e) {
	alert(e.message);
}

function removeMarkers() {
	for (i=0;i<markerList.length;i++) {
		markers.removeLayer(markerList[i]);
	}
	markerList=[];
}

// then add this as a new function...
//function onMapMove(e) { askForPlots(); }
