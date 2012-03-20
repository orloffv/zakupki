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
            ->offset($pagination->offset)->execute()->as_array();
    }

    /**
     * Постраничный вывод
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function paging($limit, $offset)
    {
        return $this->limit($limit)->offset($offset)->execute();
    }
}