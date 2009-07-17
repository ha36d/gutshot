<?php
namespace Gutshot\Controllers;

/**
 * Display the "About" page.
 */
class AboutController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction(){

    }

    public function show404Action(){

    }
}
