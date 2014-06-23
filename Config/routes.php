<?php
Router::parseExtensions('rss');

Router::connect('/users', array('plugin' => 'gtw_users', 'controller' => 'users'));
Router::connect('/users/*', array('plugin' => 'gtw_users', 'controller' => 'users'));

Router::connect('/signin', array('plugin' => 'gtw_users', 'controller' => 'users', 'action' => 'signin'));
Router::connect('/signout', array('plugin' => 'gtw_users', 'controller' => 'users', 'action' => 'signout'));
Router::connect('/signup', array('plugin' => 'gtw_users', 'controller' => 'users', 'action' => 'signup'));
