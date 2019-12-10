var config = {
	map: {
		'*': {
			'ecomteck/note': 'Ecomteck_Bannerslider/js/jquery/slider/jquery-ads-note',
			'ecomteck/impress': 'Ecomteck_Bannerslider/js/report/impress',
			'ecomteck/clickbanner': 'Ecomteck_Bannerslider/js/report/clickbanner',
		},
	},
	paths: {
		'ecomteck/flexslider': 'Ecomteck_Bannerslider/js/jquery/slider/jquery-flexslider-min',
		'ecomteck/evolutionslider': 'Ecomteck_Bannerslider/js/jquery/slider/jquery-slider-min',
		'ecomteck/popup': 'Ecomteck_Bannerslider/js/jquery.bpopup.min',
	},
	shim: {
		'ecomteck/flexslider': {
			deps: ['jquery']
		},
		'ecomteck/evolutionslider': {
			deps: ['jquery']
		},
		'ecomteck/zebra-tooltips': {
			deps: ['jquery']
		},
	}
};
