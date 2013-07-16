<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform view, view details action
                'controllers' => array('product', 'rfq', 'user'),
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow all users to perform 'create' actions on user
                'controllers' => array('user'),
                'actions' => array('create'),
                'users' => array('?'),
            ),
            array('allow', // allow authenticated user to perform 'create' and'addUser' actions
                'controllers' => array('product', 'rfq', 'user'),
                'actions' => array('create', 'addUser'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete'actions
                'controllers' => array('product', 'rfq', 'user'),
                'actions' => array('admin', 'delete', 'update'),
                'roles' => array('admin'),
            ),
            array('deny', // deny all users
                'controllers' => array('product', 'rfq', 'user'),
                'users' => array('*'),
            ),
        );
    }

}