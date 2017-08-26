<?php

/**
 * Delectus module class holds configuration and common functionality for the delectus module. Provides an interface which can be used internally
 * and by other code on the site.
 */
class DelectusSearchModule extends DelectusModule {
	const ModuleName   = 'delectus-search';
	const Endpoint     = 'search';
	const ActionSearch = 'search';

	public static function search( $term, $types = self::TypeFile | self::TypePage, &$responseMessage = '' ) {
		$results = new ArrayList();

		try {
			$response = static::make_request(
				self::Endpoint,
				self::ActionSearch,
				$types,
				[ 'q' => $term ],
				$responseMessage
			);
			if ( $responseMessage == 'OK' ) {
				if ( isset( $response['items'] ) ) {
					foreach ( $response['items'] as $item ) {
						if ( isset( $item['link'] ) ) {
							if ( ( ( $types & self::TypeFile ) == self::TypeFile ) && ( $item['type'] == self::TypeFile ) ) {
								$model = File::get()->filter( [
									'Filename' => $item['link'],
								] )->first();
							} elseif ( ( ( $types & self::TypePage ) == self::TypePage ) && ( $item['type'] == self::TypePage ) ) {
								$model = SiteTree::get_by_link( $item['link'] );
							} else {
								$model = null;
							}
							if ( $model ) {
								$results->push( $model );
							}
						}
					}
				}
			}

		} catch ( Exception $e ) {
			$responseMessage = _t(
				'Delectus.SearchActionFailed',
				"Failed to remove {type} from index: {exception}",
				[
					'type'      => 'File',
					'exception' => $e->getMessage(),
				]
			);

		}

		return $results;
	}

}