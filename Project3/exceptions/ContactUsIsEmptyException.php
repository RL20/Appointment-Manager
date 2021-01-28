<?php

class ContactUsIsEmptyException extends Exception
{
	// Redefine the exception so message isn't optional
	public function __construct($message = false, $code = 0, Exception $previous = null) {
		// some code

		if (!$message)
		{
			$message = "Contact Us is empty!";
		}
		// make sure everything is assigned properly
		parent::__construct($message, $code, $previous);
	}

	// custom string representation of object
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	public function customFunction() {
		printToTerminal( "A custom function for this type of exception\n");
	}

















}

