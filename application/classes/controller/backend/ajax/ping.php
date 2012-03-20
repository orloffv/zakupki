<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Ajax_Ping extends Controller_Backend_Ajax_Controller {

    public function action_pong()
    {
        $this->context['status'] = (bool) $this->auth->logged_in();
    }

}