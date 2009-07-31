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

// {{{ Stagehand_Class

/**
 * A class for PHP class.
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
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
    private $_docComment;
    private $_preCode;
    private $_postCode;
    private $_interfaces = array();
    private $_constants  = array();
    private $_properties = array();
    private $_methods    = array();

    private $_isAbstract  = false;
    private $_isInterface = false;
    private $_isFinal     = false;

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ __construct()

    /**
     * Sets this class name.
     *
     * @param string $name class name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    // }}}
    // {{{ load()

    /**
     * Loads a class.
     */
    public function load()
    {
        if (class_exists($this->getName())) {
            throw new Stagehand_Class_Exception("The class [{$this->getName()}] is declared already.");
        }

        $this->_initializeParentClass();
        $this->_initializeInterface();

        eval($this->render());
    }

    // }}}
    // {{{ render()

    /**
     * Renders a class contents.
     *
     * @return string
     */
    public function render()
    {
        $generator = Stagehand_Class_CodeGenerator::create($this);
        return $generator->generate();
    }

    // }}}
    // {{{ setName()

    /**
     * Sets a class name.
     *
     * @param string $name class name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    // }}}
    // {{{ getName()

    /**
     * Gets a class name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
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
        if ($this->hasProperty($property->getName())) {
            throw new Stagehand_Class_Exception("The property [{$property->getName()}] is duplicated.");
        }

        $this->setProperty($property);
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
    // {{{ getProperty()

    /**
     * Gets a target property.
     *
     * @param string $name  property name
     * @return mixed
     */
    public function getProperty($name)
    {
        if (!$this->hasProperty($name)) {
            return;
        }

        return $this->_properties[$name];
    }

    // }}}
    // {{{ setProperty()

    /**
     * Sets a property.
     *
     * @param Stagehand_Class_Property $property
     */
    public function setProperty(Stagehand_Class_Property $property)
    {
        $this->_properties[ $property->getName() ] = $property;
    }

    // }}}
    // {{{ hasProperty()

    /**
     * Returns whether a class has target name's property.
     *
     * @param string $name  property name
     */
    public function hasProperty($name)
    {
        if (!array_key_exists($name, $this->_properties)) {
            return false;
        }

        return true;
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
        if ($this->hasMethod($method->getName())) {
            throw new Stagehand_Class_Exception("The method [{$method->getName()}] is duplicated.");
        }

        $this->setMethod($method);
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
    // {{{ getMethod()

    /**
     * Gets a target method.
     *
     * @param string $name  method name
     * @return mixed
     */
    public function getMethod($name)
    {
        if (!$this->hasMethod($name)) {
            return;
        }

        return $this->_methods[$name];
    }

    // }}}
    // {{{ setMethod()

    /**
     * Sets a method.
     *
     * @param Stagehand_Class_Method $method
     */
    public function setMethod(Stagehand_Class_Method $method)
    {
        $this->_methods[ $method->getName() ] = $method;
    }

    // }}}
    // {{{ hasMethod()

    /**
     * Returns whether a class has target name's method.
     *
     * @param string $name  method name
     */
    public function hasMethod($name)
    {
        if (!array_key_exists($name, $this->_methods)) {
            return false;
        }

        return true;
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
        if ($this->hasConstant($constant->getName())) {
            throw new Stagehand_Class_Exception("The constant [{$constant->getName()}] is duplicated.");
        }

        $this->setConstant($constant);
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
    // {{{ getConstant()

    /**
     * Gets a target constant.
     *
     * @param string $name  constant name
     * @return mixed
     */
    public function getConstant($name)
    {
        if (!$this->hasConstant($name)) {
            return;
        }

        return $this->_constants[$name];
    }

    // }}}
    // {{{ setConstant()

    /**
     * Sets a constant.
     *
     * @param Stagehand_Class_Constant $constant
     */
    public function setConstant(Stagehand_Class_Constant $constant)
    {
        $this->_constants[ $constant->getName() ] = $constant;
    }

    // }}}
    // {{{ hasConstant()

    /**
     * Returns whether a class has target name's constant.
     *
     * @param string $name  constant name
     */
    public function hasConstant($name)
    {
        if (!array_key_exists($name, $this->_constants)) {
            return false;
        }

        return true;
    }

    // }}}
    // {{{ setParentClass()

    /**
     * Sets parent class.
     *
     * @param mixed $class  Stagehand_Class instance or class name.
     */
    public function setParentClass($class)
    {
        $this->_parentClass = $class;
    }

    // }}}
    // {{{ getParentClass()

    /**
     * Gets parent class.
     *
     * @return mixed
     */
    public function getParentClass()
    {
        return $this->_parentClass;
    }

    // }}}
    // {{{ hasParentClass()

    /**
     * Returns whether a class has the parent class.
     *
     * @param boolean
     */
    public function hasParentClass()
    {
        return $this->_parentClass ? true : false;
    }

    // }}}
    // {{{ addInterface()

    /**
     * Addes a interface.
     *
     * @param mixed $interface  Stagehand_Class instance or interface name
     */
    public function addInterface($interface)
    {
        $name = $this->_getInterfaceName($interface);
        if ($this->hasInterface($name)) {
            throw new Stagehand_Class_Exception("The interface [{$name}] is duplicated.");
        }

        $this->setInterface($interface);
    }

    // }}}
    // {{{ getInterfaces()

    /**
     * Gets all interfaces.
     *
     * @return array
     */
    public function getInterfaces()
    {
        return $this->_interfaces;
    }

    // }}}
    // {{{ getInterface()

    /**
     * Gets a target interface.
     *
     * @param string $name  interface name
     * @return mixed
     */
    public function getInterface($name)
    {
        if (!$this->hasInterface($name)) {
            return;
        }

        return $this->_interfaces[$name];
    }

    // }}}
    // {{{ setInterface()

    /**
     * Sets a interface.
     *
     * @param mixed $interface  Stagehand_Class instance or interface name
     */
    public function setInterface($interface)
    {
        $name = $this->_getInterfaceName($interface);
        $this->_interfaces[ $name ] = $interface;
    }

    // }}}
    // {{{ hasInterface()

    /**
     * Returns whether a class has target name's interface.
     *
     * @param string $name  interface name
     */
    public function hasInterface($name)
    {
        if (!array_key_exists($name, $this->_interfaces)) {
            return false;
        }

        return true;
    }

    // }}}
    // {{{ countInterfaces()

    /**
     * Counts a class has interfaces.
     *
     * @return integer
     */
    public function countInterfaces()
    {
        return count($this->_interfaces);
    }

    // }}}
    // {{{ defineAbstract()

    /**
     * Defines abstract class.
     *
     * @param boolean $isAbstract  is abstract
     */
    public function defineAbstract($isAbstract = true)
    {
        $this->_isAbstract = $isAbstract ? true : false;
        if ($this->_isAbstract) {
            $this->_isInterface = false;
            $this->_isFinal = false;
        }
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

    // }}}
    // {{{ defineInterface()

    /**
     * Defines interface class.
     *
     * @param boolean $isInterface  is interface
     */
    public function defineInterface($isInterface = true)
    {
        $this->_isInterface = $isInterface ? true : false;
        if ($this->_isInterface) {
            $this->_isAbstract = false;
            $this->_isFinal = false;
        }
    }

    // }}}
    // {{{ isInterface()

    /**
     * Returns whether the interface class or not.
     *
     * @return boolean
     */
    public function isInterface()
    {
        return $this->_isInterface ? true : false;
    }

    // }}}
    // {{{ defineFinal()

    /**
     * Defines final class.
     *
     * @param boolean $isFinal  is final
     */
    public function defineFinal($isFinal = true)
    {
        $this->_isFinal = $isFinal ? true : false;
        if ($this->_isFinal) {
            $this->_isAbstract = false;
            $this->_isInterface = false;
        }
    }

    // }}}
    // {{{ isFinal()

    /**
     * Returns whether the final class or not.
     *
     * @return boolean
     */
    public function isFinal()
    {
        return $this->_isFinal ? true : false;
    }

    // }}}
    // {{{ setDocComment()

    /**
     * Sets a doc comment.
     *
     * @param string  $docComment  A DocComment value.
     * @param boolean $isFormated  A DocComment is formated (default false).
     */
    public function setDocComment($docComment, $isFormated = false)
    {
        if (!$isFormated) {
            $docComment = Stagehand_Class_CodeGenerator::formatDocComment($docComment);
        }

        $this->_docComment = $docComment;
    }

    // }}}
    // {{{ getDocComment()

    /**
     * Gets a doc comment.
     *
     * @return string
     */
    public function getDocComment()
    {
        return $this->_docComment;
    }

    // }}}
    // {{{ setPreCode()

    /**
     * Sets a pre code of class declaration.
     *
     * @param string  $preCode  A PreCode value.
     */
    public function setPreCode($preCode)
    {
        $this->_preCode = $preCode;
    }

    // }}}
    // {{{ getPreCode()

    /**
     * Gets a pre code of class declaration.
     *
     * @return string
     */
    public function getPreCode()
    {
        return $this->_preCode;
    }

    // }}}
    // {{{ setPostCode()

    /**
     * Sets a post code of class declaration.
     *
     * @param string  $postCode  A PostCode value.
     */
    public function setPostCode($postCode)
    {
        $this->_postCode = $postCode;
    }

    // }}}
    // {{{ getPostCode()

    /**
     * Gets a post code of class declaration.
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->_postCode;
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
    // {{{ _initializeParentClass()

    /**
     * Initializes parent class.
     */
    private function _initializeParentClass()
    {
        if (!$this->hasParentClass()) {
            return;
        }

        $this->_loadClass($this->getParentClass());
    }

    // }}}
    // {{{ _initializeInterface()

    /**
     * Initializes parent class.
     */
    private function _initializeInterface()
    {
        if (!$this->countInterfaces()) {
            return;
        }

        foreach ($this->getInterfaces() as $interface) {
            $this->_loadClass($interface);
        }
    }

    // }}}
    // {{{ _loadClass()

    /**
     * Loads class if Stagehand_Class instance does not loaded.
     *
     * @param mixed $class  Stagehand_Class instance or class name
     */
    private function _loadClass($class)
    {
        if ($class instanceof Stagehand_Class
            && !class_exists($class->getName())
            && !interface_exists($class->getName())
            ) {
            $class->load();
        }
    }

    // }}}
    // {{{ _getInterfaceName()

    /**
     * Gets a interface name.
     *
     * @param mixed $interface  Stagehand_Class instance or interface name
     * @return string
     */
    private function _getInterfaceName($interface)
    {
        if ($interface instanceof Stagehand_Class) {
            return $interface->getName();
        } else {
            return $interface;
        }
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
