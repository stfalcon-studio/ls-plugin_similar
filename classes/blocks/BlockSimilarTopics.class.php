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

class PluginSimilar_BlockSimilarTopics extends Block
{

    /**
     * Выполняется при вызове блока
     * @return void
     */
    public function Exec() {
        $oTopic = $this->GetParam('oTopic');
        $this->Viewer_Assign('aSimilarTopics', $this->PluginSimilar_Similar_getSimilarTopicsForTopic($oTopic));
    }

}