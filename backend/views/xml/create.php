
<?php if (isset($text_message)) { ?>
<div class="alert text-center alert-<?php echo $class_message ?>">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <?php echo $text_message ?>
</div>
<?php } ?>

<div class="tab-content active">
    <form method="post" id="form">
        <div>
            <input type="hidden" name="commercial" value="1">
            <input type="hidden" name="action">
            <?php if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "&s=1") !== false) { ?>
            <input type="hidden" name="back" value="<?php echo $_SERVER['HTTP_REFERER'] ?>">
            <?php } ?>
            <?php if(isset($_SESSION['back']) && strpos($_SESSION['back'], "&s=1") !== false) { ?>
            <input type="hidden" name="back" value="<?php echo $_SESSION['back'] ?>">
            <?php } ?>
            <?php unset($_SESSION['back']); ?>
            <div class="row-fluid">
                <div class="span12">
                    <div class="control-group">
                        <?php if ($timestamp){ ?>
                        <p>Дата последнего обновления: <?php echo $timestamp ?></p>
                        <?php } ?>
                        <h5>Активные XML:</h5>
                        <p><a target="_blank" href="/xml/besplatka.xml">Бесплатка</a></p>
                        <p><a target="_blank" href="/xml/mesto.xml">mesto.ua</a></p>
                        <p><a target="_blank" href="/xml/est.xml">est.ua</a></p>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="control-group">
                        <h5>Просмотр объявлений добавленных в XML:</h5>
                        <p><a target="_blank" href="index.php?page=xmldetail&site=besplatka">Бесплатка</a></p>
                        <p><a target="_blank" href="index.php?page=xmldetail&site=mesto">mesto.ua</a></p>
                        <p><a target="_blank" href="index.php?page=xmldetail&site=est">est.ua</a></p>
                    </div>
                </div>
            </div>
            <div class='row-fluid'>
                <div class="span12">
                    <div class="control-group">
                        <h5>Статус формирования XML:</h5>
                        <?php if (isset($xml_success) && $xml_success) foreach ($xml_success as $one_success) echo $one_success . "<br>" ?>
                    </div>
                </div>
            </div>
            <div class='row-fluid'>
                <div class="span12">
                    <div class="control-group">
                        <h5>Лог ошибок:</h5>
                        <?php if (isset($errors) && $errors) foreach ($errors as $error) foreach ($error as $row_err) echo $row_err . "<br>" ?>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <a id="apply" class="btn btn-info">Сформировать</a>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    jQuery('#apply').click(function () {
        jQuery('input:hidden[name=action]').val('apply');
        jQuery('#form').submit();
    });
</script>