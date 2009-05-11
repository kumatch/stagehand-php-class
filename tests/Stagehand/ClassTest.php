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

// {{{ Stagehand_ClassTest

/**
 * Some tests for Stagehand_Class
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
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
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfLoadsClassTwice()
    {
        $className = 'ExampleForLoadTwice';
        $class = new Stagehand_Class($className);
        $class->load();
        $class->load();
    }

    /**
     * @test
     */
    public function outputClass()
    {
        $className = 'ExampleForOutput';
        $class = new Stagehand_Class($className);

        $this->assertEquals($class->output(),
                            "class {$className}
{
}
");
    }

    /**
     * @test
     */
    public function setPropertyAndUse()
    {
        $className = 'ExampleForProperty';
        $class = new Stagehand_Class($className);

        $propertyA = new Stagehand_Class_Property('a', 100);
        $propertyB = new Stagehand_Class_Property('b');
        $propertyC = new Stagehand_Class_Property('c');
        $propertyD = new Stagehand_Class_Property('d', array(1, 3, 5));
        $propertyE = new Stagehand_Class_Property('e', 200);
        $propertyB->defineProtected();
        $propertyC->definePrivate();
        $propertyE->defineStatic();

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
    public function accessPropertyAndUpdate()
    {
        $className = 'ExampleForPropertyUpdate';
        $class = new Stagehand_Class($className);

        $property1 = new Stagehand_Class_Property('a', 100);
        $class->addProperty($property1);

        $this->assertSame($class->getProperty('a'), $property1);

        $property2 = new Stagehand_Class_Property('a', 200);
        $class->setProperty($property2);

        $this->assertSame($class->getProperty('a'), $property2);

        $class->load();
        $instance = new $className;

        $this->assertEquals($instance->a, 200);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfAddsProperyIsDuplicated()
    {
        $className = 'ExampleForPropertyDuplicate';
        $class = new Stagehand_Class($className);

        $property1 = new Stagehand_Class_Property('a', 100);
        $property2 = new Stagehand_Class_Property('a', 200);
        $class->addProperty($property1);
        $class->addProperty($property2);
    }

    /**
     * @test
     */
    public function setMethodAndUse()
    {
        $className = 'ExampleForMethod';
        $class = new Stagehand_Class($className);

        $methodFoo = new Stagehand_Class_Method('foo');
        $methodFoo->setCode('return 10;');

        $argumentBar = new Stagehand_Class_Method_Argument('bar');
        $methodBar = new Stagehand_Class_Method('bar');
        $methodBar->addArgument($argumentBar);
        $methodBar->setCode('return $bar;');

        $argumentBaz = new Stagehand_Class_Method_Argument('baz');
        $argumentBaz->setRequirement(false);
        $argumentBaz->setValue(array(10, 30, 50));
        $methodBaz = new Stagehand_Class_Method('baz');
        $methodBaz->addArgument($argumentBaz);
        $methodBaz->setCode('return $baz[1];');

        $methodQux = new Stagehand_Class_Method('qux');
        $methodQux->defineProtected();
        $methodQux->setCode('return true;');

        $methodQuux = new Stagehand_Class_Method('quux');
        $methodQuux->definePrivate();
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
    public function accessMethodAndUpdate()
    {
        $className = 'ExampleForMethodUpdate';
        $class = new Stagehand_Class($className);

        $method1 = new Stagehand_Class_Method('foo');
        $method1->setCode('return 100;');
        $class->addMethod($method1);

        $this->assertSame($class->getMethod('foo'), $method1);

        $method2 = new Stagehand_Class_Method('foo');
        $method2->setCode('return 200;');
        $class->setMethod($method2);

        $this->assertSame($class->getMethod('foo'), $method2);

        $class->load();
        $instance = new $className;

        $this->assertEquals($instance->foo(), 200);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfAddsMethodIsDuplicated()
    {
        $className = 'ExampleForMethodDuplicate';
        $class = new Stagehand_Class($className);

        $method1 = new Stagehand_Class_Method('a');
        $method2 = new Stagehand_Class_Method('a');
        $class->addMethod($method1);
        $class->addMethod($method2);
    }

    /**
     * @test
     */
    public function setConstantAndUse()
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
    public function accessConstantAndUpdate()
    {
        $className = 'ExampleForConstantUpdate';
        $class = new Stagehand_Class($className);

        $constant1 = new Stagehand_Class_Constant('a', 100);
        $class->addConstant($constant1);

        $this->assertSame($class->getConstant('a'), $constant1);

        $constant2 = new Stagehand_Class_Constant('a', 200);
        $class->setConstant($constant2);

        $this->assertSame($class->getConstant('a'), $constant2);

        $class->load();
        $instance = new $className;

        $this->assertEquals(ExampleForConstantUpdate::a, 200);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfAddsConstantIsDuplicated()
    {
        $className = 'ExampleForConstantDuplicate';
        $class = new Stagehand_Class($className);

        $constant1 = new Stagehand_Class_Constant('a', 100);
        $constant2 = new Stagehand_Class_Constant('a', 200);
        $class->addConstant($constant1);
        $class->addConstant($constant2);
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
        require_once dirname(__FILE__) . "/ClassTest/{$baseName}.php";
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
     */
    public function defineAbstractAndUse()
    {
        $className = 'ExampleForAbsctuction';
        $class = new Stagehand_Class($className);
        $class->defineAbstract();

        $propertyA = new Stagehand_Class_Property('a', 10);
        $methodB = new Stagehand_Class_Method('b');
        $methodB->setCode("return 'foo';");
        $methodC = new Stagehand_Class_Method('c');
        $methodC->defineAbstract();

        $class->addProperty($propertyA);
        $class->addMethod($methodB);
        $class->addMethod($methodC);

        $class->load();
        $refClass = new ReflectionClass($className);
        $refMethodB = $refClass->getMethod('b');
        $refMethodC = $refClass->getMethod('c');

        $this->assertTrue($class->isAbstract());
        $this->assertTrue($refClass->isAbstract());
        $this->assertFalse($refMethodB->isAbstract());
        $this->assertTrue($refMethodC->isAbstract());

        require_once dirname(__FILE__) . "/ClassTest/ConcreteClass.php";

        $instance = new ConcreteClass();

        $this->assertEquals($instance->a, 10);
        $this->assertEquals($instance->b(), 'foo');
        $this->assertEquals($instance->c(), 'bar');
    }

    /**
     * @test
     */
    public function defineInterfaceAndUse()
    {
        $className = 'ExampleForInterface';
        $class = new Stagehand_Class($className);
        $class->defineInterface();

        $propertyA = new Stagehand_Class_Property('a');
        $methodB = new Stagehand_Class_Method('b');
        $methodC = new Stagehand_Class_Method('c');
        $methodC->defineAbstract();
        $methodC->defineStatic();
        $methodD = new Stagehand_Class_Method('d');
        $methodD->defineProtected();
        $methodE = new Stagehand_Class_Method('e');
        $methodE->definePrivate();

        $class->addProperty($propertyA);
        $class->addMethod($methodB);
        $class->addMethod($methodC);
        $class->addMethod($methodD);
        $class->addMethod($methodE);

        $class->load();
        $refClass = new ReflectionClass($className);

        $this->assertEquals($refClass->getName(), $className);
        $this->assertTrue($refClass->isInterface());
        $this->assertFalse($refClass->hasProperty('a'));
        $this->assertTrue($refClass->hasMethod('b'));
        $this->assertTrue($refClass->hasMethod('c'));
        $this->assertFalse($refClass->hasMethod('d'));
        $this->assertFalse($refClass->hasMethod('e'));

        $refMethodB = $refClass->getMethod('b');
        $refMethodC = $refClass->getMethod('c');

        $this->assertTrue($refMethodB->isPublic());
        $this->assertTrue($refMethodB->isAbstract());
        $this->assertFalse($refMethodB->isStatic());
        $this->assertTrue($refMethodC->isPublic());
        $this->assertTrue($refMethodC->isAbstract());
        $this->assertTrue($refMethodC->isStatic());

        require_once dirname(__FILE__) . "/ClassTest/ImplementedClass.php";
        $instance = new ImplementedClass();

        $this->assertEquals($instance->b(), 'foo');
        $this->assertEquals(ImplementedClass::c(), 'bar');
    }

    /**
     * @test
     */
    public function implementInterfaceAndOverride()
    {
        $baseName = 'ExampleForImplementInterface';
        $childName = 'ExampleForImplementedClass';

        $baseClass = new Stagehand_Class($baseName);
        $childClass = new Stagehand_Class($childName);

        $method = new Stagehand_Class_Method('foo');
        $baseClass->addMethod($method);
        $childClass->addMethod($method);

        $baseClass->defineInterface();
        $childClass->addInterface($baseClass);
        $childClass->load();

        $baseRefClass = new ReflectionClass($baseName);
        $childRefClass = new ReflectionClass($childName);
        $interfaces = $childRefClass->getInterfaces();

        $this->assertEquals($baseRefClass->getName(), $baseName);
        $this->assertTrue($baseRefClass->isInterface());
        $this->assertTrue($baseRefClass->hasMethod('foo'));

        $this->assertEquals($childRefClass->getName(), $childName);
        $this->assertFalse($childRefClass->isInterface());
        $this->assertTrue($childRefClass->hasMethod('foo'));

        $this->assertEquals(count($interfaces), 1);
        $this->assertEquals($interfaces[$baseName]->getName(), $baseName);
    }

    /**
     * @test
     */
    public function accessInterfaceAndUpdate()
    {
        $className = 'ExampleForInterfaceUpdate';
        $class = new Stagehand_Class($className);

        $interface1 = new Stagehand_Class('ExampleForInterfaceUpdateInterface1');
        $interface1->defineInterface();
        $class->addInterface($interface1);

        $this->assertSame($class->getInterface('ExampleForInterfaceUpdateInterface1'), $interface1);

        $interface2 = new Stagehand_Class('ExampleForInterfaceUpdateInterface1');
        $interface2->defineInterface();
        $class->setInterface($interface2);

        $this->assertSame($class->getInterface('ExampleForInterfaceUpdateInterface1'), $interface2);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfAddsInterfaceIsDuplicated()
    {
        $className = 'ExampleForInterfaceDuplicate';
        $class = new Stagehand_Class($className);

        $interface1 = new Stagehand_Class('ExampleForInterfaceUpdateInterface1');
        $interface2 = new Stagehand_Class('ExampleForInterfaceUpdateInterface1');
        $class->addInterface($interface1);
        $class->addInterface($interface2);
    }

    /**
     * @test
     */
    public function defineFinal()
    {
        $className = 'ExampleForNonFinalClass';
        $finalClassName = 'ExampleForFinalClass';

        $class      = new Stagehand_Class($className);
        $finalClass = new Stagehand_Class($finalClassName);
        $finalClass->defineFinal();

        $this->assertFalse($class->isFinal());
        $this->assertTrue($finalClass->isFinal());

        $class->load();
        $finalClass->load();

        $refClass      = new ReflectionClass($className);
        $refFinalClass = new ReflectionClass($finalClassName);

        $this->assertFalse($refClass->isFinal());
        $this->assertTrue($refFinalClass->isFinal());
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
