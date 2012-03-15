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

class PluginSimilar_ModuleSimilar_MapperSimilar extends Mapper
{

    /**
     * Возвращает массив с id'ками похожих топиков (ищет по тегам)
     *
     * @param array $aTags
     * @param integer $iLimit
     * @param string $sOrderBy
     * @param integer $sOrderByDirection
     * @param string $sLang
     * @return array
     */
    public function getTopicIdForTags(array $aTags, $iLimit, $sOrderBy="rating", $iOrderByDirection=0, $sLang = null) {
        if (empty($aTags)) {
            return array();
        }

        $sql = "SELECT
                    topic_tag.topic_id,
                    topic.topic_rating,
                    COUNT(*) AS `tags_count`
                FROM
                    `" . Config::Get('db.table.topic_tag') . "` AS topic_tag,
                    `" . Config::Get('db.table.topic') . "` AS topic
                WHERE
                    topic.topic_publish = 1
                    AND topic_tag.topic_id = topic.topic_id
                    AND topic_tag_text IN (?a)
                    { AND topic.topic_lang = ? }
                GROUP BY
                    topic_tag.topic_id
                ORDER BY
                    tags_count DESC, " .
                ($sOrderBy == "rating" ? "topic.topic_rating" : "topic.topic_date_edit");

        if ($iOrderByDirection == 1) {
            $sql .= " DESC";
        }

        $sql .= " LIMIT 0,?d";

        $aResults = $this->oDb->select($sql, $aTags, (empty($sLang) ? DBSIMPLE_SKIP : $sLang), $iLimit);

        $aReturnValues = array();
        foreach ($aResults as $aTopic) {
            $aReturnValues[] = $aTopic['topic_id'];
        }

        return $aReturnValues;
    }

}

?>