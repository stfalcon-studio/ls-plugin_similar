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

class PluginSimilar extends Plugin {

        /**
         * Активация плагина
         * @return boolean
         */
	public function Activate() {
		$this->Cache_Clean();
		return true;
	}

        /**
         * Инициализация плагина
         * @return void
         */
	public function Init() {
	}

        /**
         * Деактивация плагина
         * @return boolean
         */
	public function Deactivate() {
		$this->Cache_Clean();
		return true;
	}
}