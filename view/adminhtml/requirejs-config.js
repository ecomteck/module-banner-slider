var config = {
    map: {
        '*': {
            'ecomteck/note': 'Ecomteck_Bannerslider/js/jquery/slider/jquery-ads-note',
        },
    },
    paths: {
        'ecomteck/flexslider': 'Ecomteck_Bannerslider/js/jquery/slider/jquery-flexslider-min',
        'ecomteck/evolutionslider': 'Ecomteck_Bannerslider/js/jquery/slider/jquery-slider-min',
        'ecomteck/zebra-tooltips': 'Ecomteck_Bannerslider/js/jquery/ui/zebra-tooltips',
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
