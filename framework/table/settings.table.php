<?php
/**
 * [WeEngine System] Copyright (c) 2014 we7.cc
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class SettingsTable extends We7Table {
	public function searchSetting($key) {
		return $this->query->from('core_settings')
			->select('value')
			->where('key', $key)
			->get();
	}
}