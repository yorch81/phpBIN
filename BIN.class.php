<?php

/**
 * BIN
 * 
 * BIN Abstract Class for get a BIN/IIN Information Card.
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
 * @category   BIN
 * @package    BIN
 * @copyright  Copyright 2015 Jorge Alberto Ponce Turrubiates
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0.0, 2015-06-10
 * @author     Jorge Alberto Ponce Turrubiates (the.yorch@gmail.com)
 */
abstract class BIN
{

	/**
     * Array Information Card of BIN/IIN
     *
     * @var array $_info Information Card
     * @access private
     */
	protected $_info = array('BIN' => '000000',
							'BRAND'=> '',
							'BANK' =>'',
							'CARD_TYPE'=>'',
							'CARD_CATEGORY'=>'',
							'COUNTRY'=>'',
							'CC_ISO3166_1'=>'',
							'CC_ISO_A3'=>'',
							'COUNTRY_NUM'=>'',
							'WEBSITE'=>'',
							'PHONE'=>'');

	/**
	 * Gets info for a BIN/IIN
	 *
	 * @param string $bin BIN/IIN 6 digits Number
	 * @return array
	 */
	public abstract function getInfo($bin);

	/**
	 * Connect with a BinBase Database
	 * 
	 * @param  string $dbtype Connection Type
	 * @param  string $server Database Server
	 * @param  string $user   Database User
	 * @param  string $pwd    Database Password
	 * @param  strng  $dbname Database Name
	 * @param  string $table  Table of BIN
	 * @return boolean
	 */
	public abstract function connect($dbtype, $server, $user, $pwd, $dbname, $table);
}

/**
 * BinList implementation for BIN
 *
 * @category   BinList
 * @package    BinList
 * @copyright  Copyright 2014 Jorge Alberto Ponce Turrubiates
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0.0, 2015-06-10
 * @author     Jorge Alberto Ponce Turrubiates (the.yorch@gmail.com)
 */
class BinList extends BIN
{
	/**
	 * Contructor Class
	 */
	public function __construct()
	{

	}

	/**
	 * Gets info for a BIN/IIN
	 *
	 * @param string $bin BIN/IIN 6 digits Number
	 * @return array
	 */
	public function getInfo($bin)
	{
		$url = "http://www.binlist.net/json/" . $bin;

		$handler = curl_init($url); 

		curl_setopt($handler, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");  
        curl_setopt($handler, CURLOPT_HEADER, false);  
        curl_setopt($handler, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));  
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, false);  
        curl_setopt($handler, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);  
        curl_setopt($handler, CURLOPT_RETURNTRANSFER,true);  
        curl_setopt($handler, CURLOPT_CONNECTTIMEOUT, 5);  
        curl_setopt($handler, CURLOPT_TIMEOUT, 60);  
        curl_setopt($handler, CURLOPT_AUTOREFERER, TRUE);  

		$response = curl_exec ($handler);  
		curl_close($handler);  

		if (substr($response, 0, 3) != '404'){
			$binlist = json_decode($response);
			
			$this->_info['BIN'] = $binlist->bin;
			$this->_info['BRAND'] = $binlist->brand;
			$this->_info['BANK'] = $binlist->bank;
			$this->_info['CARD_TYPE'] = $binlist->card_type;
			$this->_info['CARD_CATEGORY'] = $binlist->card_category;
			$this->_info['COUNTRY'] = $binlist->country_name;
			$this->_info['CC_ISO3166_1'] = $binlist->country_code;
			$this->_info['CC_ISO_A3'] = "";
			$this->_info['COUNTRY_NUM'] = "";
			$this->_info['WEBSITE'] = "";
			$this->_info['PHONE'] = "";
		}

		return $this->_info;
	}

	/**
	 * Connect with a BinBase Database
	 * 
	 * @param  string $dbtype Connection Type
	 * @param  string $server Database Server
	 * @param  string $user   Database User
	 * @param  string $pwd    Database Password
	 * @param  strng  $dbname Database Name
	 * @param  string $table  Table of BIN
	 * @return boolean
	 */
	public function connect($dbtype, $server, $user, $pwd, $dbname, $table)
	{
		return true;
	}
}

/**
 * BinBase implementation for BIN in MySql Database
 * 
 * @category   BinBase
 * @package    BinBase
 * @copyright  Copyright 2014 Jorge Alberto Ponce Turrubiates
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0.0, 2015-06-10
 * @author     Jorge Alberto Ponce Turrubiates (the.yorch@gmail.com)
 */
class MyBinBase extends BIN
{
	/**
     * DataBase Connection 
     *
     * @var object $_conn Connection
     * @access private
     */
	private $_conn = null;

	/**
     * BIN Table
     *
     * @var string $_table BIN Table
     * @access private
     */
	private $_table = 'binbase';

	/**
	 * Contructor Class
	 */
	public function __construct()
	{

	}

	/**
	 * Gets info for a BIN/IIN
	 *
	 * @param string $bin BIN/IIN 6 digits Number
	 * @return array
	 */
	public function getInfo($bin)
	{
		$query = "SELECT * FROM " . $this->_table . " WHERE BIN = '" . $bin . "'";

		if ($this->_conn != null){
			$results = $this->_conn->query($query)->fetchAll();

			if (count($results) > 0){
				$this->_info['BIN'] = $results[0]['BIN'];
				$this->_info['BRAND'] = $results[0]['BRAND'];
				$this->_info['BANK'] = $results[0]['BANK'];
				$this->_info['CARD_TYPE'] = $results[0]['CARD_TYPE'];
				$this->_info['CARD_CATEGORY'] = $results[0]['CARD_CATEGORY'];
				$this->_info['COUNTRY'] = $results[0]['COUNTRY'];
				$this->_info['CC_ISO3166_1'] = $results[0]['CC_ISO3166_1'];
				$this->_info['CC_ISO_A3'] = $results[0]['CC_ISO_A3'];
				$this->_info['COUNTRY_NUM'] = $results[0]['COUNTRY_NUM'];
				$this->_info['WEBSITE'] = $results[0]['WEBSITE'];
				$this->_info['PHONE'] = $results[0]['PHONE'];
			}
		}

		return $this->_info;
	}

	/**
	 * Connect with a BinBase Database
	 * 
	 * @param  string $dbtype Connection Type
	 * @param  string $server Database Server
	 * @param  string $user   Database User
	 * @param  string $pwd    Database Password
	 * @param  strng  $dbname Database Name
	 * @param  string $table  Table of BIN
	 * @return boolean
	 */
	public function connect($dbtype, $server, $user, $pwd, $dbname, $table)
	{
		try {
			$this->_table = $table;

			$this->_conn = new medoo([
			    'database_type' => $dbtype,
			    'database_name' => $dbname,
			    'server' => $server,
			    'username' => $user,
			    'password' => $pwd,
			    'charset' => 'utf8',
			    'port' => 3306,
			    'option' => [
			        PDO::ATTR_CASE => PDO::CASE_NATURAL
			    ]
			]);

			return true; 
        }
        catch (Exception $e) {
            $this->_conn = null;

            return false;
        }
	}
}

?>