<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.form.helper');

JFormHelper::loadFieldClass('list');

class JFormFieldlistaprerequisiti extends JFormFieldList {

    /**
     * A flexible category list that respects access controls
     *
     * @var		string
     * @since	1.6
     */
    public $type = 'listaprerequisiti';

    /**
     * Method to get a list of categories that respects access controls and can be used for
     * either category assignment or parent category assignment in edit screens.
     * Use the parent element to indicate that the field will be used for assigning parent categories.
     *
     * @return	array	The field option objects.
     * @since	1.6
     */
    protected function getOptions() {
        // Initialise variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id AS value,  a.titolo  AS text');
        $query->from('#__gg_contenuti AS a');
        $query->join('left', '#__gg_unit_map AS m ON m.idcontenuto= a.id');
        $query->join('left', '#__gg_unit AS u ON u.id= m.idunita');
        $query->order("u.id, m.ordinamento");

        $db->setQuery($query);

        $options = $db->loadObjectList();

        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }


        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);
        return $options;
    }



}
