<?php

namespace MakvilleRegistry\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Input helper
 */
class FilterHelper extends Helper {

    public $helpers = ['Form', 'MakvilleRegistry.Input', 'Registry.Output'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function operators ($registryField) {
        $id = $registryField->id;
        $options = [];
        switch ($registryField->data_type) {
            case 'short':
            case 'long':
                $options = ['equals' => 'Equals', 'not_equal' => 'Not Equal', 'contains' => 'Contains' , 'does_not_contain' => 'Does not Contain'];
                break;
            case 'single':
            case 'multiple':
                $options = ['equals' => 'Equals', 'not_equal' => 'Not Equal', 'among' => 'Among' , 'not_among' => 'Not Among'];
                break;
            case 'number':
            case 'linear':
                $options = ['equals' => 'Equals', 'not_equal' => 'Not Equal', 'greater_than' => 'Greater than', 'greater_than_or_equal_to' => 'Greater than or equal to', 'less_than' => 'Less than', 'less_than_or_equal_to' => 'Less than or equal to', 'between' => 'Between', 'not_between' => 'Not between'];
                break;
            case 'date':
            case 'time':
                $options = ['equals' => 'On/At', 'not_equal' => 'Not on/at', 'greater_than' => 'Later than', 'greater_than_or_equal_to' => 'Later than or on/at', 'less_than' => 'Earlier than', 'less_than_or_equal_to' => 'Earlier than or on/at', 'between' => 'Between', 'not_between' => 'Not between'];
                break;
        }
        return $this->Form->control("Parameters.$id.operator", ['label' => false, 'options' => $options, 'empty' => 'Select an operator', 'class' => 'form-control']);
    }
    
    public function operands ($registryField, $lists) {
        $id = $registryField->id;
        $choices = [];
        switch ($registryField->data_type) {
            case 'short':
            case 'long':
                
                break;
            case 'number':
            case 'linear':
                
                break;
            case 'date':
            case 'time':
                
                break;
            case 'single':
            case 'multiple':
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
                break;
        }
        if (is_array($choices) && count($choices) > 0 ) {
            return $this->Form->control("Parameters.$id.operand", ['label' => false, 'options' =>  $choices, 'empty' => 'Select Operand', 'class' => 'form-control']);
        } else {
            return $this->Form->control("Parameters.$id.operand", ['label' => false, 'placeholder' => 'Enter operand', 'class' => 'form-control']);
        }
    }
}
