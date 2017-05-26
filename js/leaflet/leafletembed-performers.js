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
		map.setView(new L.LatLng(latlng[0],latlng[1]),7);
	}
	else
	{
		map.setView(new L.LatLng(59.968,30.301),7);
		map.locate({setView: true, maxZoom: 12})
			.on('locationerror', function(e){
					console.log(e);
			});
	}
	map.addLayer(osm);

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

function askForPlots() {
	// request the marker info with AJAX for the current bounds
	var bounds=map.getBounds();
	var minll=bounds.getSouthWest();
	var maxll=bounds.getNorthEast();
	var msg='/performers.php?job=getUsers&bbox='+minll.lng+','+minll.lat+','+maxll.lng+','+maxll.lat+'&min[lng]='+minll.lng+'&min[lat]='+minll.lat+'&max[lng]='+maxll.lng+'&max[lat]='+maxll.lat;
	ajaxRequest.onreadystatechange = stateChanged;
	ajaxRequest.open('GET', msg, true);
	ajaxRequest.send(null);
}
function stateChanged() {
	// if AJAX returned a list of markers, add them to the map
	if (ajaxRequest.readyState==4) {
		//use the info here that was returned
		if (ajaxRequest.status==200) {
			plotlist=eval("(" + ajaxRequest.responseText + ")");
			removeMarkers();
			for (i=0;i<plotlist.length;i++) {
				// var iconName = plotlist[i].name;
				var iconWidth = 35;
				var markerIcon = L.divIcon({
					"className": plotlist[i].className,
					"html": '<img class="rounded-circle shadow" src="/user.getAvatar?user_id='+plotlist[i].user_id+'&w='+iconWidth+'&h='+iconWidth+'" />',
					"iconSize": [iconWidth,35],
					// "iconAnchor": [iconWidth,15],
					"popupAnchor": [0, -15]
				});
				var markerOptions = {
					"draggable": false,
					"riseOnHover": true,
					"icon": markerIcon
				}
				var plotll = new L.LatLng(plotlist[i].lat,plotlist[i].lon, true);
				var marker = L.marker(plotll,markerOptions);
				var details = ''
				+'<strong>Рейтинг</strong>: '+plotlist[i].details.rating
				+'<br /><a class="wdo-link" href="/profile/id'+plotlist[i].details.user_id+'#user-responds"><strong>Отзывов</strong></a>: '+plotlist[i].details.responds;

/*
				$.each(plotlist[i].details, function(name,value){
					if ( name == "rating" ) name = '<a href="/profile/id'++'"';
					details += "<strong>"+name+":</strong> "+value+"<br />";
				})
*/
				marker.bindPopup("<h5><a href='/#map/' onClick='app.device.runApiMethod("+plotlist[i].dev_id+",\"login\");'>"+plotlist[i].name+"</a></h5>"+details);
				marker.on('mouseover', function (e) {
						this.openPopup();
				});
				markers.addLayer(marker);
				markerList.push(marker);
			}
			map.addLayer(markers);
		}
	}
}


function removeMarkers() {
	for (i=0;i<markerList.length;i++) {
		markers.removeLayer(markerList[i]);
	}
	markerList=[];
}

// then add this as a new function...
function onMapMove(e) { askForPlots(); }

