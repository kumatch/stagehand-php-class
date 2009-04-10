<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5
 *
 * Copyright (c) 2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>,
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
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_ClassTest

/**
 * Some tests for Stagehand_Class
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */

class Stagehand_ClassTest extends PHPUnit_Framework_TestCase
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
    public function load()
    {
        $className = 'ExampleForLoad';
        $class = new Stagehand_Class($className);
        $class->load();

        $this->assertTrue(class_exists($className));
    }

    /**
     * @test
     */
    public function setProperty()
    {
        $className = 'ExampleForProperty';
        $class = new Stagehand_Class($className);

        $propertyA = new Stagehand_Class_Property('a', 100);
        $propertyB = new Stagehand_Class_Property('b');
        $propertyC = new Stagehand_Class_Property('c');
        $propertyD = new Stagehand_Class_Property('d', array(1, 3, 5));
        $propertyB->setProtected();
        $propertyC->setPrivate();

        $class->addProperty($propertyA);
        $class->addProperty($propertyB);
        $class->addProperty($propertyC);
        $class->addProperty($propertyD);

        $class->load();
        $instance = new $className;

        $this->assertObjectHasAttribute('a', $instance);
        $this->assertObjectHasAttribute('b', $instance);
        $this->assertObjectHasAttribute('c', $instance);
        $this->assertObjectHasAttribute('d', $instance);

        $refClass = new ReflectionClass($className);
        $a = $refClass->getProperty('a');
        $b = $refClass->getProperty('b');
        $c = $refClass->getProperty('c');

        $this->assertTrue($a->isPublic());
        $this->assertTrue($b->isProtected());
        $this->assertTrue($c->isPrivate());

        $this->assertEquals($instance->a , 100);
        $this->assertEquals($instance->d, array(1, 3, 5));
    }

    /**
     * @test
     */
    public function setMethod()
    {
        $className = 'ExampleForMethod';
        $class = new Stagehand_Class($className);

        $class->setMethod('a', null, "return 'foo';", 'public');

        $class->load();
        $instance = new $className;

        $this->assertTrue(method_exists($instance, 'a'));
        $this->assertEquals($instance->a(), 'foo');
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
