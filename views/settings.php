<?php

/**
 * UPnP settings view.
 *
 * @category   apps
 * @package    upnp
 * @subpackage views
 * @author     Peter Baldwin <pbaldwin@clearfoundation.com>
 * @copyright  2013 Peter Baldwin
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/upnp/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->lang->load('base');
$this->lang->load('upnp');

///////////////////////////////////////////////////////////////////////////////
// Form handler
///////////////////////////////////////////////////////////////////////////////

if ($form_type === 'edit') {
    $read_only = FALSE;
    $buttons = array(
        form_submit_update('submit'),
        anchor_cancel('/app/upnp/settings'),
    );
} else {
    $read_only = TRUE;
    $buttons = array(
        anchor_edit('/app/upnp/settings/edit')
    );
}

///////////////////////////////////////////////////////////////////////////////
// Form
///////////////////////////////////////////////////////////////////////////////

echo form_open('upnp/settings');
echo form_header(lang('base_settings'));

echo field_toggle_enable_disable('nat_pmp', $nat_pmp, lang('upnp_nat_pmp'), $read_only);
echo field_toggle_enable_disable('secure_mode', $secure_mode, lang('upnp_secure_mode'), $read_only);

echo field_button_set($buttons);

echo form_footer();
echo form_close();
