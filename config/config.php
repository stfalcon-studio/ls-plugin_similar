<?php

/* ---------------------------------------------------------------------------
 * @Plugin Name: Similar
 * @Plugin Id: similar
 * @Plugin URI:
 * @Description: Plugin to display a list of similar topics
 * @Author: stfalcon-studio
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 0.4.2
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * ----------------------------------------------------------------------------
 */

$config = array();

/**
 * Максимальное количество топиков, которое выводится в блоке
 * @var integer
 */
$config['max_topics_count'] = 10;

/**
 * По какому параметру сортировать записи
 * Возможные значения: rating, date
 * @var string
 */
$config['topics_order_by'] = 'rating';

/**
 * Как сортировать топики в выдаче
 * 0 - по возрастанию, 1 - по убыванию
 * @var integer
 */
$config['topics_order_by_direction'] = 1;

/**
 * Приоритет блока
 * @var integer
 */
$config['topics_block_priority'] = 175;

return $config;