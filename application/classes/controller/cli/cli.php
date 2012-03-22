<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cli_Cli extends Controller_Cli {

    public function action_ls()
    {
    }

    public function action_error()
    {
        $uri = $this->request->param('id');
        $uri = base64_decode($uri);
        $this->write("'".$uri."' is not a command");
    }
}
