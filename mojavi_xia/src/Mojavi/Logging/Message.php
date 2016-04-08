<?php
namespace Mojavi\Logging;
// +---------------------------------------------------------------------------+
// | This file is part of the Agavi package.								   |
// | Copyright (c) 2003-2005 Agavi Foundation.								 |
// |																		   |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code. You can also view the	|
// | LICENSE file online at http://www.agavi.org/LICENSE.txt				   |
// |   vi: set noexpandtab:													|
// |   Local Variables:														|
// |   indent-tabs-mode: t													 |
// |   End:																	|
// +---------------------------------------------------------------------------+

/**
 * Message, by default, holds a message and a priority level.  It is intended
 * to be passed to a Logger.
 */
class Message extends \Mojavi\Util\ParameterHolder
{

	/**
	 * Constructor.
	 *
	 * @param $message optional message
	 * @param $priority optional priority level
	 */
	public function __construct($message = null, $priority = Logger::INFO)
	{
		$this->setParameter('m', $message);
		$this->setParameter('p', $priority);
	}

	/**
	 * Log this Message.
	 *
	 * Convenience function to log this Message.
	 */
	public function log()
	{
		LoggerManager::log($this);
	}
	
	/**
	 * toString method.
	 *
	 * @return string
	 */
	public function __toString()
	{
		$retVal = "";
		if (is_array($this->getParameter('m'))) {
			$retVal = implode("\n", $this->getParameter('m'));
		} else {
			$retVal = (string) $this->getParameter('m');
		}
		return $retVal;
	}

	/**
	 * Set the message.
	 *
	 * @param $message required
	 *
	 * @return Message
	 */
	public function setMessage($message)
	{
		$this->setParameter('m', $message);
		return $this;
	}

	/**
	 * Append to the message.
	 *
	 * @param $message required
	 *
	 * @return Message
	 */
	public function appendMessage($message)
	{
		$this->appendParameter('m', $message);
		return $this;
	}
	
	/**
	 * Set the priority.
	 *
	 * @param $priority required
	 *
	 * @return Message
	 */
	public function setPriority($priority)
	{
		$this->setParameter('p', $priority);
		return $this;
	}

	/**
	 * Get the priority.
	 *
	 * @return mixed
	 */
	public function getPriority()
	{
		return $this->getParameter('p');
	}

	/**
	 * Get the message.
	 *
	 * @return mixed
	 */
	public function getMessage()
	{
		return $this->getParameter('m');
	}

}

