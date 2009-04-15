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

// {{{ Stagehand_Class

/**
 * Stagehand_Class.
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */

class Stagehand_Class
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
    private $_parentClass;
    private $_properties = array();
    private $_methods = array();
    private $_constants = array();
    private $_isAbstract = false;

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ __construct()

    /**
     * Sets this class name.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->_name = $name;
    }

    // }}}
    // {{{ getName()

    /**
     * Gets the class name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    // }}}
    // {{{ load()

    /**
     * Loads the class.
     *
     */
    public function load()
    {
        $format = "%sclass %s%s
{
%s
%s
%s
}
";

        $classContent = sprintf($format,
                                $this->isAbstract() ? 'abstract ' : null,
                                $this->getName(),
                                $this->_getParentClassCode(),
                                $this->_getAllConstantsCode(),
                                $this->_getAllPropertiesCode(),
                                $this->_getAllMethodsCode()
                                );

        eval($classContent);
    }

    // }}}
    // {{{ addProperty()

    /**
     * Addes a property.
     *
     * @param Stagehand_Class_Property $property
     */
    public function addProperty(Stagehand_Class_Property $property)
    {
        array_push($this->_properties, $property);
    }

    // }}}
    // {{{ getProperties()

    /**
     * Gets all properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    // }}}
    // {{{ addMethod()

    /**
     * Addes a method.
     *
     * @param Stagehand_Class_Method $method
     */
    public function addMethod(Stagehand_Class_Method $method)
    {
        array_push($this->_methods, $method);
    }

    // }}}
    // {{{ getMethods()

    /**
     * Gets all methods.
     *
     * @return array
     */
    public function getMethods()
    {
        return $this->_methods;
    }

    // }}}
    // {{{ addConstant()

    /**
     * Addes a constant.
     *
     * @param Stagehand_Class_Constant $constant
     */
    public function addConstant(Stagehand_Class_Constant $constant)
    {
        array_push($this->_constants, $constant);
    }

    // }}}
    // {{{ getConstants()

    /**
     * Gets all constants.
     *
     * @return array
     */
    public function getConstants()
    {
        return $this->_constants;
    }

    // }}}
    // {{{ setParentClass()

    /**
     * Sets parent class.
     *
     * @param mixed $class  Stagehand_Class or class name.
     */
    public function setParentClass($class)
    {
        $this->_parentClass = $class;
    }

    // }}}
    // {{{ setAbstract()

    /**
     * Sets the abstract class.
     *
     */
    public function setAbstract($isAbstract = true)
    {
        $this->_isAbstract = $isAbstract ? true : false;
    }

    // }}}
    // {{{ isAbstract()

    /**
     * Returns whether the abstract class or not.
     *
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->_isAbstract ? true : false;
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
    // {{{ _getParentClassCode()

    /**
     * Gets parent class code.
     *
     * @return string
     * @throws Stagehand_Class_Exception
     */
    public function _getParentClassCode()
    {
        if (!$this->_parentClass) {
            return;
        }

        $parentClassCode = null;
        if ($this->_parentClass instanceof Stagehand_Class) {
            $className = $this->_parentClass->getName();
            if (!class_exists($className)) {
                $this->_parentClass->load();
            }
        } else {
            $className = $this->_parentClass;
            if (!class_exists($className)) {
                throw new Stagehand_Class_Exception("The class [{$className}] does not exists.");
            }
        }

        $parentClassCode = ' extends ' . $className;
        return $parentClassCode;
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
