<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5
 *
 * Copyright (c) 2009 KUMAKURA Yousuke <kumatch@gmail.com>,
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    stagehand-php-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_PHP_Class_ConstantTest

/**
 * Some tests for Stagehand_PHP_Class_Constant
 *
 * @package    stagehand-php-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_ConstantTest extends PHPUnit_Framework_TestCase
{

    // {{{ properties

    /**#@+
     * @access public
     */

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    /**#@+
     * @access public
     */

    public function setUp() { }

    public function tearDown() { }

    /**
     * @test
     */
    public function createConstant()
    {
        $foo = new Stagehand_PHP_Class_Constant('foo');
        $bar = new Stagehand_PHP_Class_Constant('bar', 10);
        $baz = new Stagehand_PHP_Class_Constant('baz', 'baz');

        $this->assertEquals($foo->getName(), 'foo');
        $this->assertEquals($bar->getName(), 'bar');
        $this->assertEquals($baz->getName(), 'baz');

        $this->assertNull($foo->getValue());
        $this->assertEquals($bar->getValue(), 10);
        $this->assertEquals($baz->getValue(), 'baz');
    }

    /**
     * @test
     * @expectedException Stagehand_PHP_Class_Exception
     */
    public function catchTheExceptionIfDeclaringArrayToConstantValue()
    {
        $constant = new Stagehand_PHP_Class_Constant('foo', array());
    }

    /**
     * @test
     * @expectedException Stagehand_PHP_Class_Exception
     */
    public function catchTheExceptionIfDeclaringObjectToConstantValue()
    {
        $constant = new Stagehand_PHP_Class_Constant('foo', new stdClass());
    }

    /**
     * @test
     */
    public function renderConstantCode()
    {
        $foo = new Stagehand_PHP_Class_Constant('foo');
        $bar = new Stagehand_PHP_Class_Constant('bar', 10);
        $baz = new Stagehand_PHP_Class_Constant('baz', 'baz');

        $this->assertEquals($foo->render(), 'const foo = NULL;');
        $this->assertEquals($bar->render(), 'const bar = 10;');
        $this->assertEquals($baz->render(), 'const baz = \'baz\';');
    }

    /**
     * @test
     */
    public function useParsableValue()
    {
        $foo = new Stagehand_PHP_Class_Constant('foo', 'Foo::value', true);

        $this->assertTrue($foo->isParsable());
        $this->assertEquals($foo->getValue(), 'Foo::value');
        $this->assertEquals($foo->render(), 'const foo = Foo::value;');

        $foo->setValue('Foo::value');

        $this->assertFalse($foo->isParsable());
        $this->assertEquals($foo->getValue(), 'Foo::value');
        $this->assertEquals($foo->render(), 'const foo = \'Foo::value\';');

        $foo->setValue('Foo::value', true);

        $this->assertTrue($foo->isParsable());
        $this->assertEquals($foo->getValue(), 'Foo::value');
        $this->assertEquals($foo->render(), 'const foo = Foo::value;');
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    // }}}
}

// }}}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
