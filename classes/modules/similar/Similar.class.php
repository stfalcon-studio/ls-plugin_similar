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

class PluginSimilar_ModuleSimilar extends Module
{

    private $oCurrentTopic;
    private $oMaxSimilarTopicsCount;
    private $oOrderBy;
    private $oOrderByDirection;
    protected $oMapper;

    /**
     * Инициализация плагина
     *
     * @return void
     */
    public function Init() {
        $this->oMapper = Engine::GetMapper(__CLASS__);
        $this->oMaxSimilarTopicsCount = Config::Get('plugin.similar.max_topics_count');
        $this->oOrderBy = Config::Get('plugin.similar.topics_order_by');
        $this->oOrderByDirection = Config::Get('plugin.similar.topics_order_by_direction');
    }

    /**
     * Установить текущий топик
     *
     * @param ModuleTopic_EntityTopic $currentTopic
     * @return void
     */
    public function setCurrentTopic(ModuleTopic_EntityTopic $currentTopic) {
        $this->oCurrentTopic = $currentTopic;
    }

    /**
     * Возвращает топики похожие на текущий топик
     *
     * @return array
     */
    public function getSimilarForCurrentTopic() {
        if ($this->oCurrentTopic == null) {
            return array();
        }
        return $this->getSimilarForTopicByTags($this->oCurrentTopic, $this->oMaxSimilarTopicsCount);
    }

    /**
     * Возвращает похожие записи для объекта топика (по тегам)
     *
     * @param ModuleTopic_EntityTopic $currentTopic
     * @param integer $countTopics
     * @return array
     */
    protected function getSimilarForTopicByTags(ModuleTopic_EntityTopic $currentTopic, $countTopics=10) {
        if ($currentTopic == null) {
            return array();
        }

        $sLang = null;

        if (in_array('l10n', $this->oEngine->Plugin_GetActivePlugins())) {
            $sLang = $this->PluginL10n_L10n_GetLangForQuery();
        }

        // Генерируем ключ для кеша
        $key = "simular_topics_by_tags_for_" . $currentTopic->getId() . ($sLang ? "_{$sLang}" : "")
                . "_{$countTopics}_{$this->oOrderBy}_{$this->oOrderByDirection}";
        // Пытаемся вытянуть массив топиков из кеша
        if ($content = $this->Cache_Get($key)) {
            return $content;
        }

        // Массив id'шек топиков похожих на текущий
        $topicsId = $this->oMapper->getTopicIdForTags(
                $currentTopic->getTagsArray(), $countTopics + 1, $this->oOrderBy, $this->oOrderByDirection, $sLang
        );

        // Достаем топики вместе с дополнительной информацией (автор, блог и т.д.)
        $topics = $this->Topic_GetTopicsAdditionalData($topicsId, array('user' => array(), 'blog' => array('owner' => array())));

        $returnValue = array();
        if (is_array($topics)) {
            foreach ($topics as $iTopicId => $oTopic) {
                if ($oTopic->getId() != $currentTopic->getId()) {
                    $returnValue[] = $oTopic;
                }
            }
        }

        // Кешируем массив топиков на один час
        $this->Cache_Set($returnValue, $key, array('topic_update'), 60 * 10);

        return $returnValue;
    }

}