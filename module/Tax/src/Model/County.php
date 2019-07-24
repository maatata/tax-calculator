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

class County implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $initial;
    public $country_id;
    public $state_id;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->initial  = !empty($data['initial']) ? $data['initial'] : null;
        $this->country_id  = !empty($data['country_id']) ? $data['country_id'] : null;
        $this->country_name  = !empty($data['country_name']) ? $data['country_name'] : null;
        $this->state_id  = !empty($data['state_id']) ? $data['state_id'] : null;
        $this->state_name  = !empty($data['state_name']) ? $data['state_name'] : null;
        $this->tax_rate  = !empty($data['tax_rate']) ? $data['tax_rate'] : 0;
        $this->overall_collected_tax  = !empty($data['overall_collected_tax']) ? number_format($data['overall_collected_tax'], 2) : 0;
        $this->average_collected_tax  = !empty($data['average_collected_tax']) ? number_format($data['average_collected_tax'], 2) : 0;
    }

    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'name' => $this->name,
            'initial'  => $this->initial,
            'country_id' => $this->country_id,
            'country_name' => $this->country_name,
            'state_id' => $this->state_id,
            'state_name' => $this->state_name,
            'tax_rate' => $this->tax_rate,
            'overall_collected_tax' => $this->overall_collected_tax,
            'average_collected_tax' => $this->average_collected_tax,
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
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'initial',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 3,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'state_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'tax_rate',
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

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}