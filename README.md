# Gintonic Web's CakePHP Users plugin

This plugin is under development and should not be used in it's current state.

## Requirements

TODO

## Installation
Copy this plugin in a folder named `app/Plugin/GtwUsers` or add these lines to your `composer.json` file :

        "require": {
            "phillaf/gtw_require": "*@dev"
        }
    
Create a symlink from this plugin's webroot to the application webroot by running `Console/cake GtwUsers.symlink`

Load the plugin by adding this line to `app/Config/bootstrap.php` : `CakePlugin::load('GtwUsers');`
    
Add a [cookie key](http://book.cakephp.org/2.0/en/core-libraries/components/cookie.html) app/Config/bootstrap.php

    Configure::write('GtwCookies.key', '1198faeb48r2r3bef0503');
    
Add [a duration](http://www.php.net/manual/en/datetime.formats.relative.php) for the Cookie

    Configure::write('GtwCookies.loginDuration', '+2 weeks');
    
Import this plugins style into your project by adding this to your less file.
    
    @import "../GtwUsers/less/users.less";
    
## Copyright and license   
Author: Philippe Lafrance   
Copyright 2013 [Gintonic Web](http://gintonicweb.com)  
Licensed under the [Apache 2.0 license](http://www.apache.org/licenses/LICENSE-2.0.html)