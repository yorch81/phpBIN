<?php
require_once('PhpBIN.class.php');

/**
 * PhpBIN
 * 
 * PhpBIN Test Example
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
class PhpBINTest extends PHPUnit_Framework_TestCase
{
    protected $bin;

    /**
     * Setup Test
     */
    protected function setUp() {
    	$this->bin = PhpBIN::getInstance('BinList');
    }

    /**
     * TearDown Test
     */
    protected function tearDown() {
        unset($this->bin);
    }

    /**
     * Test Method for getInfo
     */
    public function testGetInfo() {
        $expected = $expected = array('BIN' => '557910',
						'BRAND'=> 'MASTERCARD',
						'BANK' =>'',
						'CARD_TYPE'=>'DEBIT',
						'CARD_CATEGORY'=>'',
						'COUNTRY'=>'Mexico',
						'CC_ISO3166_1'=>'MX',
						'CC_ISO_A3'=>'',
						'COUNTRY_NUM'=>'',
						'WEBSITE'=>'',
						'PHONE'=>'');

        $current = $this->bin->getInfo("557910");

        $this->assertEquals($expected, $current);
    }
}
?>