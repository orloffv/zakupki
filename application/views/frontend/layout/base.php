<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo Frontend::get_title();?></title>
    <?=View::factory('frontend/layout/head')?>
</head>
<body>
<?=$header?>
<content>
    <div class="container">
        <?=$content?>
        <?=$footer?>
    </div>
</content>
<?=View::factory('frontend/layout/profiler')?>

</body>
</html>
