<?php

namespace MakvilleRegistry\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Input helper
 */
class OutputHelper extends Helper {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function interfaceTime($string) {
        if (is_null($string) || $string == '') {
            return false;
        }
        $parts = explode(':', $string);
        if ($parts[0] > 12) {
            return ($parts[0] - 12) . ':' . $parts[1] . ' PM';
        } elseif ($parts[0] == 12) {
            return $parts[0] . ':' . $parts[1] . ' PM';
        } else {
            return $parts[0] . ':' . $parts[1] . ' AM';
        }
    }

    public function interfaceDate($string) {
        $parts = explode('-', $string);
        $reParts = array_reverse($parts);
        return implode('/', $reParts);
    }

    public function output($registryField, $lists, $entryValue) {
        switch ($registryField->data_type) {
            case 'number':
            case 'short':
            case 'long':
            case 'linear':
                return $entryValue;
                break;
            case 'single':
            case 'multiple':
                $choices = [];
                //where are we going to get the choices?
                if (strlen(trim($registryField->options)) > 0) {
                    $parts = explode("\n", $registryField->options);
                    foreach ($parts as $part) {
                        $value = trim($part);
                        $choices[$value] = $value;
                    }
                } else {
                    //its coming from a list.
                    $choices = $lists[$registryField->registry_field_extra->registry_list_id];
                }
                if ($registryField->data_type == 'multiple') {
                    $return = [];
                    $parts = explode('|', $entryValue);
                    foreach ($parts as $part) {
                        $return[] = isset($choices[$part]) ? $choices[$part] : null;
                    }
                    return implode('|', $return);
                } else {
                    return isset($choices[$entryValue]) ? $choices[$entryValue] : null;
                }
                break;
            case 'grid':

                break;
            case 'date':
                return $this->interfaceDate($entryValue);
                break;
            case 'time':
                return $this->interfaceTime($entryValue);
                break;
            default :
                return $entryValue;
                break;
        }
    }

}
