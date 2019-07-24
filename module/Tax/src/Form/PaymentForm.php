<?php
namespace Tax\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class PaymentForm extends Form
{   
    private $counties;

    public function __construct($counties = array())
    {
        $this->counties = $counties;

        // We will ignore the name provided to the constructor
        parent::__construct('payment');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'amount',
            'type' => 'number',
            'options' => [
                'label' => 'Amount',
            ],
            'attributes' => [
                'min' => '0',
                'step' => '0.1', // default step interval is 1
            ]
        ]);
        $this->add([
            'name' => 'county_id',
            'type' => 'select',
            'options' => [
                'label' => 'County',
                'empty_option' => 'Please select a County',
                'value_options' => $this->counties,
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