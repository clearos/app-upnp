<?php

/**
 * UPnP server class.
 *
 * @category   Apps
 * @package    UPnP
 * @subpackage Libraries
 * @author     Peter Baldwin <pbaldwin@clearfoundation.com>
 * @copyright  2013 Peter Baldwin
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/upnp/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// N A M E S P A C E
///////////////////////////////////////////////////////////////////////////////

namespace clearos\apps\upnp;

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('upnp');

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

// Classes
//--------

use \clearos\apps\base\Daemon as Daemon;
use \clearos\apps\base\File as File;

clearos_load_library('base/Daemon');
clearos_load_library('base/File');

// Exceptions
//-----------

use \clearos\apps\base\Validation_Exception as Validation_Exception;

clearos_load_library('base/Validation_Exception');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * MiniUPnP server class.
 *
 * @category   Apps
 * @package    UPnP
 * @subpackage Libraries
 * @author     Peter Baldwin <pbaldwin@clearfoundation.com>
 * @copyright  2013 Peter Baldwin
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/upnp/
 */

class MiniUPnP extends Daemon
{
    ///////////////////////////////////////////////////////////////////////////////
    // C O N S T A N T S
    ///////////////////////////////////////////////////////////////////////////////

    const FILE_CONFIG = '/etc/miniupnpd/miniupnpd.conf';
    const FILE_LEASES = '/var/lib/miniupnpd/upnp.leases';

    ///////////////////////////////////////////////////////////////////////////////
    // M E M B E R S
    ///////////////////////////////////////////////////////////////////////////////

    protected $config = array();

    ///////////////////////////////////////////////////////////////////////////////
    // M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Pptp constructor.
     */

    public function __construct()
    {
        clearos_profile(__METHOD__, __LINE__);

        parent::__construct('miniupnpd');
    }

    /**
     * Returns list of active interfaces.
     *
     * @return array list of active PPTP connections
     * @throws Engine_Exception
     */

    public function get_leases()
    {
        clearos_profile(__METHOD__, __LINE__);

        $file = new File(self::FILE_LEASES);

        if (!$file->exists())
            return array();

        $leases = array();
        $leases_data = $file->get_contents_as_array();

        foreach ($leases_data as $lease_data) {
            $matches = array();
            if (preg_match('/^(.*):(.*):(.*):(.*):(.*):(.*)$/', $lease_data, $matches)) {
                $lease['protocol'] = $matches[1];
                $lease['external_port'] = $matches[2];
                $lease['ip'] = $matches[3];
                $lease['internal_port'] = $matches[4];
                $lease['lease_time'] = $matches[5];
                $lease['description'] = $matches[6];

                $leases[] = $lease;
            }
        }

        return $leases;
    }

    /**
     * Returns NAT-PMP state.
     *
     * @return boolean TRUE if NAT-PMP is enabled
     * @throws Engine_Exception
     */

    public function get_nat_pmp_state()
    {
        clearos_profile(__METHOD__, __LINE__);

        $this->_load_configuration();

        $state = (preg_match('/yes/', $this->config['enable_natpmp'])) ? TRUE : FALSE;

        return $state;
    }

    /**
     * Returns secure mode state.
     *
     * @return boolean TRUE if secure mode is enabled
     * @throws Engine_Exception
     */

    public function get_secure_mode_state()
    {
        clearos_profile(__METHOD__, __LINE__);

        $this->_load_configuration();

        $state = (preg_match('/yes/', $this->config['secure_mode'])) ? TRUE : FALSE;

        return $state;
    }

    /**
     * Sets NAT-PMP state.
     *
     * @param boolean $state state of NAT-PMP
     *
     * @return void
     * @throws Engine_Exception, Validation_Exception
     */

    public function set_nat_pmp_state($state)
    {
        clearos_profile(__METHOD__, __LINE__);

        Validation_Exception::is_valid($this->validate_state($state));

        $state_value = ($state) ? 'yes' : 'no';

        $this->_set_parameter('enable_natpmp', $state_value);
    }

    /**
     * Sets NAT-PMP state.
     *
     * @param boolean $state state of NAT-PMP
     *
     * @return void
     * @throws Engine_Exception, Validation_Exception
     */

    public function set_secure_mode_state($state)
    {
        clearos_profile(__METHOD__, __LINE__);

        Validation_Exception::is_valid($this->validate_state($state));

        $state_value = ($state) ? 'yes' : 'no';

        $this->_set_parameter('secure_mode', $state_value);
    }

    ///////////////////////////////////////////////////////////////////////////////
    // V A L I D A T I O N   R O U T I N E S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Validation routine for boolean parameters.
     *
     * @param boolean $state state
     *
     * @return string error message if state invalid
     */

    public function validate_state($state)
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! clearos_is_valid_boolean($state))
            return lang('base_parameter_invalid');
    }

    ///////////////////////////////////////////////////////////////////////////////
    // P R I V A T E  M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Loads configuration.
     *
     * @return void
     * @throws Validation_Exception, Engine_Exception
     */

    protected function _load_configuration()
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! empty($this->config))
            return;

        $file = new File(self::FILE_CONFIG);

        if (! $file->exists())
            return array();

        $lines = $file->get_contents_as_array();

        foreach ($lines as $line) {
            $matches = array();

            if (preg_match('/^\s*#/', $line))
                continue;

            if (preg_match('/^\s*(.*)=(.*)\s*$/', $line, $matches))
                $this->config[$matches[1]] = $matches[2];

        }
    }

    /**
     * Sets parameter in configuration file.
     *
     * @param string $parameter parameter in options file
     * @param string $value     value for given parameter
     *
     * @access private
     * @return void
     */

    protected function _set_parameter($parameter, $value)
    {
        clearos_profile(__METHOD__, __LINE__);

        $file = new File(self::FILE_CONFIG);

        $match = $file->replace_lines("/^$parameter\s*=/i", "$parameter=$value\n");

        if (!$match)
            $file->add_lines("$parameter=$value\n");
    }
}
