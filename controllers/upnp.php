<?php

/**
 * MiniUPnP controller.
 *
 * @category   Apps
 * @package    MiniUPnP
 * @subpackage Controllers
 * @author     Peter Baldwin <pbaldwin@clearfoundation.com>
 * @copyright  2013 Peter Baldwin
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/miniupnp/
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
 * MiniUPnP controller.
 *
 * @category   Apps
 * @package    MiniUPnP
 * @subpackage Controllers
 * @author     Peter Baldwin <pbaldwin@clearfoundation.com>
 * @copyright  2013 Peter Baldwin
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/miniupnp/
 */

class MiniUPnP extends ClearOS_Controller
{
    /**
     * MiniUPnP base controller.
     *
     * @return view
     */

    function index()
    {
        // Load libraries
        //---------------

        $this->lang->load('miniupnp');

        // Load views
        //-----------

        $views = array('miniupnp/server', 'miniupnp/settings');

        $this->page->view_controllers($views, lang('miniupnp_app_name'));
    }
}
