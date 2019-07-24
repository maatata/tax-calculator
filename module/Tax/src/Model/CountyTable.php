<?php
namespace Tax\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CountyTable
{
    private $countyTableGateway;

    public function __construct(TableGatewayInterface $countyTableGateway)
    {
        $this->countyTableGateway = $countyTableGateway;
    }

    public function fetchAll()
    {
        $sqlSelect = $this->countyTableGateway->getSql()->select();
        $sqlSelect->columns(array('id' => 'id', 'initial' => 'initial', 'name' => 'name', 'state_id' => 'state_id', 'tax_rate' => 'tax_rate'));
        $sqlSelect->join('states', 'counties.state_id = states.id', array('country_id' => 'country_id', 'state_name' => 'name'), 'left');
        $sqlSelect->join('countries', 'states.country_id = countries.id', array('country_name' => 'name'), 'left');
        $sqlSelect->join('payments', 'payments.county_id = counties.id', array('overall_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)'), 'average_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)/COUNT(DISTINCT payments.id)')), 'left');
        $sqlSelect->order('counties.name ASC, states.name ASC, countries.name ASC');
        $sqlSelect->group('counties.id');
        $resultSet = $this->countyTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    public function getCounty($id)
    {
        $id = (int) $id;
        $rowset = $this->countyTableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function getCounties() {
        $result = $this->fetchAll();
        $counties = array();
        foreach($result AS $county) {
            if(!isset($counties[$county->country_name.' - '.$county->state_name]['label']))
                $counties[$county->country_name.' - '.$county->state_name]['label'] = $county->country_name.' - '.$county->state_name;

            $counties[$county->country_name.' - '.$county->state_name]['options'][$county->id] = $county->name;
        }

        return $counties;
    }

    public function saveCounty(County $county)
    {
        $data = [
            'name' => $county->name,
            'initial'  => $county->initial,
            'state_id' => $county->state_id,
            'tax_rate' => $county->tax_rate,
        ];

        $id = (int) $county->id;

        if ($id === 0) {
            $this->countyTableGateway->insert($data);
            return;
        }

        if (! $this->getCounty($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update county with identifier %d; does not exist',
                $id
            ));
        }

        $this->countyTableGateway->update($data, ['id' => $id]);
    }

    public function deleteCounty($id)
    {
        $this->countyTableGateway->delete(['id' => (int) $id]);
    }
}