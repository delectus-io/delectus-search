<?php
class DelectusSearchCallbackController extends DelectusCallbackController {
	private static $allowed_actions = [
		'results' => '->checkResults'
	];
	private static $url_handlers = [
		'results' => 'results'
	];
	public function results(\SS_HTTPRequest $request) {
		// TODO: handle results
	}
}