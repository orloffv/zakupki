<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Builder extends Jelly_Core_Builder {

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
}