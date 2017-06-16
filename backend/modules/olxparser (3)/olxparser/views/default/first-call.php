<?php

use app\modules\olxparser\olxParserHelper;
use yii\helpers\Url;

/** @var app\modules\olxparser\models\ParsercdSearch $searchModel  */
/** @var yii\data\ActiveDataProvider $dataProvider  */

?>
<div class="row">
    <div class="col-md-2 col-md-offset-10">
        <a href="<?= Url::to(['/olxparser/default/params']) ?>" class="btn btn-success">Настройки</a>
    </div>
</div>
<div class="colLeft">
    <h2>На данный момент база данных пуста.</h2>
    <h3>Начать процесс парсинга?</h3>

    <form action="<?=Url::to(['default/clear-tables'])?>">
        <input type="submit" value="Очистить таблицы">
    </form>
    <br>
    <br>
    <br>
    <br>

<!--    <form action="--><?//=Url::to(['default/get-pages'])?><!--">-->
<!--        <input type="submit" value="Начать поиск страниц">-->
<!--    </form>-->

    <button id="pageSearchStart">Начать поиск страниц</button>

    <button id="request">Запросить данные с сервера</button>

    <form action="<?=Url::to(['default/get-pages'])?>">
        <input type="hidden" name="continue">
        <input type="submit" value="Продолжить поиск">
    </form>

    <br>

    <form action="<?=Url::to(['default/get-pages'])?>">
        <input type="hidden" name="continue">
        <input type="submit" value="Начать обработку объектов">
    </form>

    <form method="POST" action="<?= Url::to(['default/handler']) ?>">
        <table>
            <tr>
                <td>
                    <div class="margin-top-button">
                        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                        <input type="submit" name="startparsing" value="Запустить работу парсера">
                    </div>
                    <br>
                    <div style="color: red;">Процес может занять некоторое время</div>
                    <div class="messages">
                                ****
                    </div>

                    <div class="errors">
                        ****
                    </div>
                </td>
            </tr>
        </table>
    </form>

    <br>
    <br>
    <br>
    <br>
    <br>

    <form action="<?=Url::to(['default/handle-apartments-links'])?>">
        <input type="submit" value="Начать обработку объектов недвижимости">
    </form>

</div>

<div id="hellopreloader"><div id="hellopreloader_preload"></div></div>

<div class="colRg">

</div>

<?php

if(olxParserHelper::tableExists('new_parser_olx_parser')){
    echo $this->render('result', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}