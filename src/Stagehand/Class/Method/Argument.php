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

// {{{ Stagehand_Class_Method_Argument

/**
 * Stagehand_Class_Method_Argument.
 *
 * @package    sh-class
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */

class Stagehand_Class_Method_Argument
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
    private $_required;

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ __construct()

    /**
     * Sets this argument name and default value if argument is not required.
     *
     * @param string  $name      argument name.
     */
    public function __construct($name)
    {
        $this->setName($name);
        $this->setRequirement(true);
    }

    // }}}
    // {{{ setName()

    /**
     * Sets an argument name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    // }}}
    // {{{ getName()

    /**
     * Gets an argument name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    // }}}
    // {{{ setRequirement()

    /**
     * Sets an argument requirement status.
     *
     * @param boolean $isRequired
     */
    public function setRequirement($required = true)
    {
        $this->_required = $required ? true : false;
    }

    // }}}
    // {{{ isRequired()

    /**
     * Returns whether the argument is required or not.
     *
     * @return boolean
     */
    public function isRequired()
    {
        return $this->_required;
    }

    // }}}
    // {{{ setValue()

    /**
     * Sets an argument default value.
     *
     * @param mixed $value
     * @throws Stagehand_Class_Exception
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
     * Gets an argument default value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
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
     * Returns whether the value is valid for method's default argument or not.
     *
     * @param  mixed  $value
     * @return boolean
     * @throws Stagehand_Class_Exception
     */
    private function _isValidValue($value)
    {
        if (is_array($value)) {
            foreach ($value as $v) {
                $this->_isValidValue($v);
            }
        } else {
            if (!is_null($value)
                && !is_string($value)
                && !is_numeric($value)
                ) {
                throw new Stagehand_Class_Exception("Invalid value type, should be integer, string, or array.");
            }
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
