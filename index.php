<?php
// Autoloader include.
include_once('autoloader.php');

// Error messages stack. Just a bunch o MySQL errors.
$Errors = array(
	1 => 'Server unavailable<br>',
	2 => 'Wrong credentials<br>',
	3 => 'Database not found<br>',
	4 => 'The conection already exist!<br>',
	5 => 'Conection already closed!<br>',
	6 => "The connection is not initialized<br>",
	7 => 'The extension \'mysqli\' doesn\'t exist. Please check your php.ini<br>',
	10 => 'The query has an error<br>',
	11 => 'Unknown query format output<br>',
	12 => 'Statement prepare was specting a string for query value<br>',
	13 => 'Statement creation failed. Please check your query<br>',
	14 => 'Statement execution failed<br>',
	15 => 'Statement error<br>',
	16 => 'Bind failed. You need at least one parameter<br>',
	17 => 'Statement object not initialized<br>',
	18 => 'Variable type unknown<br>',
	19 => 'Blob type not implemented yet. Sorry.<br>',
	20 => 'Type definition name must be an string<br>'
);

// Instances
$ErrorProvider = new GreyDogSystems\Developer\ErrorProvider($Errors);
$Debug = new GreyDogSystems\Developer\Debug(); // This is just for debbuging porpuses. You can ignore it.

// Raising an error.
echo 'Error 20: ';$ErrorProvider->RaiseError(20);

//Raising an unknown error (is not in the error stack)
echo '<br>Error 21 (this doesn\'t exist):';$ErrorProvider->RaiseError(21);

//Creating a new error on the fly
echo '<br>Creating a new error on the fly: ';$ErrorProvider->RaiseError(22, 'This is a new error<br>');

// Disabling error messages displaying
$ErrorProvider->ErrorDisplay(FALSE);
echo '<br>';
$ErrorProvider->RaiseError(2);

// Look if the error 2 has occurred (Is a boolean, so i needed the debug class the print the result in a "transparen" way)
echo 'Is the any error with id=2?: ';
echo $Debug->VariableDumper($ErrorProvider->ErrorLookup(2));
echo '<br>The errors pool';
// (Debug) The errors pool
echo $Debug->VariableDumper($ErrorProvider->GetErrorsPool());
?>