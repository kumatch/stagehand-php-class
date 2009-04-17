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
        require_once dirname(__FILE__) . '/define-class.php';
        $class = define_class_for_code_genration_test();

        $generator = new Stagehand_Class_CodeGenerator_Class($class);
        $code = $generator->generate();

        $this->assertEquals($code, "class ExampleForCodeGenerationTest
{
    const A = NULL;
    const B = 10;
    const C = 'text constant';

    public \$a;
    protected \$b = 100;
    private \$c = array (
      0 => 1,
      1 => 3,
      2 => 5,
    );
    public static \$d = 'static';

    public function foo()
    {
    }

    protected function bar(\$a, array \$b)
    {
        return true;
    }

    private function baz(\$c = NULL, \$d = 'd')
    {
        \$c += 1;
        return \$d;
    }

    public static function qux(\$e = array (
      0 => 2,
      1 => 4,
      2 => 6,
    ))
    {
    }

    final public function grault()
    {
    }

    final public static function garply()
    {
    }
}
");
    }

    /**
     * @test
     */
    public function generateClassCodeWithParentClass()
    {
        $baseName = 'ExampleForExtendBaseClassGeneration';
        $childName = 'ExampleForExtendChildClassGeneration';

        $baseClass = new Stagehand_Class($baseName);
        $childClass = new Stagehand_Class($childName);
        $childClass->setParentClass($baseClass);

        $generator = new Stagehand_Class_CodeGenerator_Class($childClass);
        $code = $generator->generate();
        
        $this->assertRegExp("/^class {$childName} extends {$baseName}/", $code);

        $childClass->setParentClass($baseName);
        $generator = new Stagehand_Class_CodeGenerator_Class($childClass);
        $code = $generator->generate();
        
        $this->assertRegExp("/^class {$childName} extends {$baseName}/", $code);
    }

    /**
     * @test
     */
    public function generateClassCodeWithSomeInterface()
    {
        $interfaceA = 'ExampleForClassGenerationInterfaceA';
        $interfaceB = 'ExampleForClassGenerationInterfaceB';
        $className = 'ExampleForClassGenerationWithSomeInterface';

        $class = new Stagehand_Class($className);
        $classInterfaceA = new Stagehand_Class($interfaceA);
        $classInterfaceB = new Stagehand_Class($interfaceB);
        $class->addInterface($classInterfaceA);
        $class->addInterface($classInterfaceB);

        $generator = new Stagehand_Class_CodeGenerator_Class($class);
        $code = $generator->generate();

        $this->assertRegExp("/^class {$className} implements {$interfaceA}, {$interfaceB}/", $code);

        $class = new Stagehand_Class($className);
        $class->addInterface($interfaceA);
        $class->addInterface($interfaceB);

        $generator = new Stagehand_Class_CodeGenerator_Class($class);
        $code = $generator->generate();

        $this->assertRegExp("/^class {$className} implements {$interfaceA}, {$interfaceB}/", $code);
    }

    /**
     * @test
     */
    public function generateClassCodeWithParentClassAndSomeInterface()
    {
        $parentClassName = 'ExampleForClassGenerationParentClass';
        $interfaceA = 'ExampleForClassGenerationInterfaceA';
        $interfaceB = 'ExampleForClassGenerationInterfaceB';
        $className = 'ExampleForClassGenerationWithParentClassAndSomeInterface';

        $class = new Stagehand_Class($className);
        $parentClass = new Stagehand_Class($parentClassName);
        $classInterfaceA = new Stagehand_Class($interfaceA);
        $classInterfaceB = new Stagehand_Class($interfaceB);
        $class->setParentClass($parentClass);
        $class->addInterface($classInterfaceA);
        $class->addInterface($classInterfaceB);

        $generator = new Stagehand_Class_CodeGenerator_Class($class);
        $code = $generator->generate();

        $this->assertRegExp("/^class {$className} extends {$parentClassName} implements {$interfaceA}, {$interfaceB}/", $code);

        $class = new Stagehand_Class($className);
        $class->setParentClass($parentClassName);
        $class->addInterface($interfaceA);
        $class->addInterface($interfaceB);

        $generator = new Stagehand_Class_CodeGenerator_Class($class);
        $code = $generator->generate();

        $this->assertRegExp("/^class {$className} extends {$parentClassName} implements {$interfaceA}, {$interfaceB}/", $code);
    }

    /**
     * @test
     */
    public function generateFinalClassCode()
    {
        $className = 'ExampleForFinalClassGeneration';

        $class = new Stagehand_Class($className);
        $class->defineFinal();

        $generator = new Stagehand_Class_CodeGenerator_Class($class);
        $code = $generator->generate();

        $this->assertRegExp("/^final class {$className}/", $code);
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
