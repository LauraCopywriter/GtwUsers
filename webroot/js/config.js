/*
    Gintonic Web
    Author:    Philippe Lafrance
    Link:      http://gintonicweb.com
*/

requirejs.config({

    baseUrl: '/js/',
    urlArgs: "bust=55",
    
    paths: {
        app:        '/js/app',
        basepath:   '../GtwRequire/js/basepath',
        
        // Gtw Plugins
        ui:     '../GtwUi/js',
        //contact:'/GtwContact/js',
        users:  '/GtwUsers/js',
        //files:  '/GtwFiles/js',
        
        // Libs
        jquery:             '//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min',
        bootstrap:          '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min',                             
        jqueryvalidate:     '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min',        
    },
    
    shim: {
        bootstrap : ["jquery"],
        jqueryvalidate : ["jquery"],        
    },
    
    optimize: "none"
    
});