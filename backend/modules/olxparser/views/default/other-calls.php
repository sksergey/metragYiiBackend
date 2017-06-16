<?php

use yii\helpers\Url;
use app\modules\olxparser\olxParserHelper;


/** @var app\modules\olxparser\models\ParserSearch $searchModel  */
/** @var yii\data\ActiveDataProvider $dataProvider  */

/** @var array $data */

/** @var int $count_pages_list */
/** @var int $count_true_pages_list */
/** @var int $flats */
/** @var int $count_true_links_list */
?>

    <div class="row">
        <div class="col-md-2 col-md-offset-10">
            <a href="<?= Url::to(['/olxparser/default/params']) ?>" class="btn btn-success">Настройки</a>
        </div>
    </div>

<?php

$count_parsing_page = $data['count_parsing_page'];
$count_fail_parsing_page = $data['count_fail_parsing_page'];
$count_apartment_parsing = $data['count_apartment_parsing'];
$count_fail_apartment_parsing = $data['count_fail_apartment_parsing'];

// Колличество страниц, ожидающих обработки
$count_false_pages_list = (int) $count_pages_list - (int) $count_true_pages_list;
?>

    <div class="colLeft">
        <form action="<?=Url::to(['default/clear-tables'])?>">
            <input type="submit" value="Очистить таблицы" class="btn btn-danger">
        </form>
        <br>
        <br>
        <br>
        <br>
        <button id="pageSearchStart" class="btn btn-success">Начать поиск страниц</button>
        <button id="linksParseStart" class="btn btn-success">Начать разбор ссылок</button>
        <br>
        <br>
        <div style="color: red;">Процес может занять некоторое время</div>
        <div class="messages" ></div>
        <div class="errors"></div>
        <br>
        <br>
        <br>
        <br>
    </div>

    <div class="colRg">


        <?php

        if( (int)$flats != (int)$count_true_links_list ){

        $btn_value = "Начать парсинг уникальных ссылок";
        $count_false_links_list = 0;
        if($count_true_links_list) {
            $btn_value = "Продолжить парсинг уникальных ссылок";
        ?>

            <p>Общее количество уникальных ссылок "<?php echo $flats; ?>"<br>
                Общее количество распаршенных уникальных ссылок "<?php echo $count_true_links_list; ?>"<br>
            <?php } ?>

        <?php
    }else{ ?>
        <div style="color: red;">
            <h3>Процесс парсинга уникальных ссылок закончен.<br>Далее можем просмотреть результаты парсинга.</h3>
        </div><?php
    }
    if( $count_true_links_list != 0 ){ ?>

        <!--<span class="showTable">Показать таблицу</span>-->
        <a href="<?= Url::to(['/olxparser/compare/index']) ?>">
            <span class="showTable">Отсеять объявления</span>
        </a>

        <?php
    }
    // } ?>
    </div>

    <?php

    if( olxParserHelper::tableExists('new_parser_olx_parser') ){
        echo $this->render('result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } else {
    ?>
    <p>
        Ссыли не были получены
    </p>

    <!-- Редирект на удаление пустых таблиц -->
    <meta http-equiv="refresh" content="10;URL=/olxparser/default/handler-drop-tables">

<?php
}
?>

<div id="hellopreloader"><div id="hellopreloader_preload"></div></div>

