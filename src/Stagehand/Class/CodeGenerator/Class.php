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

// {{{ Stagehand_Class_CodeGenerator_Class

/**
 * Stagehand_Class_CodeGenerator_Class.
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */

class Stagehand_Class_CodeGenerator_Class
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

    protected $_class;

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ __construct()

    /**
     * Sets the Stagehand_Class instance.
     *
     * @param Stagehand_Class  $class
     */
    public function __construct(Stagehand_Class $class)
    {
        $this->_class = $class;
    }

    // }}}
    // {{{ generate()

    /**
     * Generates the code.
     *
     * @return string
     */
    public function generate()
    {
        return sprintf($this->_getClassFormat(),
                       $this->_class->getName(),
                       $this->_getParentClassCode(),
                       $this->_getInterfacesCode(),
                       $this->_getAllConstantsCode(),
                       $this->_getAllPropertiesCode(),
                       $this->_getAllMethodsCode()
                       );
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    // }}}
    // {{{ _getClassFormat

    /**
     * Gets a class code Format
     *
     * @return string
     */
    protected function _getClassFormat()
    {
        return "class %s%s%s
{
%s
%s
%s}
";
    }

    // }}}
    // {{{ _getMethodFormat

    /**
     * Gets a method code Format
     *
     * @return string
     */
    protected function _getMethodFormat($method)
    {
        if ($method->isAbstract()) {
            return;
        }

        return "%s%s function %s(%s)
{
%s}";
    }

    // }}}
    // {{{ _getAllPropertiesCode()

    /**
     * Gets all propertie's code.
     *
     * @return string
     */
    protected function _getAllPropertiesCode()
    {
        $allPropertiesCode = null;
        foreach ($this->_class->getProperties() as $property) {
            $allPropertiesCode .= $this->_createPropertyCode($property) . "\n";
        }

        return $this->_indentCode($allPropertiesCode);
    }

    // }}}
    // {{{ _getAllMethodsCode()

    /**
     * Gets all method's code.
     *
     * @return string
     */
    protected function _getAllMethodsCode()
    {
        $allMethodsCode = null;
        foreach ($this->_class->getMethods() as $method) {
            $allMethodsCode .= $this->_createMethodCode($method) . "\n";
        }

        return $this->_indentCode($allMethodsCode);
    }

    // }}}
    // {{{ _getAllConstantsCode()

    /**
     * Gets all constant's code.
     *
     * @return string
     */
    protected function _getAllConstantsCode()
    {
        $allConstantsCode = null;
        foreach ($this->_class->getConstants() as $constant) {
            $allConstantsCode .= $this->_createConstantCode($constant) . "\n";
        }

        return $this->_indentCode($allConstantsCode);
    }

    // }}}
    // {{{ _createPropertyCode()

    /**
     * Creates a partial code for class property.
     *
     ` @param  Stagehand_Class_Property $property
     * @return string
     */
    protected function _createPropertyCode($property)
    {
        $format = null;
        $formatedValue = null;

        if ($property->getValue()) {
            $format = "%s%s $%s = %s;";
            $formatedValue = var_export($property->getValue(), true);
        } else {
            $format = '%s%s $%s;';
        }

        return sprintf($format,
                       $property->getVisibility(),
                       $property->isStatic() ? ' static' : null,
                       $property->getName(), $formatedValue
                       );
    }

    // }}}
    // {{{ _createMethodCode()

    /**
     * Creates a partial code for class method.
     *
     ` @param  Stagehand_Class_Method $method
     * @return string
     */
    protected function _createMethodCode($method)
    {
        return sprintf($this->_getMethodFormat($method),
                       $method->getVisibility(),
                       $method->isStatic() ? ' static' : null,
                       $method->getName(),
                       $this->_formatArguments($method->getArguments()),
                       $this->_indentCode($method->getCode())
                       );
    }

    // }}}
    // {{{ _createConstantCode()

    /**
     * Creates a partial code for class constant.
     *
     * @return string
     */
    protected function _createConstantCode($constant)
    {
        return sprintf('const %s = %s;',
                       $constant->getName(), var_export($constant->getValue(), true)
                       );
    }

    // }}}
    // {{{ _getParentClassCode()

    /**
     * Gets parent class code.
     *
     * @return string
     */
    protected function _getParentClassCode()
    {
        if (!$this->_class->hasParentClass()) {
            return;
        }

        $parentClass = $this->_class->getParentClass();
        if ($parentClass instanceof Stagehand_Class) {
            $code = ' extends ' . $parentClass->getName();
        } else {
            $code = ' extends ' . $parentClass;
        }

        return $code;
    }

    // }}}
    // {{{ _getInterfacesCode()

    /**
     * Gets interfaces code.
     *
     * @return string
     */
    protected function _getInterfacesCode()
    {
        if (!$this->_class->hasInterface()) {
            return;
        }

        $interfaceNames = array();
        foreach ($this->_class->getInterfaces() as $interface) {
            if ($interface instanceof Stagehand_Class) {
                array_push($interfaceNames, $interface->getName());
            } else {
                array_push($interfaceNames, $interface);
            }
        }

        return ' implements ' . implode(', ', $interfaceNames);
    }

    // }}}
    // {{{ _formatArguments()

    /**
     * Formats arguments available to class method.
     *
     * @param string  $code
     * @return string
     */
    protected function _formatArguments($arguments)
    {
        $formatedArguments = array();
        foreach ($arguments as $argument) {
            $oneArg = '$' . $argument->getName();
            if (!$argument->isRequired()) {
                $oneArg .= ' = ' . $argument->getValue();
            }
            array_push($formatedArguments, $oneArg);
        }

        return implode(', ', $formatedArguments);
    }

    // }}}
    // {{{ _indentCode()

    /**
     * Indents code lines.
     *
     * @param string  $code
     * @return string
     */
    protected function _indentCode($code)
    {
        if (!$code) {
            return;
        }

        $indentedCode = null;
        foreach (explode("\n", str_replace("\r\n", "\n", $code)) as $line) {
            if ($line) {
                $indentedCode .= "    {$line}\n";
            }
        }

        return $indentedCode;
    }

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
