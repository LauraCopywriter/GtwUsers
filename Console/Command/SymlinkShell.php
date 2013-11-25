<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 *
 * You probably need to run this as an Admin!
 */

class SymlinkShell extends AppShell {
    public function main() {
        if (!file_exists(WWW_ROOT.'GtwUsers')){
            symlink ( CakePlugin::path('GtwUsers').'webroot' , WWW_ROOT.'GtwUsers');
        }
    }
}
?>