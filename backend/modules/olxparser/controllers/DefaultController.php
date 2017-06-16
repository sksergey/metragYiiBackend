<?php

namespace app\modules\olxparser\controllers;

use Exception;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;

use app\modules\olxparser\models\ParserSearch;
use app\modules\olxparser\models\ParserOlxParams;
use app\modules\olxparser\olxParserHelper;
use yii\web\Response;
use app\modules\olxparser\models\ParserOlxLog;


/**
 * CREATE TABLE `metragYiiNew`.`new_parser_olx_links_list` (
 * `link_id` INT NOT NULL AUTO_INCREMENT ,
 * `link` VARCHAR(255) NOT NULL ,
 * `status` ENUM('wait','ready') NOT NULL DEFAULT 'wait' ,
 * PRIMARY KEY (`link_id`)) ENGINE = InnoDB;
 * */


/**
 * Default controller for the `olxparser` module
 */
class DefaultController extends Controller
{
    /**
     * Logging
     * @param $object
     */
    private function log($object)
    {
        $dump = VarDumper::dumpAsString($object);;
        Yii::info($dump);
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        \app\modules\olxparser\OlxAssetsBundle::register($this->view);
        // создание таблицы с опциями
        if (false === olxParserHelper::tableExists('new_parser_olx_params')) {
           $this->paramsTableCreate();
        }
        $searchModel = new ParserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $result = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];

        if (olxParserHelper::tableExists('new_parser_olx_parser')) {
            // Количество уникальных ссылок в БД
            $flats = olxParserHelper::tableExists('new_parser_olx_links_list') ? Yii::$app->db->createCommand('SELECT COUNT(`link`) FROM `new_parser_olx_links_list`')->queryScalar() : 0;

            // Количество обработанных уникальных ссылок
            $count_true_links_list = olxParserHelper::tableExists('new_parser_olx_parser') ? Yii::$app->db->createCommand('SELECT COUNT(`advert_id`) FROM `new_parser_olx_parser`')->queryScalar() : 0;

            // Общее количество страниц
            $count_pages_list = Yii::$app->db->createCommand('SELECT COUNT(*) FROM `new_parser_olx_pages_list`')->queryScalar();

            // Общее количество распаршенных страниц
            $count_true_pages_list = Yii::$app->db->createCommand('SELECT COUNT(*) FROM `new_parser_olx_pages_list` WHERE `status` IS NOT NULL')->queryScalar();

            return $this->render('other-calls', [
                    'count_pages_list' => $count_pages_list,
                    'count_true_pages_list' => $count_true_pages_list,
                    'count_true_links_list' => $count_true_links_list,
                    'flats' => $flats
                ] + $result);
        }

        return $this->render('first-call', $result);
    }

    public function actionHandler()
    {
        // Инициализируем переменные
        $all_links = $all_links_flip = $unique_all_links = array();
        $total_page = $location_url = '';
        $countParsingPage = $countFailParsingPage = 0;

        extract(ParserOlxParams::params());

        // Инициализируем cURL-сессию
        // $cookie = tempnam ("/tmp", "CURLCOOKIE");
        //ini_set('max_execution_time', 0);
        //ini_set('memory_limit', '1024M');
        //ini_set('max_input_time', -1);
        $ch = curl_init();

        if (isset($_POST['continue']) && !empty($_POST['continue'])) {

            // Проверяем, есть ли ещё страницы для парсинга
            $sql = 'SELECT page_number FROM `new_parser_olx_pages_list` WHERE `status` IS NULL';
            $continue_parsing = Yii::$app->db->createCommand($sql)->queryColumn();

            if (!empty($continue_parsing)) {
                $count_list_proxy = count($list_proxy) - 1;
                $count_list_users_agents = count($list_users_agents) - 1;

                //proxy change
                // TODO first local - proxy - local
                $proxy_ip = $list_proxy[mt_rand(0, $count_list_proxy)];
                $proxy_ua = $list_users_agents[mt_rand(0, $count_list_users_agents)];

                $all_links_tmp = [];
                foreach ($continue_parsing as $i) {
                    /* Настраиваем опции */
                    curl_setopt($ch, CURLOPT_URL, "$root_url?page=$i");
                    curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
                    curl_setopt($ch, CURLOPT_USERAGENT, $proxy_ua);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HEADER, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_ENCODING, "");
                    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls

                    //Поехали!
                    $output = curl_exec($ch);
                    $status = curl_getinfo($ch);

                    ++$countParsingPage;

                    if ($status['http_code'] != 200 || $output === FALSE) {
                        ++$countFailParsingPage;
                        // $test[$i] = $status['redirect_url'];
                        continue;
                    }

                    if (preg_match($_pattern_search_container_offers_table, $output, $matches)) {
                        $container_offers_table = $matches['0'];
                        if (preg_match_all($_pattern_search_all_links, $container_offers_table, $links)) {
                            $items = [];
                            foreach ($links['1'] as $key => $link) {
                                $all_links_tmp[] = strstr($link, '#', true);
                                $items[] = [$key, true];
                            }

                            // Подготавливаем запрос для апдейта страничек
                            Yii::$app->db->createCommand()
                                ->update('new_parser_olx_pages_list', [
                                    'status' => true,
                                ], "page_number = {$i}")->execute();

//                            Yii::$app->db->createCommand()
//                                ->batchInsert('new_parser_olx_pages_list', ['page_number', 'status'], $items)
//                                ->execute();

                        }
                    }
                }

                // Получаем только уникальные ссылки
                $all_links = array_unique(array_diff($all_links_tmp, array('')));

                // Получаем все ранее записанные уникальные ссылки
                $all = Yii::$app->db->createCommand('SELECT `link` AS link, `status` AS status FROM `new_parser_olx_links_list`')->queryAll();
                $db_all_links = ArrayHelper::map($all, 'link', 'status');

                if (!empty($all_links)) {
                    $all_links_flip = array_flip($all_links);
                    $all_links = array();
                    foreach ($all_links_flip as $key => $value)
                        $all_links[$key] = NULL;

                    // Соединяем 2 массива в 1-н и получаем только уникальные ссылки
                    $unique_all_links = array_merge($all_links, $db_all_links);
                } else {
                    // Получаем только уникальные ссылки
                    $unique_all_links = $db_all_links;
                }

                // Очищаем таблицу для хранения уникальных ссылок
                Yii::$app->db->createCommand("TRUNCATE TABLE `new_parser_olx_links_list`")->execute();

                // Наполняем таблицу уникальными ссылками
                $items = [];
                foreach ($unique_all_links as $link => $status) {
                    $items[] = [$link, $status];
                }
                Yii::$app->db->createCommand()
                    ->batchInsert('new_parser_olx_links_list', ['link', 'status'], $items)
                    ->execute();

            }

            $total_page = Yii::$app->db->createCommand('SELECT `total_page` FROM `new_parser_olx_options` WHERE `id`=1')->queryScalar();

            // $location_url = ['/olxparser/default/index'];
            // $location_url = "https://oleg-test-project-lumospark.c9users.io/kr/index.php?page=parserolx&action=continue&do=";

        } else {

            // Создаём таблицу для хранения страниц, по которым мы уже пробежались и собрали уникальные ссылки
            Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS `new_parser_olx_pages_list` (
                    
					`page_url` TEXT NOT NULL,
					`status` tinyint(1) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8")->execute();

            // Создаём таблицу для хранения опций парсера
            Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS `new_parser_olx_options` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`total_page` int(11) DEFAULT NULL,
					`count_parsing_page` int(11) DEFAULT NULL,
					`count_fail_parsing_page` int(11) DEFAULT NULL,
					`count_apartment_parsing` int(11) DEFAULT NULL,
					`count_fail_apartment_parsing` int(11) DEFAULT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1")->execute();

            // и сразу заполняем её дефолтными значениями
            Yii::$app->db->createCommand("INSERT INTO `new_parser_olx_options` (`total_page`, `count_parsing_page`, `count_fail_parsing_page`, `count_apartment_parsing`, `count_fail_apartment_parsing`) VALUES (-1, -1, -1, -1, -1)")->execute();

            /* Проходим по первой странице и получаем все необходимые линки */
            /* Настраиваем опции */
            $count_list_proxy = count($list_proxy) - 1;
            $count_list_users_agents = count($list_users_agents) - 1;

            $proxy_ip = $list_proxy[mt_rand(0, $count_list_proxy)];
            $proxy_ua = $list_users_agents[mt_rand(0, $count_list_users_agents)];

            $this->log(sprintf('Use IP: `%s` and UA:`%s` for request to page `%s`. Max retry: %d.',
                $proxy_ip, $proxy_ua, $root_url, 0));

            curl_setopt($ch, CURLOPT_URL, "$root_url");
            // curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
            curl_setopt($ch, CURLOPT_USERAGENT, $proxy_ua);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls

            // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // curl_setopt($ch, CURLOPT_MAXREDIRS, 15);

            //Поехали!
            $output = curl_exec($ch);
            $status = curl_getinfo($ch);

            $this->log(sprintf('Response info: `%s`.', VarDumper::dumpAsString($status)));
            $this->log(sprintf('Response output: `%s`.', $output));

            if ($status['http_code'] != 200 || $output === FALSE) {
                // дописать проверку
            }

            /* Получаем общее количество страниц */
            if (preg_match($_pattern_search_total_pages, $output, $matches)) {
                $total_page = (int)$matches['1'] - 2;

                $items = [];
                for ($k = 1; $k <= $total_page; ++$k) {
                    $items[] = [$k, NULL];
                }
                Yii::$app->db->createCommand()
                    ->batchInsert('new_parser_olx_pages_list', ['page_number', 'status'], $items)
                    ->execute();

                // Получаем все уникальные ссылки с первой страницы
                if (preg_match($_pattern_search_container_offers_table, $output, $matches)) {
                    $container_offers_table = $matches['0'];
                    if (preg_match_all(stripcslashes($_pattern_search_all_links), $container_offers_table, $links)) {
                        foreach ($links['1'] as $key => $link) {
                            $all_links[] = strstr($link, '#', true);
                        }

                        Yii::$app->db->createCommand("UPDATE `new_parser_olx_pages_list` SET `status` = 1 WHERE page_number=1")->execute();
                    }
                }

                /* Проходимся по всем оставшимся страницам и собираем необходимые линки */
                if ((int)$total_page > 1) {
                    for ($i = 2; $i <= (int)$total_page; ++$i) {
                        curl_setopt($ch, CURLOPT_URL, "$root_url?page=$i");
                        curl_setopt($ch, CURLOPT_PROXY, $list_proxy[rand(0, $count_list_proxy)]);
                        curl_setopt($ch, CURLOPT_USERAGENT, $list_users_agents[rand(0, $count_list_users_agents)]);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_ENCODING, "");
                        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls

                        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        // curl_setopt($ch, CURLOPT_MAXREDIRS, 15);


                        //Поехали!
                        $output = curl_exec($ch);
                        $status = curl_getinfo($ch);

                        $countParsingPage = $i;

                        if ($status['http_code'] != 200 || $output === FALSE) {
                            ++$countFailParsingPage;
                            // $test[$i] = $status['redirect_url'];
                            continue;
                        }

                        if (preg_match($_pattern_search_container_offers_table, $output, $matches)) {
                            $container_offers_table = $matches['0'];
                            if (preg_match_all($_pattern_search_all_links, $container_offers_table, $links)) {
                                foreach ($links['1'] as $key => $link) {
                                    $all_links[] = strstr($link, '#', true);
                                }
                                Yii::$app->db->createCommand("UPDATE `new_parser_olx_pages_list` SET `status`=1 WHERE page_number=$i")->execute();
                            }
                        }
                    }
                }
            }

            // Получаем только уникальные ссылки
            $unique_all_links = array_unique(array_diff($all_links, array('')));

            // Создаём таблицу для хранения уникальных ссылок
            Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS `new_parser_olx_links_list` (
					`link_id` int(11) NOT NULL AUTO_INCREMENT,
					`link` varchar(255) NOT NULL,
					`status` tinyint(1) DEFAULT NULL,
					PRIMARY KEY (`link_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1")->execute();

            // Наполняем таблицу уникальными ссылками
            $items = [];
            foreach ($unique_all_links as $link) {
                $items[] = [$link, NULL];
            }
            Yii::$app->db->createCommand()
                ->batchInsert('new_parser_olx_links_list', ['link', 'status'], $items)
                ->execute();

            // $location_url = ['/olxparser/default/index'];
            // $location_url = "https://oleg-test-project-lumospark.c9users.io/kr/index.php?page=parserolx&action=continue&do=";
        }

        // Обновляем опции парсера
        Yii::$app->db->createCommand()
            ->update('new_parser_olx_options', [
                'total_page' => $total_page,
                'count_parsing_page' => $countParsingPage,
                'count_fail_parsing_page' => $countFailParsingPage
            ], 'id = 1')->execute();


        // Закрываем cURL-сессию
        curl_close($ch);
        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
        ini_set('max_input_time', 60);

        //header("Location: $location_url");
        //exit;
        return $this->redirect(['/olxparser/default/index']);
    }
    /**
     * @return \yii\web\Response
     * Запускает обработку всех ссылок на объекты
     */
    public function actionHandleUniqueLinks()
    {
        extract(ParserOlxParams::params());

        // Создаём таблицу для хранения информации с распаршенных страниц
        Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS `new_parser_olx_parser` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`advert_id` int(11) NOT NULL UNIQUE,
		`link` text NOT NULL,
		`path` text NOT NULL,
		`date` varchar(255) NOT NULL,
		`type_object_id` int(11) NOT NULL,
		`advert_from` varchar(255) NOT NULL,
		`type` varchar(255) NOT NULL,
		`type_flat` varchar(255) NOT NULL,
		`count_room` int(11) NOT NULL,
		`floor` int(11) NOT NULL,
		`floor_all` int(11) NOT NULL,
		`total_area` int(11) NOT NULL,
		`floor_area` int(11) NOT NULL,
		`kitchen_area` int(11) NOT NULL,
		`price` varchar(255) NOT NULL,
		`phone` text NOT NULL,
		`status` text NOT NULL,
		`note` text NOT NULL,
		`kolfoto` int(11) NOT NULL,
		`image` text NOT NULL,
		`view` enum('neprov','no','yes','tel') NOT NULL,
		`count_similar_advs` INT(11) NOT NULL DEFAULT 0,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1")->execute();

        // Инициализируем переменные
        $unique_all_links = $array_flat_properties = array();
        $link = $path = $date = $price = $note = $phone = $image = $advert_from = $type = $type_flat = '';
        $count_apartment_parsing = $count_fail_apartment_parsing = $advert_id = $kolfoto = $count_room = $floor = $floor_all = $total_area = $floor_area = $kitchen_area = 0;

        // Получаем все собранные на данный момент уникальные ссылки
        $unique_all_links = Yii::$app->db->createCommand('SELECT link FROM `new_parser_olx_links_list` WHERE `status` IS NULL')->queryColumn();

        if (!empty($unique_all_links)) {

            // Инициализируем cURL-сессию
            $ch = curl_init();
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '1024M');
            ini_set('max_input_time', -1);

            $count_list_proxy = count($list_proxy) - 1;
            $count_list_users_agents = count($list_users_agents) - 1;

            /* Цикл для прохождения по всем уникальным ссылкам */
            foreach ($unique_all_links as $apartment_link) {
                // Получаем содержимое страницы по заданному url
                /* Настраиваем опции */
                $proxy = $list_proxy[rand(0, $count_list_proxy)];
                $useragent = $list_users_agents[rand(0, $count_list_users_agents)];
                curl_setopt($ch, CURLOPT_URL, $apartment_link);
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_ENCODING, "");
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls

                //Поехали!
                $output = curl_exec($ch);
                $status = curl_getinfo($ch);

                ++$count_apartment_parsing;

                if ($status['http_code'] != 200 || $output === FALSE) {
                    ++$count_fail_apartment_parsing;
                    continue;
                }

                // Ссылка на объявление
                $link = $apartment_link;


                // Находим контейнер с необходимой информацией о заголовке объяления
                if (preg_match($_pattern_search_title_publication, $output, $matches)) {
                    $title_publication = trim(strip_tags($matches['1']));
                    $path = "<a href='$link' target='_blank'>$title_publication</a>";
                }

                // Находим контейнер с необходимой информацией о дате публикации и об ID объяления
                if (preg_match($_pattern_search_container_date_publication, $output, $matches)) {
                    $container_date_publication = $matches['0'];
                    if (preg_match($_pattern_search_date_publication, $container_date_publication, $matches)) {
                        $date_publication = $matches['1'];
                        $date = $date_publication;
                    }
                    if (preg_match($_pattern_search_ID_publication, $container_date_publication, $matches)) {
                        $id_publication = $matches['0'];
                        $advert_id = $id_publication;
                    }
                }

                // Находим контейнер с необходимой дополнительной информацией
                if (preg_match_all($_pattern_search_container_additional_info_key, $output, $matches_key)) {
                    foreach ($matches_key['0'] as $value_str) {
                        preg_match($_pattern_search_container_additional_info_value, $value_str, $matches_tmp);
                        $array_values[] = $matches_tmp['0'];
                    }
                    foreach ($matches_key['1'] as $key => $value) {
                        $array_flat_properties[$value] = trim(strip_tags($array_values[$key]));
                        /* Массив $array_flat_properties содержит всю необходимую доп. информацию */
                    }

                    // @se: была ошибка `Undefined index` из-за предыдущего кода
                    $prop = function ($key, $default) use ($array_flat_properties) {
                        if (isset($array_flat_properties[$key])) {
                            return $array_flat_properties[$key];
                        } else {
                            return $default;
                        }
                    };

                    $advert_from = $prop('Объявление от', '-');
                    $type = $prop('Тип', '-');
                    $type_flat = $prop('Тип квартиры', '-');
                    $count_room = $prop('Количество комнат', 0);
                    $floor = $prop('Этаж', 0);
                    $floor_all = $prop('Этажность дома', 0);
                    $total_area = $prop('Общая площадь', 0);
                    $floor_area = $prop('Жилая площадь', 0);
                    $kitchen_area = $prop('Площадь кухни', 0);
                }
                unset($array_values);

                // Находим контейнер с ценой
                if (preg_match($_pattern_search_container_price, $output, $matches)) {
                    $price = trim(strip_tags($matches['0']));
                }

                // Находим контейнер с описанием
                if (preg_match($_pattern_search_container_description, $output, $matches)) {
                    $note = trim(strip_tags($matches['0']));
                }

                /* ТЕЛЕФОННЫЙ НОМЕР */
                // Находим id номера телефона
                if (preg_match($_pattern_search_id_phone, $output, $matches)) {
                    $idphone = $matches['1'];
                }

                // Задаём необходимый url для работы Curl
                $url_address_phone = "{$url_phone}{$idphone}/";

                // Задаём опции для корректной работы Curl
                curl_setopt($ch, CURLOPT_URL, $url_address_phone);
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_ENCODING, "");
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls

                // Запускаем Curl
                $response = curl_exec($ch);

                // Разделяем строку полученного ответа по маркерам окончания строки
                $result_answer = explode("\r\n", $response);

                // Если ответ положительный ( код 200 ) - продолжаем получать номера телефонов
                if ($result_answer['0'] == "HTTP/1.1 200 OK") {
                    if (preg_match($_pattern_search_phone_value, $response, $matches)) {
                        if (preg_match_all($_pattern_only_phones, $matches['1'], $phones)) {
                            $phone = implode(", ", $phones['0']);
                        }
                    }
                } else {
                    $phone = "None";
                }

                // Находим все фотографии, относящиеся к данному объявлению
                if (preg_match_all($_pattern_all_photos, $output, $matches)) {
                    $kolfoto = count($matches['1']);
                    $image = serialize($matches['1']);
                }

                try {
                    // Наполняем таблицу распаршенными данными
                    Yii::$app->db->createCommand()
                        ->insert('new_parser_olx_parser', [
                            'advert_id' => $advert_id,
                            'link' => $link,
                            'path' => $path,
                            'date' => $date,
                            'type_object_id' => 12,
                            'advert_from' => $advert_from,
                            'type' => $type,
                            'type_flat' => $type_flat,
                            'count_room' => $count_room,
                            'floor' => $floor,
                            'floor_all' => $floor_all,
                            'total_area' => $total_area,
                            'floor_area' => $floor_area,
                            'kitchen_area' => $kitchen_area,
                            'price' => $price,
                            'phone' => $phone,
                            'status' => 1,
                            'note' => $note,
                            'kolfoto' => $kolfoto,
                            'image' => $image,
                            'view' => 'no',
                        ])->execute();
                } catch (Exception $e) {
                    continue;
                }

                Yii::$app->db->createCommand()
                    ->update('new_parser_olx_links_list', ['status' => 1], ['link' => $link])
                    ->execute();

                if ($count_apartment_parsing == $_count_true_pages_list) break;
            }
        }

        // Ссылка на перенаправление
        //$location_url = "https://oleg-test-project-lumospark.c9users.io/kr/index.php?page=parserolx&action=continue&do=";

        // Обновляем опции парсера
        Yii::$app->db->createCommand()
            ->update('new_parser_olx_options', [
                'count_apartment_parsing' => (int)$count_apartment_parsing,
                'count_fail_apartment_parsing' => (int)$count_fail_apartment_parsing,
            ], 'id = 1')->execute();

        // Закрываем cURL-сессию
        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
        ini_set('max_input_time', 60);
        curl_close($ch);

        return $this->redirect(['/olxparser']);
    }

    public function actionHandlerDropTables()
    {
        $sql = "DROP TABLE IF EXISTS `new_parser_olx_links_list`, `new_parser_olx_pages_list`, `new_parser_olx_parser`, `new_parser_olx_options`";
        Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect(['/olxparser/default/index']);
    }

    public function actionParams()
    {
        $post = Yii::$app->request->post('Params');
        if ($post) {
            foreach ($post as $name => $value) {
                Yii::$app->db->createCommand()->update('new_parser_olx_params', ['value' => $value], ['name' => $name, 'pack' => 1])->execute();
            }
        }

        $model = ParserOlxParams::findAll(['pack' => 1]);
        return $this->render('params', [
            'model' => $model
        ]);
    }


    public function beforeAction($action)
    {
        $css = <<<CSS
.colLeft {
    width: 50%;
    float: left;
}
.colRg {
    width: 50%;
    float: right;
}
#hellopreloader>p{display:none;}
#hellopreloader {
    display: block;
    width:100%;
    height:100%;
    z-index:9998;
    position:fixed;
    top:0;
    left:0;
    right:0;
    bottom: 0;
    background:rgba(0,0,0,.3);
}
.showTable {
    position:relative;
    display:inline-block;
    border: 1px solid #ccc;
    padding: 5px 20px;
    background: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 20px 0 10px;
}
#hellopreloader_preload{
    display: block;
    position: fixed;
    z-index: 99999;
    top: calc(50% - 50px);
    left: calc(50% - 50px);
    width: 100px;
    height: 100px;
    background: url(https://www.ppgvoiceofcolor.com/Content/images/loader.gif) center center no-repeat;
    background-size:cover;}
.fixedFormButton {
    display: block;
    position:absolute;
    width: 30px;
    height:30px;
    right: 20px;
    top: 65px;
    background: url(http://s1.iconbird.com/ico/2014/1/625/w128h1281390855539deletedatabase128.png);
    background-size: contain;
    cursor: pointer;
}    
.formCont {
   display: none;
   position:fixed;
   right: calc(50% - 200px);
   top: 30%;
   background: #eeeeee;
   width: 400px;
    height: auto;
    padding: 20px;
    box-sizing: border-box;
    text-align: center;
    font-size: 32px;
    border: 1px solid #919191;
} 
.formCont form > div {
    margin: 0 0 20px;
}
.formCont form {
    border: 1px solid #919191;
    padding: 10px 10px 10px;
}
.formCont label {
    font-size: 32px;
    display: block;
    margin: 0 0 20px;
    line-height: 30px;
}
.clearButton {
    background: #b2c3d0;
    border: 1px solid #000;
    font-size: 24px;
    padding: 5px 10px;
    display: inline-block;
    margin: 0 10px 0 0;
}
.closeFormButt {
    display:block;
    position:absolute;
    width:20px;
    height: 20px;
    top: 0;
    right: 0;
    background: url(https://d30y9cdsu7xlg0.cloudfront.net/png/52944-200.png);
    background-size: contain;
    cursor: pointer;
}
.closeForm {
    cursor: pointer;
}
.olx-table-result {
    border-collapse:  collapse;
    #display: none;
}
.olx-table-result th,
.olx-table-result td{
    border: 1px solid black;
    text-align: center;

}
.olx-table-result td div {
    height: 90px;
    overflow-Y:scroll;
}

.olx-table-result td {
   /*background: rgb(255, 255, 0);*/
}
/* Изменяем цвета строк в зависимости от статуса */
.status-1 {
   background: rgb(255, 255, 0);
}
.status-2 {
   background: #FFFFFF;
}
.status-3 {
   background: coral;
}
.status-4 {
   background: greenyellow;
}
.status-5 {
   background: #C4C4C4;
}

.olx-table-result td a {
    color: #0088cc;
}
.olx-table-result td a:hover {
    opacity: .7;
}
.tooltip {
    z-index:999;
    left:-9999px;
    top:-9999px;
    background:#fff;
    border:1px solid #ccc; 
    font-size:15px;
    color:#323232;
    padding:4px 8px;
    position:absolute;
}
.tooltip p {
    margin: 0px;
    padding: 0px;
}  
.olx-table-result tr td:nth-last-of-type(1) div {
    max-width: 300px;
}
#pag-link {
    display:none;
    width: 100%;
    margin: 20px 0 10px;
}
#pag-link  span {
    margin: 5px;
}
#pag-link a {
    font-size: 20px;
    line-height: 1.5;
    display: block;
    width: 32px;
    height: 32px;
    transition: all .8s;
    text-align: center;
    color: #000;
    border-radius: 120px;
    transition: all .3s;
}
#pag-link * {
    display:inline-block;
}
.pag-link-active {
     color: #fff!important;
    background-color: #4caf50;   
}
#pag-link a:hover {
    color: #fff!important;
    background-color: #4caf50;
}
.cresrPopup {
    display: none;
    position: fixed;
    top: 40%;
    background-color: #eee;
    width: 200px;
    left: calc(50% - 100px);
    padding: 10px;
    text-align: center;
    z-index: 9999;
}
.cresrPopup p {
    font-size: 16px;
    margin: 0 0 20px;
}
.closeFormSecPopup {
    cursor: pointer;
}
.table th, .table th a {
   white-space:pre-wrap; 
    
}
.table td,
.table th {
 vertical-align: middle !important;

}
.table td {
     text-shadow: 1px 1px 1px;
}
CSS;

        Yii::$app->view->registerCss($css);


        Yii::$app->view->registerJs(
            "var main_url = '" . Url::to(['default/get-pages']) . "';",
            \yii\web\View::POS_HEAD,
            'yiiOptions'
        );

        $js = <<<JS
        
        
$(document).ready(function(){
      $('[name = startparsing], [name = startUniqueParsing], a > .showTable').on('click', function(){
       $('#hellopreloader').show(); 
    });
    
    $('.colRg > .showTable').on('click', function(){
       
        $('.olx-table-result, .pagination').toggle();
        $('#pag-link').toggle();
        if($('.olx-table-result').is(':visible')){
            $(this).text('Скрыть таблицу'); 
        }
        else {
            $(this).text('Показать таблицу'); 
        }
    });
    $('.fixedFormButton').click(function(){
       $('.formCont').toggle(); 
    });
    $('.closeForm, .closeFormButt').click(function(){
        $('.formCont').hide();
    });
    // $('.olx-table-result td div').hover(function(){
        
    // });
 // function ('.olx-table-result td div', tooltip){
$('.tooltipTd').hover(function(){
    $('.tooltipTd').each(function(i){
        $("body").append("<div class='tooltip' id='"+tooltip+i+"'><p>"+$(this).text()+"</p></div>");
        var tooltip = $("#"+tooltip+i);
        if($(this).text() != "" && $(this).text() != "undefined" ){
            $(this).mouseover(function(){
                tooltip.css({opacity:0.9, display:"none"}).fadeIn(30);
        }).mousemove(function(kmouse){
                tooltip.css({left:kmouse.pageX-105, top:kmouse.pageY+15});
        }).mouseout(function(){
                tooltip.fadeOut(10);
        });
        }
    });
});
// l_tooltip($('.olx-table-result td div'), tooltip);  
  
  
  
})
$(window).load(function(){
    $('#hellopreloader').hide();
    //if($('.pagination .active a').text() == '11') {
    //    $('.olx-table-result, .pagination').hide();
    //}
    //else {
    //      $('.olx-table-result, .pagination').show();
    //}
    $('.clearButton').on('click', function(){
        $('.formCont').hide();
        $('.cresrPopup').show();
    });
    $('.closeFormSecPopup').on('click', function(){
        $('.cresrPopup').hide();
    });
});
JS;

        Yii::$app->view->registerJs($js);

        return true;
    }

    public function actionGetPages()
    {
        extract(ParserOlxParams::params());
        $count_list_proxy = sizeof($list_proxy);
        // Проверяем, есть ли страницы для парсинга
        $sql = 'SELECT page_url FROM new_parser_olx_pages_list WHERE `status` = "wait" ORDER BY cast( SUBSTRING(page_url FROM LOCATE ("=", page_url) + 1) as unsigned)';
        $parsing_data = Yii::$app->db->createCommand($sql)->queryColumn();
        if (!empty($parsing_data)) {
            $proxy_iterator = 0;
            try {
                $counter = 0;
                while (sizeof($parsing_data) ) {
                    $url = reset($parsing_data);
                    // сброс к первому прокси
                    $this->logDB("Proxy reset");
                    $proxy_iterator = -1;
                    $list_proxy[-1] = false; // пойти через свой прокси.
                    while (!$this->getPage($url, $list_proxy[$proxy_iterator])) {
                        $proxy_iterator++;
                        $this->logDB( "Next proxy(" . date("H:i:s") . "): " . $list_proxy[$proxy_iterator] );
                        if ($proxy_iterator >= $count_list_proxy) {
                            throw new Exception("Список прокси пуст. Разбор данных не завершен.");
                        }
                    }
                    // Разбор данного URL прошел успешно.
                    // Найдены ссылки на объекты, надо отметить это в таблице
                    Yii::$app->db->createCommand()// where        prepare
                    ->update("new_parser_olx_pages_list", ['status' => 'ready'], 'page_url=:url', [":url" => $url])
                        ->execute();
                    $counter++;
                    if($counter > 5)
                        break;

                    // Проверяем, есть ли страницы для парсинга
                    $sql = 'SELECT page_url FROM new_parser_olx_pages_list WHERE `status` = "wait" ORDER BY cast( SUBSTRING(page_url FROM LOCATE ("=", page_url) + 1) as unsigned)';
                    $parsing_data = Yii::$app->db->createCommand($sql)->queryColumn();
                }
                $this->logDB("COMPLETED ========================================");
             } catch (Exception $e) {
                $this->logDB($e->getMessage());
            }
        } else {
            // добавляем в список первую страницу
            Yii::$app->db->createCommand()
                ->insert('new_parser_olx_pages_list', [
                    'page_url' => $root_url,
                    'proxy' => "",
                    ])->execute();
            $this->getPage($root_url);
           }
    }

    /**
     * Обрабатывает страницу и находит на ней все ссылки на другие страницы.
     * Находит все ссылки на оюъекты и добавляет их в базу
     *
     * @param $pageUrl - ссылка на страницу
     * @param bool $proxy - прокси сервер, через который идет обработка
     * @return bool - true, если страница обработана успешно (страницы и ссылки на объекты найдены)
     *
     */
    private function getPage($pageUrl, $proxy = false)
    {
        extract(ParserOlxParams::params());
        ini_set('max_execution_time', 0);
        ini_set('max_input_time', -1);
        $ch = curl_init();
        $this->logDB("Processed: $pageUrl   Proxy: $proxy");
        /* Настраиваем опции */
        curl_setopt($ch, CURLOPT_URL, "$pageUrl");

        if ($proxy)
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        $useragent = $list_users_agents[rand(0, $count_list_users_agents)];
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls
        //Поехали!
        $output = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
        if ($status['http_code'] != 200 || $output === FALSE) {
            $this->logDB("=========Status: {$status['http_code']}   Proxy: $proxy");
            return false;
        }

        if (preg_match_all('/<a class="block br3 brc8[^"]*".*?href="([^"]*?)"/', $output, $matches_key)) {
            /*foreach ( $matches_key['0'] as $value_str ) {
                preg_match( $_pattern_search_container_additional_info_value, $value_str, $matches_tmp );
                $array_values[] = $matches_tmp['0'];
            }*/
            foreach ($matches_key['1'] as $key => $value) {
                $link = trim($value);
                /* Массив $array_flat_properties содержит всю необходимую доп. информацию */
                try {
                    // Проверяем, нет ли записи в таблице
                    $result = Yii::$app->db->createCommand("SELECT * FROM new_parser_olx_pages_list WHERE page_url=:url")
                        ->bindParam(":url", $value)
                        ->queryOne();
                    // если такой страницы нет, то ее надо добавить
                    // если сейчас она обрабатывается
                    if (!$result) {
                        // добавляем страницу в список обрабатываемых
                        Yii::$app->db->createCommand()
                            ->insert('new_parser_olx_pages_list', [
                                'page_url' => $link,
                                'proxy' => $proxy,
                            ])->execute();
// *************************************                        echo "OK ($proxy) <br>";
                    }
                } catch (Exception $e) {
                    var_dump($e);
                }
            }
            // список страниц обработан. теперь берем все ссылки с данной страница
            // пытаемся найти ссылки на объекты
            $objectsQuantity = $this->getObjectsLinks($output);
            //******************************************************           var_dump($objectsQuantity);
            // если ссылки на объекты найдены, то сообщаем, что страница обработана
            if ($objectsQuantity) {
                //echo "Ссылки на объекты найдены.($objectsQuantity)<br>";
                return true;
            }
        } else {
            // на странице не надены ссылки на другие страницы. это ошибка. ее обрабатывать не надо
            $this->logDB("на странице не надены ссылки на другие страницы. это ошибка. ее обрабатывать не надо($url)");
            Yii::$app->db->createCommand()// where        prepare
            ->update("new_parser_olx_pages_list", ['status' => 'ready', 'proxy' => $proxy], 'page_url=:url', [":url" => $url])
                ->execute();
            return true;
        }
        return false;
    }

    private function getObjectsLinks($txt)
    {
        extract(ParserOlxParams::params());
        if (preg_match($_pattern_search_container_offers_table, $txt, $matches)) {
            $container_offers_table = $matches['0'];
            if (preg_match_all($_object_link
                /*$_pattern_search_all_links*/, $container_offers_table, $links)) {
                $items = [];
                foreach ($links['1'] as $key => $link) {
                    $link = strstr($link, '#', true);
                    // TODO проверяем, что такой записи нет
                    $result = Yii::$app->db->createCommand("SELECT * FROM new_parser_olx_links_list WHERE link=:url")
                        ->bindValue(":url", $link)
                        ->queryOne();
                    if (!$result)
                        $all_links_tmp[] = [$link];
                }
            }
        }

        Yii::$app->db->createCommand()
            ->batchInsert('new_parser_olx_links_list', ['link'], /*$items*/
                $all_links_tmp)
            ->execute();
        return sizeof($all_links_tmp);
    }

    public function actionHandleApartmentsLinks()
    {
        extract(ParserOlxParams::params());
        //var_dump($list_proxy);
        $count_list_proxy = sizeof($list_proxy);
        //$this->logDB("count proxy start = ".$count_list_proxy);
        // Создаём таблицу для хранения информации с распаршенных страниц
        $this->parserTableCreate();
        //Yii::$app->db->createCommand("TRUNCATE TABLE new_parser_olx_parser")->execute();
        // Инициализируем переменные
        $unique_all_links = $array_flat_properties = array();
        $link = $path = $date = $price = $note = $phone = $image = $advert_from = $type = $type_flat = '';
        $count_apartment_parsing = $count_fail_apartment_parsing = $advert_id =
        $kolfoto = $count_room = $floor = $floor_all = $total_area = $floor_area =
        $kitchen_area = 0;
        // Получаем все собранные на данный момент уникальные ссылки
        $unique_all_links = Yii::$app->db->createCommand('SELECT link FROM `new_parser_olx_links_list` WHERE `status` = "wait"')->queryColumn();

            $counter = 0;
            /* Цикл для прохождения по всем уникальным ссылкам */
            //echo 'count='.count($unique_all_links);
            foreach ($unique_all_links as $apartment_link) {
                // проверяем, есть ли такая ссылка в объектах
                /** TODO Если есть, то восстановить данные об объекте
                 *  TODO Если нет, то обрабатываем ссылку
                 */
                try {
                    $result = Yii::$app->db->createCommand("SELECT * FROM new_parser_olx_parser WHERE link=:url")
                        ->bindParam(":url", $value)
                        ->queryOne();
                    //$result = false;
                    // если такой страницы нет, то ее надо добавить
                    // если сейчас она обрабатывается
                    //$this->logDB($list_proxy);
                    if (!$result) {
                        // сброс к первому прокси
                        $this->logDB("Proxy reset");
                        $proxy_iterator = -1;
                        $list_proxy[-1] = false; // пойти через свой прокси.
                        $this->logDB($apartment_link);
                        $this->logDB("Next proxy(" . date("H:i:s") . "): " . $list_proxy[$proxy_iterator]);
                        while (!$this->getObjectInfo($apartment_link, $list_proxy[$proxy_iterator])) {
                            //OK
                            $proxy_iterator++;
                            //$this->logDB("Next proxy(" . date("H:i:s") . "): " . $list_proxy[$proxy_iterator]);
                            if ($proxy_iterator >= $count_list_proxy) {
                                throw new Exception("Список прокси пуст. Разбор данных не завершен.");
                            }
                        }
                        // Разбор данного URL прошел успешно.
                        // Найдена информация об объекте. Отмечаем, что объект обработан.
                        Yii::$app->db->createCommand()// where        prepare
                        ->update("new_parser_olx_links_list", ['status' => 'ready'], 'link=:url', [":url" => $apartment_link])
                            ->execute();
                    }
                    $counter++;
                    if($counter > 5)
                        break;

                    $this->logDB("COMPLETED ========================================");
                } catch (Exception $e) {
                    $this->logDB($e->getMessage());
                    //return "not comleted!";
                }

            }
        // Закрываем cURL-сессию
        //ini_set('max_execution_time', 30);
        //ini_set('memory_limit', '128M');
        //ini_set('max_input_time', 60);
        //curl_close($ch);
        //return $this->redirect(['/olxparser']);
        return true;
    }

    /**
     * @param $apartment_link
     * @param $proxy
     * @return bool
     *
     *
     * Получаем информацию об объекте. Обязательно получаем телефон. Только тогда информация считается собранной.
     */
    private function getObjectInfo($apartment_link, $proxy)
    {
        // извлекаем параметры парсера
        extract(ParserOlxParams::params());
        // Инициализируем переменные
        $array_flat_properties = array();
        $link = $path = $date = $price = $note = $phone = $image = $advert_from = $type = $type_flat = '';
        $count_apartment_parsing = $count_fail_apartment_parsing = $advert_id =
        $kolfoto = $count_room = $floor = $floor_all = $total_area = $floor_area =
        $kitchen_area = 0;
        // Инициализируем cURL-сессию
        $ch = curl_init();
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '1024M');
        ini_set('max_input_time', -1);

        if ($proxy)
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_URL, $apartment_link);
        //curl_setopt($ch, CURLOPT_PROXY, $proxy);
        $useragent = $list_users_agents[rand(0, $count_list_users_agents)];
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls
        //Поехали!
        $output = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
        if ($status['http_code'] != 200 || $output === FALSE) {
            $this->logDB($status['http_code']);
            return false;
        }
        // Ссылка на объявление
        $link = $apartment_link;
        // Находим контейнер с необходимой информацией о заголовке объяления
        if (preg_match($_pattern_search_title_publication, $output, $matches)) {
            $title_publication = trim(strip_tags($matches['1']));
            $path = "<a href='$link' target='_blank'>$title_publication</a>";
        }
        // Находим контейнер с необходимой информацией о дате публикации и об ID объяления
        if (preg_match($_pattern_search_container_date_publication, $output, $matches)) {
            $container_date_publication = $matches['0'];
            if (preg_match($_pattern_search_date_publication, $container_date_publication, $matches)) {
                $date_publication = $matches['1'];
                $date = $date_publication;
            }
            if (preg_match($_pattern_search_ID_publication, $container_date_publication, $matches)) {
                $id_publication = $matches['0'];
                $advert_id = $id_publication;
            }
        }
        // Находим контейнер с необходимой дополнительной информацией
        if (preg_match_all($_pattern_search_container_additional_info_key, $output, $matches_key)) {
            foreach ($matches_key['0'] as $value_str) {
                preg_match($_pattern_search_container_additional_info_value, $value_str, $matches_tmp);
                $array_values[] = $matches_tmp['0'];
            }
            foreach ($matches_key['1'] as $key => $value) {
                $array_flat_properties[$value] = trim(strip_tags($array_values[$key]));
                /* Массив $array_flat_properties содержит всю необходимую доп. информацию */
            }
            // @se: была ошибка `Undefined index` из-за предыдущего кода
            $prop = function ($key, $default) use ($array_flat_properties) {
                if (isset($array_flat_properties[$key])) {
                    return $array_flat_properties[$key];
                } else {
                    return $default;
                }
            };
            $advert_from = $prop('Объявление от', '-');
            $type = $prop('Тип', '-');
            $type_flat = $prop('Тип квартиры', '-');
            $count_room = $prop('Количество комнат', 0);
            $floor = $prop('Этаж', 0);
            $floor_all = $prop('Этажность дома', 0);
            $total_area = $prop('Общая площадь', 0);
            $floor_area = $prop('Жилая площадь', 0);
            $kitchen_area = $prop('Площадь кухни', 0);
        }
        unset($array_values);
        // Находим контейнер с ценой
        if (preg_match($_pattern_search_container_price, $output, $matches)) {
            $price = trim(strip_tags($matches['0']));
        }
        // Находим контейнер с описанием
        if (preg_match($_pattern_search_container_description, $output, $matches)) {
            $note = trim(strip_tags($matches['0']));
        }
        /* ТЕЛЕФОННЫЙ НОМЕР */
        // Находим id номера телефона
        if (preg_match($_pattern_search_id_phone, $output, $matches)) {
            $idphone = $matches['1'];
            $this->logDB("=====id phone:".$idphone);
        }
        // Задаём необходимый url для работы Curl
        $url_address_phone = "{$url_phone}{$idphone}/";

        $phones = $this->getPhones($url_address_phone, $proxy, $useragent);
        if (!$phones)
            return false;
        // Находим все фотографии, относящиеся к данному объявлению
        if (preg_match_all($_pattern_all_photos, $output, $matches)) {
            $kolfoto = count($matches['1']);
            $image = serialize($matches['1']);
        }
        // Наполняем таблицу распаршенными данными
        Yii::$app->db->createCommand()
            ->insert('new_parser_olx_parser', [
                'advert_id' => $advert_id,
                'link' => $link,
                'path' => $path,
                'date' => $date,
                'type_object_id' => 12,
                'advert_from' => $advert_from,
                'type' => $type,
                'type_flat' => $type_flat,
                'count_room' => $count_room,
                'floor' => $floor,
                'floor_all' => $floor_all,
                'total_area' => $total_area,
                'floor_area' => $floor_area,
                'kitchen_area' => $kitchen_area,
                'price' => $price,
                'phone' => $phones,
                'status' => 1,
                'note' => $note,
                'kolfoto' => $kolfoto,
                'image' => $image,
                'view' => 'no',
            ])->execute();
        return true;
    }

    private function getPhones($url, $proxy, $useragent)
    {

        extract(ParserOlxParams::params());
        $ch = curl_init();
        // Задаём опции для корректной работы Curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);

        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls

        // Запускаем Curl
        $response = curl_exec($ch);

        // Разделяем строку полученного ответа по маркерам окончания строки
        $result_answer = explode("\r\n", $response);


        curl_close($ch);

        // Если ответ положительный ( код 200 ) - продолжаем получать номера телефонов
        if ($result_answer['0'] == "HTTP/1.1 200 OK") {
            if (preg_match($_pattern_search_phone_value, $response, $matches)) {
                if (preg_match_all($_pattern_only_phones, $matches['1'], $phones)) {
                    $phone = implode(", ", $phones['0']);
                }
            }
        } else {
            return false;
        }
        return $phone;
    }

    private function logDB($value){
        $model = new ParserOlxLog();
        switch(gettype($value)){
            case "array":{
                $model->text = join(",",$value);
            }break;
            default:
                $model->text = $value;
        }

        $model->save();
    }

    public function paramsTableCreate()
    {
        Yii::$app->db->createCommand("CREATE TABLE `new_parser_olx_params` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `pack` int(11) NOT NULL,
          `name` varchar(255) NOT NULL,
          `label` varchar(255) NOT NULL,
          `value` text NOT NULL,
          `default_value` text NOT NULL,
          `textfield` tinyint(4) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute();

        Yii::$app->db->createCommand("INSERT INTO `new_parser_olx_params` (`id`, `pack`, `name`, `label`, `value`, `default_value`, `textfield`) VALUES
        (1,	1,	'list_proxy',	'proxy ip:port, по одному в строке',	'83.239.58.162:8080\r\n',	'',	1),
        (17,	1,	'root_url',	'Задаём исходный URL для парсинга информации',	'https://www.olx.ua/nedvizhimost/prodazha-kvartir/kharkov/',	'https://www.olx.ua/nedvizhimost/prodazha-kvartir/kharkov/',	0),
        (19,	1,	'list_users_agents',	'user agent, по одному в строке',	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FSL 7.0.6.01001)\r\n',	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FSL 7.0.6.01001)\r\n',	1),
        (20,	1,	'_count_true_pages_list',	'Количество обработываемых объектов за одну итерацию',	'100',	'100',	0),
        (21,	1,	'url_phone',	'Задаём необходимый url для получения номера телефона при помощи ajax',	'https://www.olx.ua/ajax/misc/contact/phone/',	'https://www.olx.ua/ajax/misc/contact/phone/',	0),
        (22,	1,	'max_pagecount',	'Задаем максимальное количество страниц для парсинга',	'500',	'',	0);
        ")->execute();
    }

    public function parserTableCreate()
    {
        Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS `new_parser_olx_parser` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`advert_id` int(11) NOT NULL UNIQUE,
		`link` text NOT NULL,
		`path` text NOT NULL,
		`date` varchar(255) NOT NULL,
		`type_object_id` int(11) NOT NULL,
		`advert_from` varchar(255) NOT NULL,
		`type` varchar(255) NOT NULL,
		`type_flat` varchar(255) NOT NULL,
		`count_room` int(11) NOT NULL,
		`floor` int(11) NOT NULL,
		`floor_all` int(11) NOT NULL,
		`total_area` int(11) NOT NULL,
		`floor_area` int(11) NOT NULL,
		`kitchen_area` int(11) NOT NULL,
		`price` varchar(255) NOT NULL,
		`phone` text NOT NULL,
		`status` ENUM('wait','ready') NOT NULL DEFAULT 'wait',
		`note` text NOT NULL,
		`kolfoto` int(11) NOT NULL,
		`image` text NOT NULL,
		`view` enum('neprov','no','yes','tel') NOT NULL,
		`count_similar_advs` INT(11) NOT NULL DEFAULT 0,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1")->execute();

    }

    public function actionProcessPagesInfo()
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
        $pages_total = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_pages_list`")->queryScalar();
        $pages_ready = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_pages_list` WHERE `status` ='ready'")->queryScalar();
        echo Json::encode(["total"=>$pages_total,"ready" => $pages_ready]);
        Yii::$app->end();
    }

    public function actionProcessLinksInfo()
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
        $pages_total = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_links_list`")->queryScalar();
        $pages_ready = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_links_list` WHERE `status` ='ready'")->queryScalar();
        echo Json::encode(["total"=>$pages_total,"ready" => $pages_ready]);
        Yii::$app->end();
    }

    public function actionClearTables()
    {
        //TRUNCATE TABLE `new_parser_olx_links_list`
        Yii::$app->db->createCommand("TRUNCATE TABLE new_parser_olx_pages_list")->execute();
        Yii::$app->db->createCommand("TRUNCATE TABLE new_parser_olx_links_list")->execute();//new_parser_olx_pages_list
        $this->redirect(['/olxparser/default/']);
    }

}