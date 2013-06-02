//$( document ).ready(function() {

    //initialise the infowindow so it's ready for use
    var infowindow = null;

    //function to actually initialise the map
    function initialize()
    {
        //set your latitude and longitude as per the previous article, specify the default
        //zoom and set the default map type to RoadMap
        var latlng = new google.maps.LatLng(-28.274398,133.775136);
        var myOptions = {
            zoom: 4,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        //place the map on the canvas
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: heated
        });
       heatmap.setMap(map);

    //Set all your markers, the magic happens in another function - setMarkers(map, markers) which gets called
//        setMarkers(map, items);
//        infowindow = new google.maps.InfoWindow({
//            content: "..."
//        });
    }


    function toggleHeatmap() {
      heatmap.setMap(heatmap.getMap() ? null : map);
    }

    function toggleIcons() {

        for (var i = 0; i < items.length; i++) {
          items[i].setMap(map);
        }

    }

    //function to actually put the markers on the map
    function setMarkers(map, markers)
    {
        //loop through and place markers
        for (var i = 0; i < markers.length; i++)
        {
            var sites = markers[i];
            var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
            var marker = new google.maps.Marker({
                position: siteLatLng,
                map: map,
                title: sites[0],
                zIndex: sites[3],
                html: sites[4],
                icon: sites[5]
            });

            //initial content string
            var contentString = "";

            //attach infowindow on click
            google.maps.event.addListener(marker, "click", function ()
            {
                infowindow.setContent(this.html);
                infowindow.open(map, this);
            });

        }
    }


    initialize();

//});