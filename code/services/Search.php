<?php

/**
 * DelectusSearchService calls delectus search service and returns results matched against the local database and augmented with additional
 * meta data and content.
 */
class DelectusSearchService extends DelectusApiRequestService {
	const Endpoint = 'search';
	const SearchAction = 'search';
	const ApiRequestClassName = DelectusSearchApiRequestModel::class;

	public function search( $terms ) {
		$requestClassName = static::ApiRequestClassName;

	}
}