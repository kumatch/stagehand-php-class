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

// {{{ Stagehand_Class_CodeGenerator_ClassTest

/**
 * Some tests for Stagehand_Class_CodeGenerator_ClassTest
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */

class Stagehand_Class_CodeGenerator_ClassTest extends PHPUnit_Framework_TestCase
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
    public function generateClassCode()
    {
        $className = 'ExampleForClassCodeGeneration';
        $class = new Stagehand_Class($className);

        $publicProperty = new Stagehand_Class_Property('a');
        $protectedProperty = new Stagehand_Class_Property('b', 100);
        $protectedProperty->setProtected();
        $privateProperty = new Stagehand_Class_Property('c', array(1, 3, 5));
        $privateProperty->setPrivate();
        $staticProperty = new Stagehand_Class_Property('d', 'static');
        $staticProperty->setStatic();

        $class->addProperty($publicProperty);
        $class->addProperty($protectedProperty);
        $class->addProperty($privateProperty);
        $class->addProperty($staticProperty);

        $generator = new Stagehand_Class_CodeGenerator_Class($class);
        $code = $generator->generate();

        $this->assertEquals($code, "class {$className}
{
    public \$a;
    protected \$b = 100;
    private \$c = array (
  0 => 1,
  1 => 3,
  2 => 5,
);
    public static \$d = 'static';

}
");

    }

    /**
     * @foo
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