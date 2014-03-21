<!-- PhotoZoom -->
  <script type="text/javascript" src="./highslide/highslide-full.js"></script>
  <link rel="stylesheet" type="text/css" href="./highslide/highslide.css" />
  <script type="text/javascript">
hs.graphicsDir = './highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.align = 'center';
hs.showCredits = false;
hs.wrapperClassName = 'draggable-header';
hs.transitions = ['expand', 'crossfade'];
hs.fadeInOut = true;
//hs.dimmingOpacity = 0.75;

// Add the controlbar
hs.addSlideshow({
	slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: 0.75,
		position: 'bottom center',
		hideOnMouseOut: true
	}
});

  </script>

  <!-- /PhotoZoom -->