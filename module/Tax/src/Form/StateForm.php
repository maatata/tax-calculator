<?php
namespace Tax\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class StateForm extends Form
{   
    private $countries;
    public function __construct($countries = array())
    {
        $this->countries = $countries;
        // We will ignore the name provided to the constructor
        parent::__construct('state');

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
            'name' => 'country_id',
            'type' => 'select',
            'options' => [
                'label' => 'Country',
                'empty_option' => 'Please select a Country',
                'value_options' => $this->countries,
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