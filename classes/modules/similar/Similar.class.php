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

class PluginSimilar_ModuleSimilar extends Module {

    /**
     *
     * @var PluginSimilar_ModuleSimilar_MapperSimilar
     */
    protected $oMapper;

    /**
     * Инициализация плагина
     *
     * @return void
     */
    public function Init() {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

   
    /**
     * Возвращает похожие записи для объекта топика (по тегам)
     *
     * @param ModuleTopic_EntityTopic $oTopic
     *
     * @return array
     */
    public function getSimilarTopicsForTopic(ModuleTopic_EntityTopic $oTopic) {
        if ($oTopic == null) {
            return array();
        }
//        Вытаскиваем переменные с файлов Config
//        Максимальное количество топиков, которое выводится в блоке - iCountTopics
//        По какому параметру сортировать записи - sOrderBy
//        Как сортировать топики в выдаче
        
        $iCountTopics = Config::Get('plugin.similar.max_topics_count');
        $sOrderBy = Config::Get('plugin.similar.topics_order_by');
        $iOrderByDirection = Config::Get('plugin.similar.topics_order_by_direction');

        $sLang = null;

        if (in_array('l10n', $this->Plugin_GetActivePlugins())) {
            $sLang = $this->PluginL10n_L10n_GetLangForQuery();
        }

        // Генерируем ключ для кеша
        $key = "simular_topics_by_tags_for_" . $oTopic->getId() . ($sLang ? "_{$sLang}" : "")
                . "_{$iCountTopics}_{$sOrderBy}_{$iOrderByDirection}";

        if (!$aTopicIds = $this->Cache_Get($key)) {
            $aTopicIds = $this->oMapper->getTopicIdForTags(
                    $oTopic->getTagsArray(), $iCountTopics + 1, $sOrderBy, $iOrderByDirection, $sLang
            );
            unset($aTopicIds[array_search($oTopic->getId(), $aTopicIds)]);
            // Кешируем массив топиков на один час
            $this->Cache_Set($aTopicIds, $key, array('topic_update'), 60 * 10);
        }
        // Пытаемся вытянуть массив топиков из кеша
        // Массив id'шек топиков похожих на текущий
        // Достаем топики вместе с дополнительной информацией (автор, блог и т.д.)
        $aTopics = $this->Topic_GetTopicsAdditionalData($aTopicIds, array('user' => array(), 'blog' => array('owner' => array())));

        return $aTopics;
    }

}