<?php
namespace Tax\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CountryTable
{
    private $countryTableGateway;

    public function __construct(TableGatewayInterface $countryTableGateway)
    {
        $this->countryTableGateway = $countryTableGateway;
    }

    public function fetchAll()
    {
        $sqlSelect = $this->countryTableGateway->getSql()->select();
        $sqlSelect->columns(array('id' => 'id', 'name' => 'name', 'initial' => 'initial'));
        $sqlSelect->join('states', 'states.country_id = countries.id', array('state_name' => 'name'), 'left');
        $sqlSelect->join('counties', 'counties.state_id = states.id', array(), 'left');
        $sqlSelect->join('payments', 'payments.county_id = counties.id', array('overall_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)'), 'average_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)/COUNT(DISTINCT payments.id)')), 'left');
        $sqlSelect->group('countries.id');
        $resultSet = $this->countryTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    public function getCountry($id)
    {
        $id = (int) $id;
        $rowset = $this->countryTableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function getCountries() {
        $result = $this->fetchAll();
        $countries = array();
        foreach($result AS $country)
            $countries[$country->id] = $country->name;

        return $countries;
    }

    public function saveCountry(Country $country)
    {
        $data = [
            'name' => $country->name,
            'initial'  => $country->initial,
        ];

        $id = (int) $country->id;

        if ($id === 0) {
            $this->countryTableGateway->insert($data);
            return;
        }

        if (! $this->getCountry($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update country with identifier %d; does not exist',
                $id
            ));
        }

        $this->countryTableGateway->update($data, ['id' => $id]);
    }

    public function deleteCountry($id)
    {
        $this->countryTableGateway->delete(['id' => (int) $id]);
    }
}