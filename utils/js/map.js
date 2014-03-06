jQuery(document).ready(function() {
                $("#vmap").css({"height":$(window).height()-75});
		jQuery('#vmap').vectorMap({
		    map: 'world_en',
		    backgroundColor: '#cfe2f3',
		    color: '#ffffff',
		    hoverOpacity: 0.7,
		    selectedColor: '#666666',
		    enableZoom: true,
		    showTooltip: true,
		    values: sample_data,
		    scaleColors: ['#42afe0', '#006491'],
		    normalizeFunction: 'polynomial',
                     onRegionClick: function(element, code, region)
                        {
                            var message = 'You clicked "'
                                + region 
                                + '" which has the code: '
                                + code.toUpperCase();

                            alert(message);
                        },
                        onLabelShow: function(event, label, code)
                        {
                            label.html(label.text() + '<br/>-- université(s)<br/>-- avis au total');
                        }
		});
                
                $(window).resize(function() {
                   $("#vmap").css({"height":$("#global").height()-75}); 
                });
	});