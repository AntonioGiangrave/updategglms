<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;
require_once JPATH_COMPONENT_ADMINISTRATOR . '/models/libs/FirePHPCore/fb.php';

jimport('joomla.database.table');

class gglmsTableConfigs extends JTable {

    function __construct(&$db) {
        parent::__construct('#__gg_configs', 'id', $db);
    }



}
