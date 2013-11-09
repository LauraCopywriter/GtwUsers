# Gintonic Web's CakePHP Users plugin

This plugin is under development and should not be used in it's current state.

## Requirements


## Installation

Make sure the plugin is loaded in app/Config/bootstrap.php

    CakePlugin::load('GtwUsers'); 
    
Add a [cookie key](http://book.cakephp.org/2.0/en/core-libraries/components/cookie.html) app/Config/bootstrap.php

    Configure::write('GtwCookies.key', '1198faeb48r2r3bef0503');
    
Add [a duration](http://www.php.net/manual/en/datetime.formats.relative.php) for the Cookie

    Configure::write('GtwCookies.loginDuration', '+2 weeks');