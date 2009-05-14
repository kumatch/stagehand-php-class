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

// {{{ Stagehand_Class_PropertyTest

/**
 * Some tests for Stagehand_Class_Property
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_Class_PropertyTest extends PHPUnit_Framework_TestCase
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
    public function createAPublicProperty()
    {
        $name = 'example';
        $property = new Stagehand_Class_Property($name);

        $this->assertEquals($property->getName(), $name);
        $this->assertEquals($property->getVisibility(), 'public');
        $this->assertTrue($property->isPublic());
        $this->assertFalse($property->isProtected());
        $this->assertFalse($property->isPrivate());
    }

    /**
     * @test
     */
    public function createAProtectedProperty()
    {
        $name = 'example';
        $property = new Stagehand_Class_Property($name);
        $property->defineProtected();

        $this->assertEquals($property->getName(), $name);
        $this->assertEquals($property->getVisibility(), 'protected');
        $this->assertFalse($property->isPublic());
        $this->assertTrue($property->isProtected());
        $this->assertFalse($property->isPrivate());
    }

    /**
     * @test
     */
    public function createAPrivateProperty()
    {
        $name = 'example';
        $property = new Stagehand_Class_Property($name);
        $property->definePrivate();

        $this->assertEquals($property->getName(), $name);
        $this->assertEquals($property->getVisibility(), 'private');
        $this->assertFalse($property->isPublic());
        $this->assertFalse($property->isProtected());
        $this->assertTrue($property->isPrivate());
    }

    /**
     * @test
     */
    public function changeTheProperyName()
    {
        $name = 'example';
        $property = new Stagehand_Class_Property($name);

        $this->assertEquals($property->getName(), $name);

        $name = 'otherName';
        $property->setName($name);

        $this->assertEquals($property->getName(), $name);
    }

    /**
     * @test
     */
    public function setAVisibilityByKeyword()
    {
        $name = 'example';
        $property = new Stagehand_Class_Property($name);
        $property->setVisibility('protected');

        $this->assertEquals($property->getVisibility(), 'protected');
        $this->assertFalse($property->isPublic());
        $this->assertTrue($property->isProtected());
        $this->assertFalse($property->isPrivate());

        $property->setVisibility('private');

        $this->assertEquals($property->getVisibility(), 'private');
        $this->assertFalse($property->isPublic());
        $this->assertFalse($property->isProtected());
        $this->assertTrue($property->isPrivate());

        $property->setVisibility('public');

        $this->assertEquals($property->getVisibility(), 'public');
        $this->assertTrue($property->isPublic());
        $this->assertFalse($property->isProtected());
        $this->assertFalse($property->isPrivate());
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfVisibilityKeywordIsInvalid()
    {
        $name = 'example';
        $property = new Stagehand_Class_Property($name);
        $property->setVisibility('foo');
    }

    /**
     * @test
     */
    public function createAPropertyWithDefaultValue()
    {
        $name = 'foo';
        $value = 'Foo';
        $property = new Stagehand_Class_Property($name, $value);

        $this->assertEquals($property->getName(), $name);
        $this->assertEquals($property->getValue(), $value);

        $value = 'Bar';
        $property->setValue($value);

        $this->assertEquals($property->getName(), $name);
        $this->assertEquals($property->getValue(), $value);
    }

    /**
     * @test
     */
    public function createAPropertyWithDefaultArrayValue()
    {
        $name = 'foo';
        $value = array(1, 3, 5);
        $property = new Stagehand_Class_Property($name, $value);

        $this->assertEquals($property->getName(), $name);
        $this->assertEquals($property->getValue(), $value);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfDeclaringObjectToPropertyValue()
    {
        $name = 'foo';
        $foo = new stdClass();
        $property = new Stagehand_Class_Property($name, $foo);
    }

    /**
     * @test
     * @expectedException Stagehand_Class_Exception
     */
    public function catchTheExceptionIfDeclaringNestedTrapToPropertyValue()
    {
        $name = 'foo';
        $foo = new stdClass();
        $trap = array(1, array(2, array(3, $foo)));

        $property = new Stagehand_Class_Property($name, $trap);
    }

    /**
     * @test
     */
    public function createAStaticProperty()
    {
        $name = 'foo';
        $property = new Stagehand_Class_Property($name);

        $this->assertEquals($property->getName(), $name);
        $this->assertFalse($property->isStatic());

        $property->defineStatic();

        $this->assertTrue($property->isStatic());
    }

    /**
     * @test
     */
    public function renderProperty()
    {
        $name = 'example';
        $property = new Stagehand_Class_Property($name);

        $this->assertEquals($property->render(), 'public $example;');

        $property->defineProtected();

        $this->assertEquals($property->render(), 'protected $example;');

        $property->definePrivate();
        $property->setValue(10);

        $this->assertEquals($property->render(), 'private $example = 10;');

        $property->defineStatic();

        $this->assertEquals($property->render(), 'private static $example = 10;');
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
