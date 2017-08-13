<?php

/**
 * DelectusPageExtension added to Page class provides fields needed by Delectus to track indexing and search and hooks to make sure
 * changes made to pages in the CMS are advertised to delectus
 */
class DelectusSearchControllerExtension extends DataExtension {
	// set to false to disable Delectus functions at runtime, e.g. during testing other functionality
	private static $delectus_enabled = true;

	private static $delectus_search_term_param = 'q';

	private static $delectus_search_action = 'search';

	// map method to order checked, lower number takes precedence, 0 means don't accept
	private static $delectus_search_methods = [
		'POST' => 1,
		'GET'  => 2,
		'PUT'  => 0        // don't accept PUT requests
	];

	private static $delectus_pagination_enabled = true;

	public function SearchForm() {
		$form = new DelectusSearchForm(
			$this->owner,
			'SearchForm',
			new FieldList( [
				TextField::create(
					static::search_param_name(),
					_t(
						'Delectus.TermLabel',
						''
					),
					$this->searchTerm()
				)->setAttribute(
					'placeholder',
					_t(
						'DelectusSearch.TermPlaceholder',
						'enter search term'
					)
				)
			] ),
			new FieldList( [
				new FormAction(
					_t(
						'DelectusSearch.ActionLabel',
						'search'
					)
				)
			] )
		);
		$form->setFormAction( Controller::join_links(
			$this->owner->Link(),
			static::search_action()
		) );

	}

	public function search( SS_HTTPRequest $request ) {
		$term          = $this->searchTerm();

		if ( $term ) {
			$results = DelectusSearchModule::search( $term);

			$term = Convert::raw2xml( $term);

			if ( $results->count() ) {
				$resultMessage = _t(
					'DelectusSearch.ResultsFound',
					"Found {count} results for term {term}",
					[
						'count' => $results->count(),
						'term'  => $term,
					]
				);
				if ( $this->owner->config()->get( 'delectus_pagination_enabled' ) ) {
					$results = new PaginatedList( $results );
				}
			} else {
				$resultMessage = _t(
					'DelectusSearch.NoResultsFound',
					"No results found for term {term}",
					[
						'term' => $term,
					]
				);
			}

		} else {
			$results       = new ArrayList();
			$resultMessage = _t( 'DelectusSearch.NoTermProvided', 'Please enter a search term to look for' );
		}

		return new ArrayObject( [
			'Term'    => $term,
			'Results' => $results,
			'Message' => $resultMessage,
		] );

	}

	/**
	 * Return the term searched for from the current controller request.
	 * @return mixed|string
	 */
	public function searchTerm() {
		$term = '';
		$request = Controller::curr()->getRequest();
		$searchParam = static::search_param_name();

		$searchMethods = array_filter(
			$this->owner->config()->get( 'delectus_search_methods' ) ?: []
		);
		asort( $searchMethods );
		foreach ( $searchMethods as $method => $unused ) {
			if ( $method == 'POST' ) {
				if ( $term = $request->postVar( $searchParam ) ) {
					break;
				}
			}
			if ( $method == 'GET' ) {
				if ( $term = $request->getVar( $searchParam ) ) {
					break;
				}
			}
		}
		return $term;
	}

	public static function search_param_name() {
		return Config::inst()->get( get_called_class(), 'delectus_search_term_param' );
	}

	public static function search_action() {
		return Config::inst()->get( get_called_class(), 'delectus_search_action' );
	}

	/**
	 * Set and/or get the current enabled state of this extension.
	 *
	 * @param null|bool $enable if passed then use it to set the enabled state of this extension
	 *
	 * @return bool if enable parameter was passed this will be the previous value otherwise the current value
	 */
	public static function enabled( $enable = null ) {
		if ( func_num_args() ) {
			$return = \Config::inst()->get( static::class, 'delectus_enabled' );
			\Config::inst()->update( static::class, 'delectus_enabled', $enable );
		} else {
			$return = \Config::inst()->get( static::class, 'delectus_enabled' );
		}

		return (bool) $return;
	}

}