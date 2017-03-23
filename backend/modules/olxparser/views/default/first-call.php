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
    <form method="POST" action="<?= Url::to(['default/handler']) ?>">
        <table>
            <tr>
                <td>
                    <div class="margin-top-button">
                        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                        <input type="submit" name="startparsing" value="Запустить работу парсера">
                    </div>
                    <br><div style="color: red;">Процес может занять некоторое время</div>
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="hellopreloader"><div id="hellopreloader_preload"></div></div>

<div class="colRg">

</div>

<?php

if(olxParserHelper::tableExists('new_parser_olx_parsercd')){
    echo $this->render('result', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}