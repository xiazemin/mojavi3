<?php
/**
 * DefineConfigHandler allows you to turn ini categories and key/value pairs
 * into defined PHP values.
 *
 * <b>Optional initialization parameters:</b>
 *
 * # <b>prefix</b> - The text prepended to all defined constant names.
 *
 * @package	Mojavi
 * @subpackage Config
 */
namespace Mojavi\Config;

class DefineConfigHandler extends IniConfigHandler
{

	// +-----------------------------------------------------------------------+
	// | METHODS															   |
	// +-----------------------------------------------------------------------+

	/**
	 * Execute this configuration handler.
	 *
	 * @param string An absolute filesystem path to a configuration file.
	 *
	 * @return string Data to be written to a cache file.
	 *
	 * @throws <b>ConfigurationException</b> If a requested configuration file
	 *									   does not exist or is not readable.
	 * @throws <b>ParseException</b> If a requested configuration file is
	 *							   improperly formatted.
	 */
	public function & execute ($config)
	{

		// parse the ini
		$ini = $this->parseIni($config);

		// get our prefix
		$prefix = $this->getParameter('prefix');

		if ($prefix == null)
		{

			// no prefix has been specified
			$prefix = '';

		}

		// init our data array
		$data = array();

		// let's do our fancy work
		foreach ($ini as $category => &$keys)
		{

			// categories starting without a period will be prepended to the key
			if ($category{0} != '.')
			{

				$category = $prefix . $category . '_';

			} else
			{

				$category = $prefix;

			}

			// loop through all key/value pairs
			foreach ($keys as $key => &$value)
			{

				// prefix the key
				$key = $category . $key;

				// replace constant values
				$value = $this->replaceConstants($value);

				// literalize our value
				$value = $this->literalize($value);

				// append new data
				$tmp	= "if (!defined('%s')) { define('%s', %s); }";
				$data[] = sprintf($tmp, $key, $key, $value);

			}

		}

		// compile data
		$retval = "<?php\n" .
				  "// auth-generated by DefineConfigHandler\n" .
				  "// date: %s\n%s\n?>";
		$retval = sprintf($retval, date('m/d/Y H:i:s'), implode("\n", $data));

		return $retval;

	}

}

