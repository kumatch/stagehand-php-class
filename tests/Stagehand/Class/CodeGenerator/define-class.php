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

// {{{ Defines class for code generation test.

function define_class_for_code_genration_test()
{
    $className = 'ExampleForCodeGenerationTest';
    $class = new Stagehand_Class($className);

    $publicProperty    = new Stagehand_Class_Property('a');
    $protectedProperty = new Stagehand_Class_Property('b', 100);
    $privateProperty   = new Stagehand_Class_Property('c', array(1, 3, 5));
    $staticProperty    = new Stagehand_Class_Property('d', 'static');
    $protectedProperty->defineProtected();
    $privateProperty->definePrivate();
    $staticProperty->defineStatic();

    $argumentA = new Stagehand_Class_Method_Argument('a');
    $argumentB = new Stagehand_Class_Method_Argument('b');
    $argumentC = new Stagehand_Class_Method_Argument('c');
    $argumentD = new Stagehand_Class_Method_Argument('d');
    $argumentE = new Stagehand_Class_Method_Argument('e');
    $argumentC->setRequirement(false);
    $argumentD->setRequirement(false);
    $argumentD->setValue('d');
    $argumentE->setRequirement(false);
    $argumentE->setValue(array(2, 4, 6));

    $publicMethod    = new Stagehand_Class_Method('foo');
    $protectedMethod = new Stagehand_Class_Method('bar');
    $privateMethod   = new Stagehand_Class_Method('baz');
    $staticMethod    = new Stagehand_Class_Method('qux');
    $abstractMethod  = new Stagehand_Class_Method('quux');
    $abstractStaticMethod = new Stagehand_Class_Method('corge');
    $finalMethod       = new Stagehand_Class_Method('grault');
    $finalStaticMethod = new Stagehand_Class_Method('garply');
    $protectedMethod->defineProtected();
    $protectedMethod->addArgument($argumentA);
    $protectedMethod->addArgument($argumentB);
    $protectedMethod->setCode('return true;');
    $privateMethod->definePrivate();
    $privateMethod->addArgument($argumentC);
    $privateMethod->addArgument($argumentD);
    $privateMethod->setCode('$c += 1;
return $d;');
    $staticMethod->defineStatic();
    $staticMethod->addArgument($argumentE);
    $abstractMethod->defineAbstract();
    $abstractStaticMethod->defineAbstract();
    $abstractStaticMethod->defineStatic();
    $finalMethod->defineFinal();
    $finalStaticMethod->defineFinal();
    $finalStaticMethod->defineStatic();

    $constant1 = new Stagehand_Class_Constant('A');
    $constant2 = new Stagehand_Class_Constant('B', 10);
    $constant3 = new Stagehand_Class_Constant('C', 'text constant');

    $class->addProperty($publicProperty);
    $class->addProperty($protectedProperty);
    $class->addProperty($privateProperty);
    $class->addProperty($staticProperty);
    $class->addMethod($publicMethod);
    $class->addMethod($protectedMethod);
    $class->addMethod($privateMethod);
    $class->addMethod($staticMethod);
    $class->addMethod($abstractMethod);
    $class->addMethod($abstractStaticMethod);
    $class->addMethod($finalMethod);
    $class->addMethod($finalStaticMethod);
    $class->addConstant($constant1);
    $class->addConstant($constant2);
    $class->addConstant($constant3);

    return $class;
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
