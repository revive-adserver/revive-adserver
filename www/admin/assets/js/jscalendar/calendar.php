<?php

/**
 *  File: calendar.php | (c) dynarch.com 2004
 *  Distributed as part of "The Coolest DHTML Calendar"
 *  under the same terms.
 *  -----------------------------------------------------------------
 *  This file implements a simple PHP wrapper for the calendar.  It
 *  allows you to easily include all the calendar files and setup the
 *  calendar by instantiating and calling a PHP object.
 */

define('NEWLINE', "\n");

class DHTML_Calendar
{
    public $calendar_lib_path;

    public $calendar_file;
    public $calendar_lang_file;
    public $calendar_setup_file;
    public $calendar_theme_file;
    public $calendar_options;

    public function __construct(
        $calendar_lib_path = '/calendar/',
        $lang = 'en',
        $theme = 'calendar-win2k-1',
        $stripped = true
    ) {
        if ($stripped) {
            $this->calendar_file = 'calendar_stripped.js';
            $this->calendar_setup_file = 'calendar-setup_stripped.js';
        } else {
            $this->calendar_file = 'calendar.js';
            $this->calendar_setup_file = 'calendar-setup.js';
        }
        $this->calendar_lang_file = 'lang/calendar-' . $lang . '.js';
        $this->calendar_theme_file = $theme . '.css';
        $this->calendar_lib_path = preg_replace('/\/+$/', '/', $calendar_lib_path);
        $this->calendar_options = ['ifFormat' => '%Y/%m/%d',
                                        'daFormat' => '%Y/%m/%d'];
    }

    public function set_option($name, $value)
    {
        $this->calendar_options[$name] = $value;
    }

    public function load_files()
    {
        echo $this->get_load_files_code();
    }

    public function get_load_files_code()
    {
        $code = ('<link rel="stylesheet" type="text/css" media="all" href="' .
                   $this->calendar_lib_path . $this->calendar_theme_file .
                   '" />' . NEWLINE);
        $code .= ('<script type="text/javascript" src="' .
                   $this->calendar_lib_path . $this->calendar_file .
                   '"></script>' . NEWLINE);
        $code .= ('<script type="text/javascript" src="' .
                   $this->calendar_lib_path . $this->calendar_lang_file .
                   '"></script>' . NEWLINE);
        $code .= ('<script type="text/javascript" src="' .
                   $this->calendar_lib_path . $this->calendar_setup_file .
                   '"></script>');
        return $code;
    }

    public function _make_calendar($other_options = [])
    {
        $js_options = $this->_make_js_hash(array_merge($this->calendar_options, $other_options));
        $code = ('<script type="text/javascript">Calendar.setup({' .
                   $js_options .
                   '});</script>');
        return $code;
    }

    public function make_input_field($cal_options = [], $field_attributes = [])
    {
        $id = $this->_gen_id();
        $attrstr = $this->_make_html_attr(array_merge(
            $field_attributes,
            ['id' => $this->_field_id($id),
                                                            'type' => 'text']
        ));
        echo '<input ' . $attrstr . '/>';
        echo '<a href="#" id="' . $this->_trigger_id($id) . '">' .
            '<img align="middle" border="0" src="' . $this->calendar_lib_path . 'img.gif" alt="" /></a>';

        $options = array_merge(
            $cal_options,
            ['inputField' => $this->_field_id($id),
                                     'button' => $this->_trigger_id($id)]
        );
        echo $this->_make_calendar($options);
    }

    /// PRIVATE SECTION

    public function _field_id($id)
    {
        return 'f-calendar-field-' . $id;
    }
    public function _trigger_id($id)
    {
        return 'f-calendar-trigger-' . $id;
    }
    public function _gen_id()
    {
        static $id = 0;
        return ++$id;
    }

    public function _make_js_hash($array)
    {
        $jstr = '';
        reset($array);
        foreach ($array as $key => $val) {
            if (is_bool($val)) {
                $val = $val ? 'true' : 'false';
            } elseif (!is_numeric($val)) {
                $val = '"' . $val . '"';
            }
            if ($jstr) {
                $jstr .= ',';
            }
            $jstr .= '"' . $key . '":' . $val;
        }
        return $jstr;
    }

    public function _make_html_attr($array)
    {
        $attrstr = '';
        reset($array);
        foreach ($array as $key => $val) {
            $attrstr .= $key . '="' . $val . '" ';
        }
        return $attrstr;
    }
};
