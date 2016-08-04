<?php

class CookiesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //provide specific content for this view script page for search engine
		$viewdesccontent = "Vantworks website cookie policy";
		
		$this->view->viewdesccontent = $viewdesccontent;
    }

	

}















