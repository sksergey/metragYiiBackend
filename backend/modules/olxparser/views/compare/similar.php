<?php

/** @var app\modules\olxparser\models\Parsercd $item */
/** @var array $items */

?>

<table class="table table-bordered table-striped">

    <caption>Исходное объявление</caption>

    <thead>

    <tr>
        <th>Ссылка</th>
        <th>Номер телефона</th>
        <th>Количество комнат</th>
        <th>Этаж</th>
        <th>Этажность дома</th>
    </tr>

    </thead>

    <tr>

        <td><?= $item->path ?></td>
        <td><?= $item->phone ?></td>
        <td><?= $item->count_room ?></td>
        <td><?= $item->floor ?></td>
        <td><?= $item->floor_all ?></td>

    </tr>

</table>

Совпало:

<?php if ($item->status >= 2): ?>
    - номер телефона
<?php endif; ?>

<?php if ($item->status >= 3): ?>
    - количество комнат
<?php endif; ?>

<?php if ($item->status >= 4): ?>
    - этажность
<?php endif; ?>

<?php if ($item->status >= 5): ?>
    - этаж
<?php endif; ?>

<hr>

<?php if (empty($items)): ?>

    <p>
        Похожие объявления не найдены.
    </p>

<?php else: ?>

    <table class="table table-bordered table-striped">

        <caption>
            Найдено <b><?= count($items) ?></b> похожих объявлений.
        </caption>

        <thead>

        <tr>
            <th>Ссылка</th>
            <th>Номер телефона</th>
            <th>Количество комнат</th>
            <th>Этаж</th>
            <th>Этажность дома</th>
        </tr>

        </thead>

        <?php foreach ($items as $item): ?>

            <tr>

                
                <td><?= str_replace('href=', 'target="_blank" href=', $item['name']) ?></td>
                <td><?= $item['phone'] ?></td>
                <td><?= $item['komnat'] ?></td>
                <td><?= $item['etaj'] ?></td>
                <td><?= $item['etajnost'] ?></td>

            </tr>

        <?php endforeach; ?>

    </table>

<?php endif; ?>
