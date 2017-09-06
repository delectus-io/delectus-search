<?php
class DelectusSearchApiRequestModel extends DelectusApiRequestModel {
	private static $db = [
		'Terms' => 'Varchar(255)'
	];

	public function onBeforeWrite() {
		$this->Environment = Director::get_environment_type();
		parent::onBeforeWrite();
	}

}