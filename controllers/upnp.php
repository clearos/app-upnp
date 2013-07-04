<?php

/**
 * UPnP controller.
 *
 * @category   apps
 * @package    upnp
 * @subpackage controllers
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
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * UPnP controller.
 *
 * @category   apps
 * @package    upnp
 * @subpackage controllers
 * @author     Peter Baldwin <pbaldwin@clearfoundation.com>
 * @copyright  2013 Peter Baldwin
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/upnp/
 */

class UPnP extends ClearOS_Controller
{
    /**
     * UPnP base controller.
     *
     * @return view
     */

    function index()
    {
        // Load libraries
        //---------------

        $this->lang->load('upnp');

        // Load views
        //-----------

        $views = array('upnp/server', 'upnp/settings');

        $this->page->view_controllers($views, lang('upnp_app_name'));
    }
}
