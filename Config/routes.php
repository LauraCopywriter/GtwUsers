<?php
Router::parseExtensions('rss');

Router::connect('/users', array('plugin' => 'gtw_users', 'controller' => 'users'));
Router::connect('/users/*', array('plugin' => 'gtw_users', 'controller' => 'users'));
Router::connect('/signin', array('plugin' => 'gtw_users', 'controller' => 'users', 'action' => 'signin'));