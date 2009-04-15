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

    private $_class;

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
        $format = "class %s
{
%s
}
";

        return sprintf($format,
                       $this->_class->getName(),
                       $this->_getAllPropertiesCode()
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
    // {{{ _getAllPropertiesCode()

    /**
     * Gets all propertie's code.
     *
     * @return string
     */
    private function _getAllPropertiesCode()
    {
        $allPropertiesCode = null;
        foreach ($this->_class->getProperties() as $property) {
            $allPropertiesCode .= "    " . $this->_createPropertyCode($property) . "\n";
        }

        return $allPropertiesCode;
    }

    // }}}
    // {{{ _createPropertyCode()

    /**
     * Creates a partial code for class property.
     *
     * @return string
     */
    private function _createPropertyCode($property)
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
