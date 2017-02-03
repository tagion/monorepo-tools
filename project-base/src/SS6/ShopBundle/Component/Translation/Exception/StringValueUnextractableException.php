<?php

namespace SS6\ShopBundle\Component\Translation\Exception;

use Exception;
use SS6\ShopBundle\Component\Translation\Exception\TranslationException;

class StringValueUnextractableException extends Exception implements TranslationException {

	/**
	 * @param string $message
	 * @param \Exception|null $previous
	 */
	public function __construct($message = '', Exception $previous = null) {
		parent::__construct($message, 0, $previous);
	}

}