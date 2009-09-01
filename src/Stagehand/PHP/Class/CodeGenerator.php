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

// {{{ Stagehand_PHP_Class_CodeGenerator

/**
 * A class for code generator of a PHP class.
 *
 * @package    stagehand-php-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_CodeGenerator extends Stagehand_PHP_Class_Declaration
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

    // }}}
    // {{{ create()

    /**
     * Creates a code generator.
     *
     * @param Stagehand_PHP_Class  $class
     * @param mixed
     */
    public static function create(Stagehand_PHP_Class $class)
    {
        if ($class->isAbstract()) {
            return new Stagehand_PHP_Class_CodeGenerator_AbstractClass($class);
        } elseif ($class->isInterface()) {
            return new Stagehand_PHP_Class_CodeGenerator_Interface($class);
        } else {
            return new Stagehand_PHP_Class_CodeGenerator_Class($class);
        }
    }

    // }}}
    // {{{ indent()

    /**
     * Indents code lines.
     *
     * @param string  $code
     * @return string
     */
    public static function indent($code)
    {
        if (!$code) {
            return;
        }

        $indentedCode = null;
        foreach (explode("\n", str_replace("\r\n", "\n", $code)) as $line) {
            if ($line) {
                $indentedCode .= "    {$line}\n";
            } else {
                $indentedCode .= "\n";
            }
        }

        return $indentedCode;
    }

    // }}}
    // {{{ formatDocComment()

    /**
     * Formats a doc comment.
     *
     * @param  string $docComment
     * @return string
     */
    public static function formatDocComment($docComment)
    {
        if (!$docComment) {
            return;
        }

        $formatedDocComment = null;
        foreach (explode("\n", str_replace("\r\n", "\n", $docComment)) as $line) {
            if ($line) {
                $formatedDocComment .= " * {$line}\n";
            } else {
                $formatedDocComment .= " *\n";
            }
        }

        return <<<DOC_COMMENT
/**
{$formatedDocComment} */
DOC_COMMENT;
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
