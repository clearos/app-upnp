<?php

/**
 * UPnP settings controller.
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
 * UPnP settings controller.
 *
 * @category   apps
 * @package    upnp
 * @subpackage controllers
 * @author     Peter Baldwin <pbaldwin@clearfoundation.com>
 * @copyright  2013 Peter Baldwin
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/upnp/
 */

class Settings extends ClearOS_Controller
{
    /**
     * PPTPd settings controller
     *
     * @return view
     */

    function index()
    {
        $this->_common('view');
    }

    /**
     * Edit view.
     *
     * @return view
     */

    function edit()
    {
        $this->_common('edit');
    }

    /**
     * View view.
     *
     * @return view
     */

    function view()
    {
        $this->_common('view');
    }

    /**
     * Common handler.
     *
     * @param string $form_type form type
     *
     * @return view
     */

    function _common($form_type)
    {
        // Load dependencies
        //------------------

        $this->lang->load('upnp');
        $this->load->library('upnp/MiniUPnP');

        // Set validation rules
        //---------------------
         
        $this->form_validation->set_policy('nat_pmp', 'upnp/MiniUPnP', 'validate_state');
        $this->form_validation->set_policy('secure_mode', 'upnp/MiniUPnP', 'validate_state');
        $form_ok = $this->form_validation->run();

        // Handle form submit
        //-------------------

        if (($this->input->post('submit') && $form_ok)) {
            try {
                $this->miniupnp->set_nat_pmp_state($this->input->post('nat_pmp'));
                $this->miniupnp->set_secure_mode_state($this->input->post('secure_mode'));
                $this->miniupnp->reset(TRUE);

                $this->page->set_status_updated();
            } catch (Exception $e) {
                $this->page->view_exception($e);
                return;
            }
        }

        // Load view data
        //---------------

        try {
            $data['form_type'] = $form_type;
            $data['nat_pmp'] = $this->miniupnp->get_nat_pmp_state();
            $data['secure_mode'] = $this->miniupnp->get_secure_mode_state();
        } catch (Exception $e) {
            $this->page->view_exception($e);
            return;
        }

        // Load views
        //-----------

        $this->page->view_form('upnp/settings', $data, lang('base_settings'));
    }
}
