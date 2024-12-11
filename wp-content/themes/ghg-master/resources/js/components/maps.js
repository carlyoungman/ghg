/**
 * initMap
 *
 * Renders a Google Map onto the selected element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   HTMLElement el The DOM element.
 * @return  object The map instance.
 */
function initMap(el) {
	// Find marker elements within the element.
	const markers = el.querySelectorAll('.marker');
	const customMapStyles = [
		{
			"featureType": "all",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"weight": "2.00"
				}
			]
		},
		{
			"featureType": "all",
			"elementType": "geometry.stroke",
			"stylers": [
				{
					"color": "#9c9c9c"
				}
			]
		},
		{
			"featureType": "all",
			"elementType": "labels.text",
			"stylers": [
				{
					"visibility": "on"
				}
			]
		},
		{
			"featureType": "landscape",
			"elementType": "all",
			"stylers": [
				{
					"color": "#f2f2f2"
				}
			]
		},
		{
			"featureType": "landscape",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"color": "#ffffff"
				}
			]
		},
		{
			"featureType": "landscape.man_made",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"color": "#ffffff"
				}
			]
		},
		{
			"featureType": "poi",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "all",
			"stylers": [
				{
					"saturation": -100
				},
				{
					"lightness": 45
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"color": "#eeeeee"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#7b7b7b"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "labels.text.stroke",
			"stylers": [
				{
					"color": "#ffffff"
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "simplified"
				}
			]
		},
		{
			"featureType": "road.arterial",
			"elementType": "labels.icon",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "transit",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "all",
			"stylers": [
				{
					"color": "#46bcec"
				},
				{
					"visibility": "on"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "geometry.fill",
			"stylers": [
				{
					"color": "#c8d7d4"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#070707"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "labels.text.stroke",
			"stylers": [
				{
					"color": "#ffffff"
				}
			]
		}
	];

	// Create a generic map.
	const mapArgs = {
		zoom: 15,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		styles: customMapStyles // Apply custom map styles
	};
	const map = new google.maps.Map(el, mapArgs);

	// Add markers.
	map.markers = [];
	markers.forEach(function (marker) {
		initMarker(marker, map);
	});

	// Center the map based on markers.
	centerMap(map);

	// Return map instance.
	return map;
}

/**
 * initMarker
 *
 * Creates a marker for the given element and map.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   HTMLElement marker The DOM element.
 * @param   object map The map instance.
 * @return  object The marker instance.
 */
function initMarker(marker, map) {
	// Get position from marker.
	const lat = marker.getAttribute('data-lat');
	const lng = marker.getAttribute('data-lng');
	const latLng = {
		lat: parseFloat(lat),
		lng: parseFloat(lng),
	};

	// Create a marker instance.
	const gMarker = new google.maps.Marker({
		position: latLng,
		map: map,
		icon: {
			url: 'data:image/svg+xml;base64,' + btoa('<svg viewBox="0 0 25 38" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
				'<path d="M24.1628 12.0814C24.1628 18.7538 12.9444 37.1071 12.9444 37.1071C12.9444 37.1071 0 18.7538 0 12.0814C0 5.40903 5.40903 0 12.0814 0C18.7538 0 24.1628 5.40903 24.1628 12.0814Z" fill="#283741"/>\n' +
				'<circle cx="12.082" cy="12.0814" r="5.17774" fill="#FAF5FA"/>\n' +
				'</svg>'),
			scaledSize: new google.maps.Size(40, 40)
		}
	});


	// Append to reference for later use.
	map.markers.push(gMarker);

	// If the marker contains HTML, add it to an infoWindow.
	if (marker.innerHTML) {
		// Create an info window.
		const infowindow = new google.maps.InfoWindow({
			content: marker.innerHTML,
		});

		// Show the info window when the marker is clicked.
		google.maps.event.addListener(gMarker, 'click', function () {
			infowindow.open(map, gMarker);
		});
	}
}

/**
 * centerMap
 *
 * Centers the map showing all markers in view.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   object map The map instance.
 * @return  void
 */
function centerMap(map) {
	// Create map boundaries from all map markers.
	const bounds = new google.maps.LatLngBounds();
	map.markers.forEach(function (marker) {
		bounds.extend(marker.position);
	});

	// Case: Single marker.
	if (map.markers.length === 1) {
		map.setCenter(bounds.getCenter());
	} else {
		// Case: Multiple markers.
		map.fitBounds(bounds);
	}
}

// Export the maps function as the default export of this module.
export default function maps() {
	const acfMaps = document.querySelectorAll('.map');
	acfMaps.forEach(function (map) {
		initMap(map);
	});
}
