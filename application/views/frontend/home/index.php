<table class="table table-striped">
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Цена</th>
        <th>Дата</th>
        <th>Заказчик</th>
    </tr>
    <?php foreach($items as $item):?>
        <tr>
            <td>
                <a href="http://zakupki.gov.ru/pgz/public/action/orders/info/common_info/show?notificationId=<?=$item->owner_id?>">
                    <?=$item->title?>
                </a>
            </td>
            <td><?=__($item->type)?></td>
            <td><?=number_format($item->price)?></td>
            <td><?=date('d.m.y H:i', $item->date)?></td>
            <td><?=$item->customer?></td>
        </tr>
    <?php endforeach;?>
</table>
    <?=$pagination?>