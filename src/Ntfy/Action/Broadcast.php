<?php

namespace Ntfy\Action;

use Ntfy\Action;

/**
 * Class for creating an android broadcast button action
 * 
 * @see https://ntfy.sh/docs/publish/#send-android-broadcast
 */
class Broadcast extends Action
{
	/** {@inheritDoc} */
	protected string $type = 'broadcast';

	/** @var string $intent Android intent name */
	protected string $intent = '';

	/** @var array $extras Android intent extra */
	protected array $extras = [];

	/**
	 * Set android intent name
	 * 
	 * @param string $intent intent Android intent name
	 */
	public function intent(string $intent): void
	{
		$this->intent = $intent;
	}

	/**
	 * Set an android intent extra
	 * 
	 * @param string $parameter Paramter name
	 * @param string $value Paramter value
	 */
	public function extra($parameter, $value): void
	{
		$this->extras[$parameter] = $value;
	}

	/** 
	 * {@inheritDoc}
	 */
	protected function generate(): array
	{
		$action = parent::generate();

		if ($this->intent !== '') {
			$action['intent'] = $this->intent;
		}

		if ($this->extras !== []) {
			$action['extras'] = $this->extras;
		}

		return $action;
	}
}