<?php
/*
 * $Id: b7c5db9cbcc359f590ad089abe2192e6bdbfb9d3 $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

/** Class to hold a property value
 *  Class only required to make it possible to add a property as reference
 * @package phing.types
 */
class PropertyValue {

    /**
     * @var string
     */
    protected $value;

    /**
     * Constructor optionaly sets a the value of property component.
     * @param    mixed      Value of name, all scalars allowed
     */
    function __construct($value = null) {
        if ($value !== null) {
            $this->setValue($value);
        }
    }

    /**
     * Sets a the value of property component.
     * @param    mixed      Value of name, all scalars allowed
     */
    function setValue($value) {
        $this->value = (string) $value;
    }

    /** Get the value of property component. */
    function getValue() {
        return $this->value;
    }

    function toString() {
        return $this->getValue();
    }
}

