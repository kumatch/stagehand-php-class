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

// {{{ Stagehand_Class_Property

/**
 * Stagehand_Class_Property.
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */

class Stagehand_Class_Property extends Stagehand_Class_Visibility
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
    public function __construct($name, $value = null)
    {
        $this->_name = $name;
        if ($value) {
            $this->setValue($value);
        }

        $this->setPublic();
    }

    // }}}
    // {{{ setName()

    /**
     * sets the property name.
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
     * Gets the property name.
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
     * sets the property value.
     *
     * @param string $value  Propety value
     */
    public function setValue($value)
    {
        if ($this->_isValidValue($value)) {
            $this->_value = $value;
        }
    }

    // }}}
    // {{{ getValue()

    /**
     * Gets the property value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }

    // }}}
    // {{{ getPartialCode()

    /**
     * Gets a partial code for class property.
     *
     * @return string
     */
    public function getPartialCode()
    {
        $format = null;
        $formatedValue = null;

        if ($this->_value) {
            $format = "%s $%s = %s;";
            $formatedValue = var_export($this->_value, true);
        } else {
            $format = '%s $%s;';
        }

        return sprintf($format,
                       $this->getVisibility(), $this->_name, $formatedValue
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
     * Returns whether the value is valid by property or not.
     *
     * @param  mixed  $value
     * @return boolean
     */
    private function _isValidValue($value)
    {
        if (!is_string($value)
            && !is_numeric($value)
            && !is_array($value)
            ) {
            throw new Stagehand_Class_Exception("Invalid value type, should be integer, string, or array.");
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
