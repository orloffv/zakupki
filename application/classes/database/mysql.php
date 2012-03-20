<?php defined('SYSPATH') or die('No direct script access.');

class Database_MySQL extends Kohana_Database_MySQL {

    public function connect()
    {
        $parent =  parent::connect();
        /*
        if (Kohana::$environment == Kohana::DEVELOPMENT)
        {
            $this->query(NULL, 'SET query_cache_type = OFF');
            $this->query(NULL, 'FLUSH STATUS');
        }
        */
        return $parent;
    }

    public function disconnect()
    {
        /*
        if (Kohana::$environment == Kohana::DEVELOPMENT)
        {
            $status = $this->query(Database::SELECT, "SHOW SESSION STATUS LIKE 'handler_%'");

            foreach ($status as $key => $value)
            {
                if (Arr::get($value, 'Variable_name') == 'Handler_read_rnd_next')
                {
                    var_dump(Arr::get($value, 'Value'));
                }
            }
        }
        */

        return parent::disconnect();
    }
}