<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cli_Cron extends Controller_Cli_Template {

    public function action_prices()
    {
        Cron_Prices::factory()->run();
    }
}
