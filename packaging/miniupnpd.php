<?php

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('miniupnp');

///////////////////////////////////////////////////////////////////////////////
// C O N F I G L E T
///////////////////////////////////////////////////////////////////////////////

$configlet = array(
	'title' => lang('miniupnp_app_name'),
	'package' => 'miniupnpd',
	'process_name' => 'miniupnpd',
	'pid_file' => '/var/run/miniupnpd.pid',
	'reloadable' => FALSE,
	'url' => '/app/miniupnp'
);