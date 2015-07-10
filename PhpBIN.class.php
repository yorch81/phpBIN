<?php
require_once('BIN.class.php');

/**
 * PhpBIN
 * 
 * PhpBIN Singleton Implementation of BIN
 *
 * Copyright 2015 Jorge Alberto Ponce Turrubiates
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category   PhpBIN
 * @package    PhpBIN
 * @copyright  Copyright 2015 Jorge Alberto Ponce Turrubiates
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0.0, 2015-06-10
 * @author     Jorge Alberto Ponce Turrubiates (the.yorch@gmail.com)
 */
class PhpBIN
{
	/**
     * Instance Handler to Singleton Pattern
     *
     * @var object $_instance Instance Handler
     * @access private
     */
	private static $_instance;

	/**
     * BIN Instance
     * @var object $_bin BIN Instance
     *
     * @access private
     */
	private $_bin;


	/**
	 * Constructor of class is private for implements Singleton Pattern
	 *
	 * @param string $bintype BIN Provider Type
	 */
	private function __construct($bintype)
	{
		if(class_exists($bintype)){
			$this->_bin = new $bintype();
		}
		else{
			$this->_bin = null;

			trigger_error('Implementation not supported.', E_USER_ERROR);
		}
	}

	/**
	 * Implements Singleton Pattern
	 *
	 * @param string $bintype BIN Provider Type
	 * @return Object | null
	 */
	public static function getInstance($bintype)
	{
		// If exists Instance return same Instance
		if(self::$_instance){
			return self::$_instance;
		}
		else{
			$class = __CLASS__;
			self::$_instance = new $class($bintype);
			return self::$_instance;
		}
	}

	/**
	 * Gets info for a BIN/IIN
	 *
	 * @param string $bin BIN/IIN 6 digits Number
	 * @return array
	 */
	public function getInfo($bin)
	{
		return $this->_bin->getInfo($bin);
	}

	/**
	 * Return error when try clone object
	 *
	 */
	public function __clone()
	{
		trigger_error('Clone is not permitted.', E_USER_ERROR);
	}
	
}
?>