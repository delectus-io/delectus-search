<?php

/**
 * DelectusSearchForm
 */
class DelectusSearchForm extends Form {
	private static $extra_css_classes = 'delectus-search-form';

	public function __construct( \Controller $controller, $name, \FieldList $fields, \FieldList $actions, $validator = null ) {
		parent::__construct( $controller, $name, $fields, $actions, $validator );
		$this->addExtraClass(
			\Config::inst()->get(get_called_class(), 'extra_css_classes')
		);
	}
}