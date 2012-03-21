<div class="alert <?=$new_items > 0 ? 'alert-success': ''?>">
    <a class="close" data-dismiss="alert">×</a>
    <?=Text::ru_num($new_items, 'нов', 'ое', 'ых', 'ых', 'нет новых')?>, <a href="/home/update">обновить</a>
</div>
<blockquote style="margin: 0px;"><small>последняя <a href="/log/">проверка</a> <?=date('d.m.y H:i', $last_check->dt_create)?>, <?=$last_check->status?></small></blockquote>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Название</th>
            <th>Тип</th>
            <th>Цена</th>
            <th>Дата</th>
            <th width="310px">Заказчик</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($items as $item):?>
            <tr>
                <td>
                    <a title="<?=$item->title?>" href="http://zakupki.gov.ru/pgz/public/action/orders/info/common_info/show?notificationId=<?=$item->owner_id?>">
                        <?=Text::limit_chars($item->title, 160)?>
                    </a>
                </td>
                <td><?=__($item->type)?></td>
                <td><?=number_format($item->price)?></td>
                <td><nobr><?=date('d.m.y H:i', $item->date)?></nobr></td>
                <td><span title="<?=$item->customer?>"><?=Text::limit_chars($item->customer, 75)?></span></td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?=$pagination?>