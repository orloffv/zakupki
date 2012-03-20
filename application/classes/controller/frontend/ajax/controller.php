<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Ajax_Controller extends Controller_Frontend_Template {

    public $is_ajax = TRUE;
    public $is_json = TRUE;

    public function before()
    {
        if ( ! $this->request->current()->is_ajax())
        {
            throw new HTTP_Exception_403();
        }

        return parent::before();
    }

    public function after()
    {
        if ($this->auto_render === TRUE)
        {
            if ($this->is_json === TRUE)
            {
                $this->response->headers('Content-Type', 'application/json; charset='.Kohana::$charset);
                $this->response->body(json_encode((array) $this->context));
            }
            else
            {
                if (Kohana::find_file('views', $this->context_template) === FALSE)
                {
                    $this->context_template = 'backend/ajax/default';
                }

                $this->response->body(View::factory($this->context_template, (array) $this->context));
            }
        }
    }

}