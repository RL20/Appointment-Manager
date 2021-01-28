<?php

class DoesNotExistsException extends Exception
{
    private $baseException = "Does not Exists!";
    private $excepionsArr = [
        0 => "ID",
        1 => "",
        2 => "",
        3 => "",
        4 => "",
        5 => "",
        6 => "",
        7 => "",
        8 => "",
        9 => "",
    ];
	// Redefine the exception so message isn't optional
	public function __construct($message = false, $code = 0, Exception $previous = null) {
		// some code

        $message = $this->excepionsArr[$code] . ' ' . $this->baseException;
        self::writeToLog($message, $code);// will be impliment of diffrent class
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

