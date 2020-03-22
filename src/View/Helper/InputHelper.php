<?php

namespace MakvilleRegistry\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Input helper
 */
class InputHelper extends Helper {

    public $helpers = ['Form', 'MakvilleRegistry.Output'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function input($registryField, $lists, $entryValue = null) {
        $options = ['label' => $registryField->label, 'class' => 'form-control'];
        switch ($registryField->data_type) {
            case 'number':
                $options['value'] = $entryValue;
                break;
            case 'short':
                $options['type'] = 'text';
                $options['value'] = $entryValue;
                break;
            case 'long':
                $options['type'] = 'textarea';
                $options['value'] = $entryValue;
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
                $options['options'] = $choices;
                if ($registryField->data_type == 'multiple') {
                    $options['multiple'] = 'multiple';
                    $options['class'] .= ' multiselect';
                    $options['default'] = explode('|', $entryValue);
                } else {
                    $options['empty'] = true;
                    $options['value'] = $entryValue;
                }
                break;
            case 'linear':
                $options['class'] .= ' linear-control';
                $ticks = [];
                for ($i = $registryField->registry_field_extra->linear_start; $i <= $registryField->registry_field_extra->linear_stop; $i++) {
                    $ticks[] = $i;
                }
                $options['data-slider-ticks'] = "[" . implode(',', $ticks) . "]";
                $options['data-slider-ticks-labels'] = "[" . implode(',', $ticks) . "]";
                $options['data-slider-ticks-snap-bounds'] = "30";
                $options['data-slider-value'] = (is_numeric($entryValue) && !($entryValue < $registryField->registry_field_extra->linear_start)) ? $entryValue : $registryField->registry_field_extra->linear_start;
                break;
            case 'grid':

                break;
            case 'date':
                $options['class'] .= ' datepickers';
                $options['value'] = $this->Output->interfaceDate($entryValue);
                break;
            case 'time':
                $options['class'] .= ' timepickers';
                $options['value'] = $this->Output->interfaceTime($entryValue);
                break;
            default :

                break;
        }
        return $this->Form->control($registryField->name, $options);
    }

}
