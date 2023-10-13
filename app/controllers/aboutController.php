<?php
require_once './app/views/aboutView.php';
require_once './app/helpers/authHelper.php';
class aboutController{
    private $view;

    public function __construct() {
        $this->view = new aboutView();
    } 

    public function showAbout() {
        $this->view->showAbout();
    }
}
?>