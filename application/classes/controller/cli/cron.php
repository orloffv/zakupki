<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cli_Cron extends Controller_Cli_Template {

    public function action_zakupki()
    {
        Cron_Zakupki::factory()->run();
    }
}
