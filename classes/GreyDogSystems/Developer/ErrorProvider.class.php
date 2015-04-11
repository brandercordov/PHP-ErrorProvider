<?php
namespace GreyDogSystems\Developer;

class ErrorProvider{
	// Global variables
	private $ErrorMessages;
	private $IsEnabled = false;
	private $ShowErrorMessages = true;
	private $WithErrorsState=false;
	private $ErrorsPool=array();

	// Constructor
	/**
	 * The main constructor for the class
	 *
	 * @param array Error messages stack. This is needed in order to show error messages. If the parameter is not an array, the class will not raise any error.
	 * @return null
	*/
	public function __construct($aErrorMessages){
		if (is_array($aErrorMessages)){
			$this->ErrorMessages = $aErrorMessages;
			$this->IsEnabled = true;
		}else{
			$this->IsEnabled = false;
		}
	}

	/**
	 * Enables or disables the error messages. The errors will be stored in the "errors pool" even if the messages are not shown
	 *
	 * @param boolean Defines if the messages will be shown or not
	 * @return null
	 */
	public function ErrorDisplay($bEnabled = true){
		if (is_bool($bEnabled)){
			$this->ShowErrorMessages = $bEnabled;
		}else{
			$this->ShowErrorMessages = true;
		}
	}

	/**
	 * Returns the current error state. If the error pool contains any error, the function will return TRUE.
	 *
	 * @return boolean Status of the current error pool.
	*/
	public function WithErrors(){
		return $this->WithErrorsState;
	}

	/**
	 * Looks for any incidence of the specified error code.
	 * @param object The error code
	 * @return boolean If there is any incidence of the specified error code, the function will return true.
	*/
	public function ErrorLookup($iErrorCode){
		if ($this->WithErrors()) {
			if ($iErrorCode!=null) {
				foreach ($this->ErrorsPool as $Error) {
					if ($Error['CODE']==$iErrorCode) {
						return true;
					}
				}
			}
			return false;
		}else{
			return false;
		}
	}

	/**
	 * Stores and shows (if enabled) errors
	 *
	 * @param object The error code that references in the "Messages" array passed to the constructor. If the code doesn't exist. The function will raise an "unknown error" message
	 * @param string (Optional) A message to override an standart defined message.
	 * @return null
	 */
	public function RaiseError($iErrCode, $sErrMSG = null){
		$this->WithErrorsState = true;
		if (!is_string($sErrMSG)) {
			$sErrMSG=null;
		}
		if (key_exists($iErrCode, $this->ErrorMessages)){
			if ($sErrMSG === null){
				$this->ErrorsPool[] = array('MSG' => $this->ErrorMessages[$iErrCode], 'CODE' => $iErrCode);
			}else{
				$this->ErrorsPool[] = array('MSG' => $sErrMSG, 'CODE' => $iErrCode);
				$this->ErrorMessages[$iErrCode] = $sErrMSG;
			}
		}else{
			if ($sErrMSG !== null){
				$this->ErrorsPool[] = array('MSG' => $sErrMSG, 'CODE' => $iErrCode);
				$this->ErrorMessages[$iErrCode] = $sErrMSG;
			}else{
				$sErrMSG="An unknown error has ocurred with the code \"$iErrCode\".";
				$this->ErrorsPool[] = array('MSG' => $sErrMSG, 'CODE' => $iErrCode);
				$this->ErrorMessages[$iErrCode] = $sErrMSG;
			}
		}
		if ($this->ShowErrorMessages === true){
			echo $this->ErrorMessages[$iErrCode];
		}
	}

	/**
	 * Resets the errors pool and clears the "WithErrors" state
	 *
	 * @return null
	 */
	public function ResetErrors(){
		$this->WithErrorsState = FALSE;
		$this->ErrorsPool = array();
	}

	/**
	 * Returns the current errors pool
	 *
	 * @return array The current errors pool
	*/
	public function GetErrorsPool(){
		return $this->ErrorsPool;
	}
}

?>