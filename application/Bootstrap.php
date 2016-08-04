<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	
	protected function _initView()
	{
    $view = new Zend_View();
    
    $view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
    //$view->jQuery()->setLocalPath('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js')
	//	 ->setUiLocalPath('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js');
    //$view->jQuery()->enable();
    //$view->jQuery()->uiEnable();
    $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
    $viewRenderer->setView($view);
    Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

    return $view;
	

	}

}

