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
    public function loadClass()
    {
        $className = 'ExampleForLoad';
        $class = new Stagehand_Class($className);
        $class->load();

        $this->assertTrue(class_exists($className));
    }

    /**
     * @test
     */
    public function setPropertyAndAccessProperties()
    {
        $className = 'ExampleForProperty';
        $class = new Stagehand_Class($className);

        $propertyA = new Stagehand_Class_Property('a', 100);
        $propertyB = new Stagehand_Class_Property('b');
        $propertyC = new Stagehand_Class_Property('c');
        $propertyD = new Stagehand_Class_Property('d', array(1, 3, 5));
        $propertyE = new Stagehand_Class_Property('e', 200);
        $propertyB->setProtected();
        $propertyC->setPrivate();
        $propertyE->setStatic();

        $class->addProperty($propertyA);
        $class->addProperty($propertyB);
        $class->addProperty($propertyC);
        $class->addProperty($propertyD);
        $class->addProperty($propertyE);

        $class->load();
        $instance = new $className;

        $this->assertObjectHasAttribute('a', $instance);
        $this->assertObjectHasAttribute('b', $instance);
        $this->assertObjectHasAttribute('c', $instance);
        $this->assertObjectHasAttribute('d', $instance);
        $this->assertObjectHasAttribute('e', $instance);

        $refClass = new ReflectionClass($className);
        $a = $refClass->getProperty('a');
        $b = $refClass->getProperty('b');
        $c = $refClass->getProperty('c');

        $this->assertTrue($a->isPublic());
        $this->assertTrue($b->isProtected());
        $this->assertTrue($c->isPrivate());

        $this->assertEquals($instance->a , 100);
        $this->assertEquals($instance->d, array(1, 3, 5));

        $this->assertEquals(ExampleForProperty::$e, 200);
    }

    /**
     * @test
     */
    public function setMethodAndAccessMethods()
    {
        $className = 'ExampleForMethod';
        $class = new Stagehand_Class($className);

        $methodFoo = new Stagehand_Class_Method('foo');
        $methodFoo->setCode('return 10;');

        $methodBar = new Stagehand_Class_Method('bar');
        $methodBar->addArgument('bar');
        $methodBar->setCode('return $bar;');

        $methodBaz = new Stagehand_Class_Method('baz');
        $methodBaz->addArgument('baz', false, array(10, 30, 50));
        $methodBaz->setCode('return $baz[1];');

        $methodQux = new Stagehand_Class_Method('qux');
        $methodQux->setProtected();
        $methodQux->setCode('return true;');

        $methodQuux = new Stagehand_Class_Method('quux');
        $methodQuux->setPrivate();
        $methodQuux->setCode('return true;');

        $class->addMethod($methodFoo);
        $class->addMethod($methodBar);
        $class->addMethod($methodBaz);
        $class->addMethod($methodQux);
        $class->addMethod($methodQuux);

        $class->load();
        $instance = new $className;

        $refClass = new ReflectionClass($className);
        $foo = $refClass->getMethod('foo');
        $bar = $refClass->getMethod('bar');
        $baz = $refClass->getMethod('baz');
        $qux = $refClass->getMethod('qux');
        $quux = $refClass->getMethod('quux');

        $this->assertTrue($foo->isPublic());
        $this->assertTrue($bar->isPublic());
        $this->assertTrue($baz->isPublic());
        $this->assertTrue($qux->isProtected());
        $this->assertTrue($quux->isPrivate());

        $this->assertEquals($instance->foo(), 10);
        $this->assertEquals($instance->bar(20), 20);
        $this->assertEquals($instance->baz(), 30);
    }

    /**
     * @test
     */
    public function setParentClassAndOverride()
    {
        $baseName = 'ExampleForExtendBase';
        $childName = 'ExampleForExtendChild';

        $baseClass = new Stagehand_Class($baseName);
        $childClass = new Stagehand_Class($childName);

        $property = new Stagehand_Class_Property('foo', 10);
        $methodA   = new Stagehand_Class_Method('bar');
        $methodA->setCode('return 20;');
        $methodB   = new Stagehand_Class_Method('baz');
        $methodB->setCode('return 30;');
        $methodC   = new Stagehand_Class_Method('baz');
        $methodC->setCode('return 40;');

        $baseClass->addProperty($property);
        $baseClass->addMethod($methodA);
        $baseClass->addMethod($methodB);

        $childClass->setParentClass($baseClass);
        $childClass->addMethod($methodC);
        $childClass->load();

        $baseInstance = new $baseName;
        $childInstance = new $childName;

        $baseRefClass = new ReflectionClass($baseName);
        $childRefClass = new ReflectionClass($childName);

        $this->assertEquals($childRefClass->getParentClass()->getName(), $baseName);

        $this->assertEquals($baseInstance->foo,    10);
        $this->assertEquals($childInstance->foo,   10);
        $this->assertEquals($baseInstance->bar(),  20);
        $this->assertEquals($childInstance->bar(), 20);
        $this->assertEquals($baseInstance->baz(),  30);
        $this->assertEquals($childInstance->baz(), 40);
    }

    /**
     * @test
     */
    public function setParentClassAndOverrideByExistigClass()
    {
        $baseName = 'ExistingClass';
        require_once "./ClassTest/{$baseName}.php";
        $baseInstance = new $baseName();

        $this->assertEquals($baseInstance->foo, 10);
        $this->assertEquals($baseInstance->bar(), 20);
        $this->assertEquals($baseInstance->baz(), 30);

        $childName = 'ExampleForExtendsByExistingClass';
        $childClass = new Stagehand_Class($childName);

        $method   = new Stagehand_Class_Method('baz');
        $method->setCode('return 40;');

        $childClass->setParentClass($baseName);
        $childClass->addMethod($method);
        $childClass->load();

        $childInstance = new $childName;
        $childRefClass = new ReflectionClass($childName);

        $this->assertEquals($childRefClass->getParentClass()->getName(), $baseName);
        $this->assertEquals($childInstance->foo,   10);
        $this->assertEquals($childInstance->bar(), 20);
        $this->assertEquals($childInstance->baz(), 40);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfExtendingClassDoesNotExists()
    {
        $childName = 'ExampleForEClassDoesNotExistsTest';
        $childClass = new Stagehand_Class($childName);

        $childClass->setParentClass('DummyClassName');
        $childClass->load();
    }

    /**
     * @test
     */
    public function setConstantAndAccessConstants()
    {
        $className = 'ExampleForConstant';
        $class = new Stagehand_Class($className);

        $constantA = new Stagehand_Class_Constant('a');
        $constantB = new Stagehand_Class_Constant('b', 10);
        $constantC = new Stagehand_Class_Constant('c', 'TextConstant');

        $class->addConstant($constantA);
        $class->addConstant($constantB);
        $class->addConstant($constantC);

        $class->load();

        $this->assertNull(ExampleForConstant::a);
        $this->assertEquals(ExampleForConstant::b, 10);
        $this->assertEquals(ExampleForConstant::c, 'TextConstant');
    }

    /**
     * @test
     */
    public function setAbstractAndUse()
    {
        $className = 'ExampleForAbsctuction';
        $class = new Stagehand_Class($className);
        $property = new Stagehand_Class_Property('a', 10);
        $method = new Stagehand_Class_Method('b');
        $method->setCode("return 'foo';");

        $class->addProperty($property);
        $class->addMethod($method);

        $class->setAbstract();
        $class->load();
        $refClass = new ReflectionClass($className);

        $this->assertTrue($class->isAbstract());
        $this->assertTrue($refClass->isAbstract());

        require_once "./ClassTest/ConcreteClass.php";

        $instance = new ConcreteClass();

        $this->assertEquals($instance->a, 10);
        $this->assertEquals($instance->b(), 'foo');
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
