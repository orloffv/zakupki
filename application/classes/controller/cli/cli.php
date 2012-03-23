<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cli_Cli extends Controller_Cli_Template {

    public function action_ls()
    {
        $files = File::get_files(__DIR__);

        $disallow = array('Controller_Cli_Cli', 'Controller_Cli_Template');

        echo "All available tasks:\n";

        foreach ($files as $file)
        {
            $file = pathinfo($file, PATHINFO_FILENAME);

            $class_name = "Controller_Cli_". Text::ucfirst($file);
            if (class_exists($class_name) && ! in_array($class_name, $disallow))
            {
                $methods = get_class_methods($class_name);

                foreach($methods as $method)
                {
                    if (substr($method, 0, 6) == 'action' AND $method != 'action_ls')
                    {
                        $this->write("{$file}/".substr($method, 7));
                    }
                }
            }
        }
    }

    public function action_error()
    {
        $uri = $this->request->param('id');
        $uri = base64_decode($uri);
        $this->write("'".$uri."' is not a command");
    }
}
