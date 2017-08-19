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

	/**
	 * Return the client from the request (either by auth token or login)
	 *
	 * @return \Delectus\Core\Models\Client
	 */
	public function currentClient() {
		// TODO: Implement currentClient() method.
	}

	/**
	 * Return the model from the request
	 *
	 * @return \Delectus\CoreModel
	 */
	public function currentModel() {
		// TODO: Implement currentModel() method.
	}

	/**
	 * Return the client for the current model (resolve relationships from currentModel to its Client)
	 *
	 * @return \Delectus\Core\Models\Client
	 */
	public function currentModelClient() {
		// TODO: Implement currentModelClient() method.
	}

	/**
	 * Render template, json or xml to output
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	protected function renderResponse( array $data = [] ) {
		// TODO: Implement renderResponse() method.
}}