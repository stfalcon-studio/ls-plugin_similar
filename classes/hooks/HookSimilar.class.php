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

class PluginSimilar_HookSimilar extends Hook
{

    /**
     * Регистрируем хук на topic_show
     *
     * @return void
     */
    public function RegisterHook() {
        $this->AddHook("topic_show", "topicShowed", __CLASS__);
    }

    /**
     * Получаем список похожих топиков, передаем их в Viewer и добавляем нужный блок в сайдбар
     *
     * @param array $aVars
     */
    function topicShowed($aVars) {
        if (isset($aVars['oTopic'])) {
            $this->Viewer_AddBlock('right', 'similarTopics', array('plugin' => 'similar', 'oTopic' => $aVars['oTopic']
                    ), Config::Get('plugin.similar.topics_block_priority')
            );
        }
    }

}