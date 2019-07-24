<?php
// module/Tax/src/Model/Tax.php:
namespace Tax\Model;

// Add the following import statements:
use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Payment implements InputFilterAwareInterface
{
    public $id;
    public $amount;
    public $tax;
    public $county_id;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->amount = !empty($data['amount']) ? $data['amount'] : null;
        $this->tax = !empty($data['tax']) ? $data['tax'] : null;
        $this->tax_rate = !empty($data['tax_rate']) ? $data['tax_rate'] : null;
        $this->county_id  = !empty($data['county_id']) ? $data['county_id'] : null;
        $this->county_name  = !empty($data['county_name']) ? $data['county_name'] : null;
        $this->state_id  = !empty($data['state_id']) ? $data['state_id'] : null;
        $this->state_name  = !empty($data['state_name']) ? $data['state_name'] : null;
        $this->country_id  = !empty($data['country_id']) ? $data['country_id'] : null;
        $this->country_name  = !empty($data['country_name']) ? $data['country_name'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'amount' => $this->amount,
            'tax' => $this->tax,
            'tax_rate' => $this->tax_rate,
            'county_id' => $this->county_id,
            'county_name' => $this->county_name,
            'state_id' => $this->state_id,
            'state_name' => $this->state_name,
            'country_id' => $this->country_id,
            'country_name' => $this->country_name,
        ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'amount',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[0-9]*([.]{1}[0-9]{1,2})?$/',                        
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'county_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}