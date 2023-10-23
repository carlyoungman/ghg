class GoogleMap {

    constructor(container) {

        if(container) {
            // Get map
            this.map = container
            this.zoom = container.getAttribute('data-zoom');

            // Get marker
            this.markers = this.map.querySelectorAll('.marker');

            this.initMap();
        }

    }

    initMap() {

        // Create gerenic map.
        let mapArgs = {
            zoom        : parseInt(this.zoom) || 16,
            mapTypeId   : google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        };
        
        let map = new google.maps.Map( this.map, mapArgs );

        // Add markers.
        map.markers = [];
        this.markers.forEach((mrk) => {
            this.initMarker( mrk, map );
        });

        // Center map based on markers.
        this.centerMap( map );

        // Return map instance.
        return map;
    }


    initMarker( mrk, map ) {

        // Get position from marker.
        let lat = mrk.getAttribute('data-lat');
        let lng = mrk.getAttribute('data-lng');
        let latLng = {
            lat: parseFloat( lat ),
            lng: parseFloat( lng )
        };

        // Create marker instance.
        let marker = new google.maps.Marker({
            position : latLng,
            map: map,
        });

        // Append to reference for later use.
        map.markers.push( marker );

    }


    centerMap( map ) {

        // Create map boundaries from all map markers.
        var bounds = new google.maps.LatLngBounds();
        map.markers.forEach(function( marker ){
            bounds.extend({
                lat: marker.position.lat(),
                lng: marker.position.lng()
            });
        });

        // Case: Single marker.
        if( map.markers.length == 1 ){
            map.setCenter( bounds.getCenter() );

        // Case: Multiple markers.
        } else{
            map.fitBounds( bounds );
        }
    }

}

// Create instances for maps
let maps = document.querySelectorAll('.map__container');
maps.forEach((item) => {
    let newMap = new GoogleMap(item);
});