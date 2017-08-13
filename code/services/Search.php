<?php

use Delectus\Models\Search;

/**
 * DelectusSearchService calls delectus search service and returns results matched against the local database and augmented with additional
 * meta data and content.
 */
class DelectusSearchService extends DelectusApiRequestService {
	const Endpoint = 'search';
	const SearchAction = 'search';

	public function search( $terms ) {
		$models = new ArrayList();

		if ( ! $model = DelectusSearchModel::get()->find( 'Hash', DelectusSearchModel::hash( $terms ) ) ) {
			$model = DelectusSearchModel::create( [
				'Terms' => $terms,
			] );
			$model->write();

			$transport = DelectusModule::transport();
			$request   = new DelectusApiRequestModel( [
				'Endpoint' => 'search',
				'Action'   => 'query',
			] );

			$request->setModel( $model );

			// response will be
			$response = $transport->makeRequest( $request );


		}

	}
}