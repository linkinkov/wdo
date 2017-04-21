var map;
var ajaxRequest;
var plotlist;
var plotlayers=[];
var markerList = [];
var markers = L.markerClusterGroup({
	animate: true,
	disableClusteringAtZoom: 8
});

function initmap() {
	// set up the map
	map = new L.Map('map');

	// create the tile layer with correct attribution
	var osmUrl='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});

	map.setView(new L.LatLng(59.968,30.301),9);
	map.addLayer(osm);

	map.locate({setView: true, maxZoom: 10})
		.on('locationerror', function(e){
				// console.log(e);
		});
/*
	var items =	[];
	var geojsonLayer = L.geoJson.ajax('/includes/api2.php?job=getPerformerList', {
		onEachFeature: function(data, layer) {
			items.push(layer);
			layer.bindPopup('<h3>' + data.properties.park + '</h3>');
		}
	});

	// geojsonLayer.addTo(map);
	L.control.search({
		data: items
	}).addTo(map);
*/
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
	var selectedSubCats = "";
	$.each(projectsInfo.selectedSubCats, function(i,v){
		selectedSubCats += "&selectedSubCats[]="+v;
	})
	var msg='/includes/api2.php?job=getPerformerList'+selectedSubCats+'&min[lng]='+minll.lng+'&min[lat]='+minll.lat+'&max[lng]='+maxll.lng+'&max[lat]='+maxll.lat+'&cityID='+projectsInfo.cityID;
	ajaxRequest.onreadystatechange = stateChanged;
	ajaxRequest.open('GET', msg, true);
	ajaxRequest.send(null);
}
function stateChanged() {
	// if AJAX returned a list of markers, add them to the map
	if (ajaxRequest.readyState==4) {
		//use the info here that was returned
		if (ajaxRequest.status==200) {
			raw=eval("(" + ajaxRequest.responseText + ")");
			plotlist = raw.data;
			removeMarkers();
			for (i=0;i<plotlist.length;i++) {
				var iconName = plotlist[i].memberName;
				var iconWidth = (iconName.length) * 9;
				var markerIcon = L.divIcon({"image_url":plotlist[i].memberAvatarPath,"className": plotlist[i].className,"html": "", iconSize:[30,30], iconAnchor:[15,30], popupAnchor: [0, -30]});
				var markerOptions = {
					"draggable": false,
					"riseOnHover": true,
					"icon": markerIcon
				}
				var plotll = new L.LatLng(plotlist[i].lat,plotlist[i].lon, true);
				var marker = L.marker(plotll,markerOptions);
				var details = "";
/*
				$.each(plotlist[i].details, function(name,value){
					if ( name == "Подключен" || name == "Активность" ) value = moment.unix(value).format("LLL");
					details += "<strong>"+name+":</strong> "+value+"<br />";
				})
*/
				marker.bindPopup("<h5><a href='http://weedo.ru/profile/member-"+plotlist[i].memberID+".html'>"+plotlist[i].memberName+"</a></h5>"+details);
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


function sortParks(a, b) {
	var _a = a.feature.properties.park;
	var _b = b.feature.properties.park;
	if (_a < _b) {
		return -1;
	}
	if (_a > _b) {
		return 1;
	}
	return 0;
}
/*
L.Control.Search = L.Control.extend({
	options: {
		// topright, topleft, bottomleft, bottomright
		position: 'topright',
		placeholder: 'Серийный номер...'
	},
	initialize: function (options) {
		// constructor
		L.Util.setOptions(this, options);
	},
	onAdd: function (map) {
		// happens after added to map
		var container = L.DomUtil.create('div', 'search-container');
		this.form = L.DomUtil.create('form', 'form', container);
		var group = L.DomUtil.create('div', 'form-group', this.form);
		this.input = L.DomUtil.create('input', 'form-control input-sm', group);
		this.input.type = 'text';
		this.input.placeholder = this.options.placeholder;
		this.results = L.DomUtil.create('div', 'list-group', group);
		L.DomEvent.addListener(this.input, 'keyup', _.debounce(this.keyup, 300), this);
		L.DomEvent.addListener(this.form, 'submit', this.submit, this);
		L.DomEvent.disableClickPropagation(container);
		return container;
	},
	onRemove: function (map) {
		// when removed
		L.DomEvent.removeListener(this._input, 'keyup', this.keyup, this);
		L.DomEvent.removeListener(form, 'submit', this.submit, this);
	},
	keyup: function(e) {
		if (e.keyCode === 38 || e.keyCode === 40) {
			// do nothing
		} else {
			this.results.innerHTML = '';
			if (this.input.value.length > 2) {
				var value = this.input.value;
				var results = _.take(_.filter(this.options.data, function(x) {
					return x.feature.properties.park.toUpperCase().indexOf(value.toUpperCase()) > -1;
				}).sort(sortParks), 10);
				_.map(results, function(x) {
					var a = L.DomUtil.create('a', 'list-group-item');
					a.href = '';
					a.setAttribute('data-result-name', x.feature.properties.park);
					a.innerHTML = x.feature.properties.park;
					this.results.appendChild(a);
					L.DomEvent.addListener(a, 'click', this.itemSelected, this);
					return a;
				}, this);
			}
		}
	},
	itemSelected: function(e) {
		L.DomEvent.preventDefault(e);
		var elem = e.target;
		var value = elem.innerHTML;
		this.input.value = elem.getAttribute('data-result-name');
		var feature = _.find(this.options.data, function(x) {
			return x.feature.properties.park === this.input.value;
		}, this);
		if (feature) {
			var coords = feature.feature.geometry.coordinates;
			this._map.flyTo(new L.LatLng(coords[0],coords[1]),14,{
				animate: true,
				duration: 4
			});
		}
		this.results.innerHTML = '';
	},
	submit: function(e) {
		L.DomEvent.preventDefault(e);
	}
});

L.control.search = function(id, options) {
	return new L.Control.Search(id, options);
}
*/