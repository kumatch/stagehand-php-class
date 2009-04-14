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

// {{{ Stagehand_Class_Method

/**
 * Stagehand_Class_Method.
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */

class Stagehand_Class_Method extends Stagehand_Class_Declaration
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

    private $_name;
    private $_arguments = array();
    private $_code;

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ __construct()

    /**
     * Sets this method name.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->_name = $name;
        $this->setPublic();
    }

    // }}}
    // {{{ setName()

    /**
     * Sets the method name.
     *
     * @param string $name  method name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    // }}}
    // {{{ getName()

    /**
     * Gets the method name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    // }}}
    // {{{ addArgument()

    /**
     * Adds a method argument.
     *
     * @param string  $name      argument name.
     * @param boolean $required  argument is required.
     * @param mixed   $value     argument's default value.
     */
    public function addArgument($name, $required = true, $value = null)
    {
        $argument = new Stagehand_Class_Method_Argument($name, $required, $value);
        array_push($this->_arguments, $argument);
    }

    // }}}
    // {{{ setCode()

    /**
     * Sets a method code.
     *
     * @param string  $code  a method code.
     */
    public function setCode($code)
    {
        $this->_code = $code;
    }

    // }}}
    // {{{ getPartialCode()

    /**
     * Gets a partial code for class method.
     *
     * @return string
     */
    public function getPartialCode()
    {
        $format = "%s%s function %s(%s)
{
%s
}
";

        return sprintf($format,
                       $this->getVisibility(),
                       $this->isStatic() ? ' static' : null,
                       $this->_name,
                       $this->_formatArguments($this->_arguments),
                       $this->_indentCode($this->_code)
                       );
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    // }}}
    // {{{ _formatArguments()

    /**
     * Formats arguments available to class method.
     *
     * @param string  $code
     * @return string
     */
    public function _formatArguments($arguments)
    {
        $formatedArguments = null;

        foreach ($arguments as $argument) {
            if (!is_null($formatedArguments)) {
                $formatedArguments .= ', ';
            }

            $formatedArguments .= '$' . $argument->getName();
            if (!$argument->isRequired()) {
                $formatedArguments .= ' = ' . $argument->getValue();
            }
        }

        return $formatedArguments;
    }

    // }}}
    // {{{ _indentCode()

    /**
     * Indents code lines.
     *
     * @param string  $code
     * @return string
     */
    public function _indentCode($code)
    {
        $indentedCode = null;

        foreach (explode("\n", str_replace("\r\n", "\n", $code)) as $line) {
            if (!is_null($indentedCode)) {
                $indentedCode .= "\n";
            }
            $indentedCode .= "    $line";
        }

        return $indentedCode;
    }

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
