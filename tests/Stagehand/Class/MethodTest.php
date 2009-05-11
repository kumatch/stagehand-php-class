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
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_Class_MethodTest

/**
 * Some tests for Stagehand_Class_Method
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_Class_MethodTest extends PHPUnit_Framework_TestCase
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
    public function createAPublicMethod()
    {
        $name = 'getFoo';

        $method = new Stagehand_Class_Method($name);
        $method->setCode('$a = 0;
return 1;');

        $this->assertEquals($method->getName(), $name);
        $this->assertEquals($method->getVisibility(), 'public');
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isProtected());
        $this->assertFalse($method->isPrivate());
    }

    /**
     * @test
     */
    public function createAProtectedMethod()
    {
        $name = 'getFoo';

        $method = new Stagehand_Class_Method($name);
        $method->setCode('$a = 0;
return 1;');
        $method->defineProtected();

        $this->assertEquals($method->getName(), $name);
        $this->assertEquals($method->getVisibility(), 'protected');
        $this->assertFalse($method->isPublic());
        $this->assertTrue($method->isProtected());
        $this->assertFalse($method->isPrivate());
    }

    /**
     * @test
     */
    public function createAPrivateMethod()
    {
        $name = 'getFoo';

        $method = new Stagehand_Class_Method($name);
        $method->setCode('$a = 0;
return 1;');
        $method->definePrivate();

        $this->assertEquals($method->getName(), $name);
        $this->assertEquals($method->getVisibility(), 'private');
        $this->assertFalse($method->isPublic());
        $this->assertFalse($method->isProtected());
        $this->assertTrue($method->isPrivate());
    }

    /**
     * @test
     */
    public function createAPropertyWithSomeArguments()
    {
        $name = 'getFoo';

        $method = new Stagehand_Class_Method($name);

        $foo = new Stagehand_Class_Method_Argument('foo');
        $bar = new Stagehand_Class_Method_Argument('bar');
        $baz = new Stagehand_Class_Method_Argument('baz');

        $method->addArgument($foo);
        $method->addArgument($bar);
        $method->addArgument($baz);
        $method->setCode('$a = 0;
return 1;');

        $this->assertEquals($method->getName(), $name);
        $this->assertEquals($method->getVisibility(), 'public');
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isProtected());
        $this->assertFalse($method->isPrivate());

        $arguments = $method->getArguments();

        $this->assertEquals(count($arguments), 3);
        $this->assertSame($arguments['foo'], $foo);
        $this->assertSame($arguments['bar'], $bar);
        $this->assertSame($arguments['baz'], $baz);
    }

    /**
     * @test
     */
    public function createAStaticMethod()
    {
        $name = 'getFoo';

        $method = new Stagehand_Class_Method($name);

        $this->assertEquals($method->getName(), $name);
        $this->assertFalse($method->isStatic());

        $method->defineStatic();

        $this->assertTrue($method->isStatic());
    }

    /**
     * @test
     */
    public function createAnAbstractMethod()
    {
        $name = 'getFoo';

        $method = new Stagehand_Class_Method($name);
        $method->setCode('return 1;');

        $this->assertEquals($method->getName(), $name);
        $this->assertFalse($method->isAbstract());

        $method->defineAbstract();

        $this->assertTrue($method->isAbstract());
    }

    /**
     * @test
     */
    public function accessArgumentAndUpdate()
    {
        $method = new Stagehand_Class_Method('foo');

        $argument1 = new Stagehand_Class_Method_Argument('a');
        $method->addArgument($argument1);

        $this->assertSame($method->getArgument('a'), $argument1);

        $argument2 = new Stagehand_Class_Method_Argument('a');
        $argument2->setRequirement(false);
        $argument2->setValue(10);
        $method->setArgument($argument2);

        $this->assertSame($method->getArgument('a'), $argument2);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfAddsArgumentIsDuplicated()
    {
        $method = new Stagehand_Class_Method('foo');

        $argument1 = new Stagehand_Class_Method_Argument('a');
        $argument2 = new Stagehand_Class_Method_Argument('a');
        $method->addArgument($argument1);
        $method->addArgument($argument2);
    }

    /**
     * @test
     */
    public function createAFinalMethod()
    {
        $method = new Stagehand_Class_Method('method');
        $finalMethod = new Stagehand_Class_Method('finalMethod');
        $finalMethod->defineFinal();

        $this->assertFalse($method->isFinal());
        $this->assertTrue($finalMethod->isFinal());
    }

    /**
     * @test
     */
    public function createAReferenceMethod()
    {
        $method = new Stagehand_Class_Method('method');
        $referenceMethod = new Stagehand_Class_Method('referenceMethod');
        $referenceMethod->setReference();

        $this->assertFalse($method->isReference());
        $this->assertTrue($referenceMethod->isReference());
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
