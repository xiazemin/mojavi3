<?php
namespace Mojavi\Logging;

use Mojavi\Exception\LoggingException as LoggingException;

/**
 * MailAppender
 */
class MailAppender extends Appender
{

	protected $toAddress;
	protected $fromAddress;
	protected $host;
	
	/**
	 * Initialize the FileAppender.
	 *
	 * @param array An array of parameters.
	 *
	 * @return void
	 */
	public function initialize($params)
	{
		if (isset($params['to'])) {
			$this->setToAddress($params['to']);
		}
		if (isset($params['from'])) {
			$this->setFromAddress($params['from']);
		}
		if (isset($params['host'])) {
			$this->setHost($params['host']);
		}
	}
	
	/**
	 * returns the host
	 * @return string
	 */
	function getHost() {
		if (is_null($this->host)) {
			$this->host = "localhost";
		}
		return $this->host;
	}
	
	/**
	 * sets the host
	 * @param string $arg0
	 */
	function setHost($arg0) {
		$this->host = $arg0;
	}
	
	/**
	 * returns the fromAddress
	 * @return string
	 */
	function getFromAddress() {
		if (is_null($this->fromAddress)) {
			$this->fromAddress = "localhost";
		}
		return $this->fromAddress;
	}
	
	/**
	 * sets the fromAddress
	 * @param string $arg0
	 */
	function setFromAddress($arg0) {
		$this->fromAddress = $arg0;
	}
	
	/**
	 * returns the toAddress
	 * @return string
	 */
	function getToAddress() {
		if (is_null($this->toAddress)) {
			$this->toAddress = "";
		}
		return $this->toAddress;
	}
	
	/**
	 * sets the toAddress
	 * @param string $arg0
	 */
	function setToAddress($arg0) {
		$this->toAddress = $arg0;
	}
	
	/**
	 * Execute the shutdown procedure.
	 *
	 * If open, close the filehandle.
	 *
	 * return void
	 */
	public function shutdown()
	{
	}

   /**
	 * Write a Message to the file.
	 *
	 * @param Message
	 *
	 * @throws <b>LoggingException</b> if no Layout is set or the file
	 *		 cannot be written.
	 *
	 * @return void
	 */
	public function write($message)
	{
		if (($layout = $this->getLayout()) === null) {
			throw new LoggingException('No Layout set');
		}

		$str = sprintf("%s\n", $this->getLayout()->format($message));
		$fromHeader = "From: " . $this->getFromAddress() . "\r\n";
		mail($this->getToAddress(), "Log Entry on " . date("m/d/Y h:i.s",strtotime("now")),$str, $fromHeader);
	}

}

