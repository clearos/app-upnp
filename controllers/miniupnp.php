<?php

/**
 * MiniUPnP controller.
 *
 * @category   Apps
 * @package    MiniUPnP
 * @subpackage Views
 * @author     Your name <your@e-mail>
 * @copyright  2013 Your name / Company
 * @license    Your license
 */

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * MiniUPnP controller.
 *
 * @category   Apps
 * @package    MiniUPnP
 * @subpackage Controllers
 * @author     Your name <your@e-mail>
 * @copyright  2013 Your name / Company
 * @license    Your license
 */

class MiniUPnP extends ClearOS_Controller
{
    /**
     * MiniUPnP default controller.
     *
     * @return view
     */

    function index()
    {
        // Load dependencies
        //------------------

        $this->lang->load('miniupnp');

        // Load views
        //-----------

        $this->page->view_form('miniupnp', NULL, lang('miniupnp_app_name'));
    }
}
