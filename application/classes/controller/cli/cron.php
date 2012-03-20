<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cli_Cron extends Controller_Cli {

    public function action_ls()
    {
        echo "All available tasks:\n";
        $methods = get_class_methods($this);

        foreach($methods as $method)
        {
            $prefix = substr($method, 0, 7);
            if (substr($method, 0, 6) == 'action' AND $method != 'action_ls')
            {
                echo substr($method, 7)."\n";
            }
        }
    }

}
