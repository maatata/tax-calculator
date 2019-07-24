<?php
namespace Tax\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class CountyForm extends Form
{   
    private $states;

    public function __construct($states = array())
    {
        $this->states = $states;

        // We will ignore the name provided to the constructor
        parent::__construct('county');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'initial',
            'type' => 'text',
            'options' => [
                'label' => 'Initial',
            ],
        ]);
        $this->add([
            'name' => 'state_id',
            'type' => 'select',
            'options' => [
                'label' => 'State',
                'empty_option' => 'Please select a State',
                'value_options' => $this->states,
            ],
        ]);
        $this->add([
            'name' => 'tax_rate',
            'type' => 'number',
            'options' => [
                'label' => 'Tax Rate (%)',
            ],
            'attributes' => [
                'min' => '0',
                'max' => '100',
                'step' => '0.01', // default step interval is 1
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}