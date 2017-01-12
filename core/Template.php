<?php

class Template
{
    var $objects = array();
    var $assignedValues = array();
    var $partialBuffer;
    var $tpl;

    function __construct($_path = '')
    {
        if (!empty($_path)) {
            if (file_exists($_path)) {
                $this->tpl = file_get_contents($_path);
            } else {
                echo '<b>Template Error</b>: File Inclusion Error.';
            }
        }
    }

    function assign($_searchString, $_replaceString)
    {
        if (!empty($_searchString)) {
            $this->assignedValues[strtoupper($_searchString)] = $_replaceString;
        }
    }

    function renderMultiPartials($_searchString, $_path, $_dataList = array(), $_assignedValues = array())
    {
        $multiPartialBuilder = '';
        $content = '';
        if (!empty($_searchString)) {
            if (file_exists($_path)) {
                if (count($_dataList) > 0) {
                    foreach ($_dataList as $data) {
                        if (count($_assignedValues) > 0) {
                            $this->partialBuffer = file_get_contents($_path);
                            foreach ($_assignedValues as $key) {
                                $this->partialBuffer = str_replace(strtoupper('{' . $key . '}'), $data[$key], $this->partialBuffer);
                            }
                            $content = $this->partialBuffer;
                        }
                        $multiPartialBuilder .= $content;
                    }
                }
                $this->tpl = str_replace('[' . strtoupper($_searchString) . ']', $multiPartialBuilder, $this->tpl);
            } else {
                echo '<b>Template Error:</b> Partial Inclusion Error';
            }
        }
    }

    function renderBody($_searchString, $_path = '')
    {
        if (empty($_path)) {
            $path = '../public/templates/' . $_searchString . '.php';
        } else {
            $path = '../public/templates/' . $_path . '.php';
        }
        if (!empty($_searchString)) {
            if (file_exists($path)) {
                $this->partialBuffer = file_get_contents($path);

                $this->tpl = str_replace('{[' . strtoupper($_searchString) . ']}', $this->partialBuffer, $this->tpl);
                $this->partialBuffer = '';
            } else {
                echo '<b>Template Error:</b> Body Inclusion Error';
            }
        }
    }

    function renderTitle($titleValue = [])
    {
        $path = '../public/templates/title.php';

        if (file_exists($path)) {
            $this->partialBuffer = file_get_contents($path);

            foreach ($titleValue as $key => $value) {
                echo $value;
                $this->partialBuffer = str_replace(strtoupper('{' . $key . '}'), $value, $this->partialBuffer);
            }

            $this->tpl = str_replace('{[' . strtoupper('title') . ']}', $this->partialBuffer, $this->tpl);
            $this->partialBuffer = '';
        } else {
            echo '<b>Template Error:</b> Title Inclusion Error';
        }

    }

    function renderPartials($_searchString, $_path, $_assignedValues = array())
    {
        if (!empty($_searchString)) {
            if (file_exists($_path)) {
                $this->partialBuffer = file_get_contents($_path);

                if (count($_assignedValues) > 0) {
                    foreach ($_assignedValues as $key => $value) {
                        $this->partialBuffer = str_replace(strtoupper('{' . $key . '}'), $value, $this->partialBuffer);
                    }
                }
                $this->tpl = str_replace('[' . strtoupper($_searchString) . ']', $this->partialBuffer, $this->tpl);
                $this->partialBuffer = '';
            } else {
                echo '<b>Template Error:</b> Partial Inclusion Error';
            }
        }
    }

    function assignObjects($key, $value)
    {
        if (!empty($key)) {
            $this->objects[strtoupper($key)] = $value;
        }
    }

    function getObjects($key)
    {
        $this->objects[strtoupper($key)];
    }

    function show()
    {
        if (count($this->assignedValues) > 0) {
            foreach ($this->assignedValues as $key => $value) {
                $this->tpl = str_replace('{' . $key . '}', $value, $this->tpl);
            }
        }
        echo $this->tpl;
    }
}