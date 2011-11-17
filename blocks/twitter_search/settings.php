<?php
$settings->add(new admin_setting_configtext('block_twitter_search/defaultsearch',
                   get_string('defaultsearch', 'block_twitter_search'),
                   get_string('configdefaultsearch', 'block_twitter_search'), '#moodle', PARAM_TEXT));

$settings->add(new admin_setting_configselect('block_twitter_search/defaultnumtweets',
                   get_string('defaultnumtweets', 'block_twitter_search'),
                   get_string('configdefaultnumtweets', 'block_twitter_search'), 10, range(0, 20)));

$settings->add(new admin_setting_configtext('block_twitter_search/defaultpolltime',
                   get_string('defaultpolltime', 'block_twitter_search'),
                   get_string('configdefaultpolltime', 'block_twitter_search'), '30000', PARAM_INT));