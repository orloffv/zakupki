<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Builder extends Jelly_Core_Builder {

    /**
     * Постраничный вывод
     * @param &string $target
     * @param array $limit
     * @param array $config
     * @return array
     */
    public function my_paging(&$target = FALSE, $limit = NULL, $config = array())
    {
        if ( ! is_null($limit))
        {
            $config['items_per_page'] = $limit;
        }

        $pagination = Frontend::paging($this->meta()->table(), $this->count(), $config);

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

    public function count($db = NULL)
    {
        $db   = $this->_db($db);
        $meta = $this->_meta;

        // Trigger callbacks
        $meta AND $meta->events()->trigger('builder.before_select', $this);

        // Start with a basic SELECT
        $query = $this->_build(Database::SELECT)->as_object(FALSE);


        // Dump a few unecessary bits that cause problems
        $query->_order_by = array();

        // Find the count
        $result = (int) $query
            ->select(array('COUNT("*")', 'total'))
            ->execute($db)
            ->get('total');

        // Trigger after_query callbacks
        $meta AND $meta->events()->trigger('builder.after_select', $this);

        return $result;
    }
}