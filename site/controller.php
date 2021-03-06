<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once 'libraries/FirePHPCore/fb.php';
require_once JPATH_COMPONENT . '/helpers/output.php';
require_once JPATH_COMPONENT . '/helpers/utility.php';
require_once JPATH_COMPONENT . '/models/contenuto.php';
require_once JPATH_COMPONENT . '/models/unita.php';
require_once JPATH_COMPONENT . '/models/users.php';

jimport('joomla.application.component.controller');
jimport('joomla.access.access');


class gglmsController extends JControllerLegacy {

    private $_user;
    private $_japp;
    public  $_params;

    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->_japp = JFactory::getApplication();


        define('PATH_PRINCIPALE', '../mediagg/');
        define('PATH_CONTENUTI', '../mediagg/contenuti/');


      

        JHtml::_('jquery.framework');
        JHtml::script(Juri::base() . 'components/com_gglms/libraries/js/mediaelement-and-player.js');

        JHtml::_('stylesheet', 'components/com_gglms/libraries/css/unita.css');
        JHtml::_('stylesheet', 'components/com_gglms/libraries/css/contenuto.css');
        JHtml::_('stylesheet', 'components/com_gglms/libraries/css/adeguamento_old_gantry.css');
        JHtml::_('stylesheet', 'components/com_gglms/libraries/css/mediaelementplayer.css');

        JHtml::_('script','components/com_gglms/js/mediaelement-and-player.js');


        
        $this->_params = $this->_japp->getParams();

        $this->_user =   JFactory::getUser();

        if ($this->_user->guest) {
            //TODO Personalizzare il messaggio per i non registrati
            $msg = "Per accedere al corso è necessario loggarsi";
            //TODO Sistemare per fare in modo che dopo il login torni al corso
            $uri      = JUri::getInstance();
            $return      = $uri->toString();
            $url  = 'index.php?option=com_users&view=login';
            $url .= '&return='.base64_encode($return);
            $this->_japp->redirect(JRoute::_($url), $msg);
        }

        $this->registerTask('returnfromjoomlaquiz', 'returnfromjoomlaquiz');
        $this->registerTask('attestato', 'attestato');
    }


    public function returnfromjoomlaquiz() {

        $db = & JFactory::getDbo();
        $app = &JFactory::getApplication();

        $getdata = $app->input->get;
        $quiz_id=$getdata->get('quiz_id');



        $query = $db->getQuery(true)
            ->select('u.alias')
            ->from('#__gg_unit u')
            ->innerJoin('#__gg_unit_map m on m.idunita=u.id')
            ->innerJoin('#__gg_contenuti c on c.id=m.idcontenuto')
            ->where("c.path = " . $quiz_id);

        echo (string)$query;

        $db->setQuery((string) $query);
        $res = $db->loadResult();

        $msg="";
        $url  = 'index.php?option=com_gglms&view=unita&alias='.$res;
        $app->redirect(JRoute::_($url), $msg);

        // echo json_encode($query);
        $app->close();
    }

    

}