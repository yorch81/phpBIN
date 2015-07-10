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
     * @var Array $_info Information Card
     * @access private
     */
	protected $_info = array('BIN' => '000000',
							'BRAND'=> '',
							'BANK' =>'',
							'CARD_TYPE'=>'',
							'CARD_CATEGORY'=>'',
							'COUNTRY'=>'',
							'CC_ISO3166-1'=>'',
							'CC_ISO A2'=>'',
							'CC_ISO A3'=>'',
							'COUNTRY NUM'=>'',
							'WEBSITE'=>'',
							'PHONE'=>'');

	/**
	 * Gets info for a BIN/IIN
	 *
	 * @param string $bin BIN/IIN 6 digits Number
	 * @return array
	 */
	public abstract function getInfo($bin);

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
			$this->_info['CC_ISO3166-1'] = $binlist->country_code;
			$this->_info['CC_ISO A2'] = "";
			$this->_info['CC_ISO A3'] = "";
			$this->_info['COUNTRY NUM'] = "";
			$this->_info['WEBSITE'] = "";
			$this->_info['PHONE'] = "";
		}

		return $this->_info;
	}
}

?>