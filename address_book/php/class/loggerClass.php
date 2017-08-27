<?php
class logger 
{	
	private $path = null;
	private $mode = null;
	private $fp = null;	
	public function __construct($path, $mode)
	{
		
		$this->fp = fopen($path, $mode);
	}
	public function log($errorMsg)
	{
		fwrite($this->fp, date("Y-m-d H:i:s A").$errorMsg);
	}
	public function __destruct()
	{
		if ($this->fp) {
  			fclose($this->fp);
		}
	}
}
?>