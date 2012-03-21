<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cli_Git extends Controller_Cli {

    public function action_pull()
    {
        $this->write(Git::factory()->pull());
    }

    public function action_pull_submodules()
    {
        $this->write(Git::factory()->run("submodule foreach git pull"));
    }
}
