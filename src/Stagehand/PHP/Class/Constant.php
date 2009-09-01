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

// {{{ Stagehand_PHP_Class_Constant

/**
 * A class for constant of a PHP class.
 *
 * @package    stagehand-php-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_Constant extends Stagehand_PHP_Class_Declaration
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
    private $_value;
    private $_isParsable;

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ __construct()

    /**
     * Sets this constant name.
     *
     * @param string  $name
     * @param mixed   $value
     * @param boolean $isParsable
     * @throws Stagehand_PHP_Class_Exception
     */
    public function __construct($name, $value = null, $isParsable = false)
    {
        $this->_name = $name;
        $this->setValue($value, $isParsable);
    }

    // }}}
    // {{{ setName()

    /**
     * Sets a constant name.
     *
     * @param string $name  Propety name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    // }}}
    // {{{ getName()

    /**
     * Gets a constant name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    // }}}
    // {{{ setValue()

    /**
     * Sets a constant value.
     *
     * @param string  $value       Propety value
     * @param boolean $isParsable  A value is parsable or not
     * @throws Stagehand_PHP_Class_Exception
     */
    public function setValue($value, $isParsable = false)
    {
        if ($isParsable) {
            $this->_value = $value;
        } else {
            if ($this->_isValidValue($value)) {
                $this->_value = $value;
            }
        }

        $this->_isParsable = $isParsable;
    }

    // }}}
    // {{{ getValue()

    /**
     * Gets a constant value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }

    // }}}
    // {{{ isParsable

    /**
     * Returns whether a value is parable or not.
     *
     * @return boolean
     */
    public function isParsable()
    {
        return $this->_isParsable ? true : false;
    }

    // }}}
    // {{{ render()

    /**
     * Renders a constant code.
     *
     * @return string
     */
    public function render()
    {
        $value = $this->isParsable() ?
            $this->getValue() : var_export($this->getValue(), true);

        return sprintf('const %s = %s;',
                       $this->getName(), $value
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
    // {{{ _isValidValue()

    /**
     * Returns whether the value is valid for constant's default or not.
     *
     * @param  mixed  $value
     * @return boolean
     * @throws Stagehand_PHP_Class_Exception
     */
    private function _isValidValue($value)
    {
        if (!is_null($value)
            && !is_bool($value)
            && !is_string($value)
            && !is_numeric($value)
            ) {
            throw new Stagehand_PHP_Class_Exception("Invalid value type, should be integer, string, or array.");
        }

        return true;
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
