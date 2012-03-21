<table class="table table-striped">
    <tr>
        <th>Дата</th>
        <th>Статус</th>
    </tr>
    <?php foreach($items as $item):?>
        <tr>
            <td><?=date('d.m.y H:i', $item->dt_create)?></td>
            <td><?=$item->status?></span></td>
        </tr>
    <?php endforeach;?>
</table>
<?=$pagination?>