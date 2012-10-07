<?php

use Orchestra\Extension;

class Orchestra_Pages_Controller extends Orchestra\Controller
{
	public $restful = true;

	/**
	 * Construct Pages Controller, only authenticated user should 
	 * be able to access this controller.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'orchestra::auth');
		
		Event::fire('orchestra.started: backend');
	}

	/**
	 * Add a drop-in page anywhere on Orchestra
	 *
	 * @access public
	 * @param  string $request
	 * @param  array $arguments
	 * @return Response
	 */
	public function __call($request, $arguments)
	{
		$name = $action = null;

		list($method, $fragment) = explode('_', $request, 2);

		str_contains($fragment, '.') and list($name, $action) = explode('.', $fragment, 2);
		
		// we first check if $name actually an extension, if not we should 
		// consider it's pointing to 'application'
		if ( ! Extension::started($name))
		{
			if ( ! Extension::started($fragment))
			{
				$action = $fragment;
				$name   = DEFAULT_BUNDLE;
			}
			elseif(Extension::started(DEFAULT_BUNDLE))
			{
				$action = array_shift($arguments);
				$name   = DEFAULT_BUNDLE;
			}
		}

		if ( ! Extension::started($name) or is_null($action))
		{
			return Response::error('404');
		}

		$content = Event::first("orchestra.pages: {$name}.{$action}", $arguments);

		if ($content instanceof Response)
		{
			$status_code = $content->foundation->getStatusCode();

			if ( ! $content->foundation->isSuccessful())
			{
				return Response::error($status_code);
			}
		}

		return View::make('orchestra::resources.pages', array('content' => $content));
	}
}