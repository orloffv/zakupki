<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Validation_Exception extends Jelly_Core_Validation_Exception {

    public function errors($directory = '/', $translate = TRUE)
	{
		if ($directory !== NULL)
		{
			// Everything starts at $directory/$object_name
			//$directory .= '/'.$this->_object_name;
		}

        return $this->generate_errors($this->_alias, $this->_objects, $directory, $translate);
	}

    public function frontend_ajax($owner)
    {
        $owner->context['error'] = $this->errors('frontend');
    }
    
    public function frontend($owner)
    {
        $owner->context['form_errors'] = $this->errors('frontend');
        
        $owner->message('error', 'Пожалуйста, проверьте правильность заполнения формы.');
    }

    public function backend($owner)
    {
        if( ! $owner->is_action_delete())
        {
            if ($owner->is_action_create())
            {
                Message::error(Message::FAIL_CREATE);
            }
            elseif($owner->is_action_edit())
            {
                Message::error(Message::FAIL_UPDATE);
            }
            else
            {
                Message::error(Message::FAIL_UPDATE);
            }

            $owner->form_errors = $this->errors('validation');
        }
    }
	
	public function widget($owner)
    {
        $owner->form_errors = $this->errors('frontend');
    }
}
