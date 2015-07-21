<?php
require_once('vendor/autoload.php');
require_once('PhpBIN.class.php');

/**
 * PhpBINTestMon
 * 
 * PhpBINTestMon Test Example for MongoDb
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
 * @category   PhpBINTestMon
 * @package    PhpBINTestMon
 * @copyright  Copyright 2015 Jorge Alberto Ponce Turrubiates
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0.0, 2015-07-20
 * @author     Jorge Alberto Ponce Turrubiates (the.yorch@gmail.com)
 */
class PhpBINTestMon extends PHPUnit_Framework_TestCase
{
    protected $bin;

    /**
     * Setup Test
     */
    protected function setUp() {
    	$_config = array('DBTYPE' => 'mongo',
                        'SERVER'=> 'localhost',
                        'USER' =>'yorch',
                        'PASSWORD'=>'password',
                        'DBNAME'=>'yorch',
                        'COLLECTION'=>'binbase');

    	$this->bin = PhpBIN::getInstance('MonBinBase', $_config);
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
        $expected = $expected = array('BIN' => '111904',
						'BRAND'=> 'PRIVATE LABEL CARD',
						'BANK' =>'',
						'CARD_TYPE'=>'DEBIT',
						'CARD_CATEGORY'=>'PIN ONLY W/O EBT',
						'COUNTRY'=>'UNITED STATES',
						'CC_ISO3166_1'=>'US',
						'CC_ISO_A3'=>'USA',
						'COUNTRY_NUM'=>'840',
						'WEBSITE'=>'',
						'PHONE'=>'');

        $current = $this->bin->getInfo("111904");

        $this->assertEquals($expected, $current);
    }
}
?>