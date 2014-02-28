<?php
/**
 * @version     1.0.4
 * @package     com_filelinks
 * @copyright   Copyright (C) Helen 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Helen <heleneross@gmail.com> - http://bfgnet.de
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Editfiledetails controller class.
 */
class FilelinksControllerEditfiledetails extends JControllerForm
{

    function __construct() {
        $this->view_list = 'files';
        parent::__construct();
    }

}