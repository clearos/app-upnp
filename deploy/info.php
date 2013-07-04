<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'upnp';
$app['version'] = '1.0.0';
$app['release'] = '1';
$app['vendor'] = 'Peter Baldwin';
$app['packager'] = 'Peter Baldwin';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('upnp_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('upnp_app_name');
$app['category'] = lang('base_category_network');
$app['subcategory'] = lang('base_subcategory_infrastructure');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['upnp']['title'] = $app['name'];
$app['controllers']['settings']['title'] = lang('base_settings');
$app['controllers']['server']['title'] = lang('base_server');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['requires'] = array(
    'app-network',
);

$app['core_requires'] = array(
    'miniupnpd',
);

$app['core_directory_manifest'] = array(
    '/var/clearos/upnp' => array(),
    '/var/clearos/upnp/backup' => array(),
);

$app['core_file_manifest'] = array(
    'miniupnpd.php'=> array('target' => '/var/clearos/base/daemon/miniupnpd.php'),
);

$app['delete_dependency'] = array(
    'app-upnp-core',
    'miniupnpd',
);

