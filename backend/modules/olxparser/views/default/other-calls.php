<?php

use yii\helpers\Url;
use app\modules\olxparser\olxParserHelper;


/** @var app\modules\olxparser\models\ParsercdSearch $searchModel  */
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

if( !empty($count_pages_list) ){ ?>
    <div class="colLeft">

        <?php if( (int)$count_pages_list != (int)$count_true_pages_list ){ ?>

            <p>
                Общее количество страниц "<?php echo $count_pages_list; ?>"<br>
                Общее количество распаршенных страниц "<?php echo $count_true_pages_list; ?>"<br>
                Общее количество ожидающих парсинга страниц "<?php echo $count_false_pages_list; ?>"<br>

                За текущую итерацию было обработанно "<?php echo $count_parsing_page; ?>" страниц.<br>
                Из них:<br>
                - успешно "<?php echo (int)$count_parsing_page - (int)$count_fail_parsing_page; ?>" страниц<br>
                - не успешно "<?php echo $count_fail_parsing_page; ?>" страниц<br>

                На данный момент в базе "<?php echo $flats; ?>" уникальных ссылок.</p>

            <form method="POST" action="<?= Url::to(['handler']) ?>">
                <table>
                    <tr>
                        <td>
                            <strong>Процесс парсинга страниц не закончен. Продолжить парсинг?</strong>
                            <div class="margin-top-button">
                                <input type="hidden" name="continue" value="1">
                                <input type="hidden" name="<?= Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                                <input type="submit" name="startparsing" value="Продолжить парсинг страниц">
                            </div>
                            <br>
                            <div style="color: red;">Процес может занять некоторое время</div>
                        </td>
                    </tr>
                </table>
            </form><?php
        }else{ ?>

                <h3>Процесс парсинга страниц закончен.</h3>

            <?php
        } ?>
    </div>

    <div class="colRg">


        <?php

        if( (int)$flats != (int)$count_true_links_list ){

        $btn_value = "Начать парсинг уникальных ссылок";
        $count_false_links_list = 0;
        if($count_true_links_list) {
            $btn_value = "Продолжить парсинг уникальных ссылок";

            // Колличество уникальных ссылок, ожидающих обработки
            $count_false_links_list = (int)$flats - (int)$count_true_links_list;
        ?>

            <p>Общее количество уникальных ссылок "<?php echo $flats; ?>"<br>
                Общее количество распаршенных уникальных ссылок "<?php echo $count_true_links_list; ?>"<br>
                Общее количество ожидающих парсинга уникальных ссылок "<?php echo $count_false_links_list; ?>"<br>

                За текущую итерацию было обработанно "<?php echo $count_apartment_parsing; ?>" уникальных ссылок.<br>
                Из них:<br>
                - успешно "<?php echo (int)$count_apartment_parsing - (int)$count_fail_apartment_parsing; ?>" уникальных ссылок<br>
                - не успешно "<?php echo $count_fail_apartment_parsing; ?>" уникальных ссылок<br></p>

            <?php

        } else {

            ?>
            <h2>
                Начать индивидуальный парсинг каждой уникальной ссылки?
            </h2>

            <?php
        }
            ?>

        <form method="POST" action="<?= Url::to(['handler-unique-links']) ?>">
        <table>
            <tr>
                <td>
                    <div class="margin-top-button">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                        <input type="submit" name="startUniqueParsing" value="<?php echo $btn_value; ?>">
                    </div>
                    <br>
                    <div style="color: red;">Процес может занять некоторое время</div>
                </td>
            </tr>
        </table>
        </form><?php
    }else{ ?>
        <div style="color: red;">
            <h3>Процесс парсинга уникальных ссылок закончен.<br>Далее можем просмотреть результаты парсинга.</h3>
        </div><?php
    }
    if( $count_true_links_list != 0 ){ ?>

        <span class="showTable">Показать таблицу</span>
        <a href="<?= Url::to(['/olxparser/compare/index']) ?>">
            <span class="showTable">Отсеять объявления</span>
        </a>

        <?php
    }
    // } ?>
    </div>

    <?php

    if( olxParserHelper::tableExists('new_parser_olx_parsercd') ){
        echo $this->render('result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    ?>

    <?php
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

<span class='fixedFormButton'></span>
<div class='formCont'>
    <form>
        <i class='closeFormButt'></i>
        <label>Очистить базу данных?</label>
        <div>Данный процесс очищает базу данных от всей ранее собранной информации</div>
        <input class='clearButton' type='button' value='Да'>
        <span class='closeForm'>Нет</span>
    </form>
</div>
<div class='cresrPopup'>
    <form method="POST" action="<?= Url::to(['handler-drop-tables']) ?>">
        <p>Вы точно уверены?</p>
        <input type="hidden" name="<?= Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
        <input class='clearButtonSecPopup' type='submit' value='Да'>
        <span class='closeFormSecPopup'>Нет</span>
    </form>
</div>

