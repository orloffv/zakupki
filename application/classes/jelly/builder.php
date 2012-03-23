<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Builder extends Jelly_Core_Builder {

    private $order;

    /**
     * Постраничный вывод
     * @param &string $target
     * @param array $limit
     * @param array $config
     * @return array
     */
    public function ln_paging(&$target = FALSE, $limit = NULL, $config = array())
    {
        if ( ! is_null($limit))
        {
            $config['items_per_page'] = $limit;
        }

        $pagination = System::paging($this->meta()->table(), $this->count(), $config);

        if ($target !== FALSE)
        {
            $target = $pagination->render();
        }
        return $this
            ->limit($limit ? $limit : $pagination->items_per_page)
            ->offset($pagination->offset)->execute();
    }

    /**
     * Постраничный вывод
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function paging(Pagination $pagination)
    {
        return $this->limit($pagination->items_per_page)->offset($pagination->offset)->execute();
    }

    public function set_order(Order $order = null)
    {
        $this->order = $order;
    }

    public function execute($db = NULL, $type = NULL, $ignored = NULL)
	{
        $type === NULL AND $type = $this->_type;

        if (Database::SELECT == $type)
        {
            if ($this->order && $this->order->get_field())
            {
                $this->_order_by = array();
                $this->order_by($this->order->get_field(), $this->order->get_direction());
            }
        }

        return parent::execute($db, $type, $ignored);
    }
}