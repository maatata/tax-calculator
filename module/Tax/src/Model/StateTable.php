<?php
namespace Tax\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class StateTable
{
    private $stateTableGateway;

    public function __construct(TableGatewayInterface $stateTableGateway)
    {
        $this->stateTableGateway = $stateTableGateway;
    }

    public function fetchAll()
    {
        $sqlSelect = $this->stateTableGateway->getSql()->select();
        $sqlSelect->columns(array('id' => 'id', 'initial' => 'initial', 'name' => 'name', 'country_id' => 'country_id'));
        $sqlSelect->join('countries', 'states.country_id = countries.id', array('country_name' => 'name'), 'left');
        $sqlSelect->join('counties', 'counties.state_id = states.id', array(), 'left');
        $sqlSelect->join('payments', 'payments.county_id = counties.id', array('overall_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)'), 'average_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)/COUNT(DISTINCT payments.id)')), 'left');
        $sqlSelect->order('states.name ASC, countries.name ASC');
        $sqlSelect->group('states.id');        
        $resultSet = $this->stateTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    public function getState($id)
    {
        $id = (int) $id;
        $rowset = $this->stateTableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function getStates() {
        $result = $this->fetchAll();
        $states = array();
        foreach($result AS $state) {
            if(!isset($states[$state->country_name]['label']))
                $states[$state->country_name]['label'] = $state->country_name;

            $states[$state->country_name]['options'][$state->id] = $state->name;
        }

        return $states;
    }

    public function saveState(State $state)
    {
        $data = [
            'name' => $state->name,
            'initial'  => $state->initial,
            'country_id' => $state->country_id,
        ];

        $id = (int) $state->id;

        if ($id === 0) {
            $this->stateTableGateway->insert($data);
            return;
        }

        if (! $this->getState($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update state with identifier %d; does not exist',
                $id
            ));
        }

        $this->stateTableGateway->update($data, ['id' => $id]);
    }

    public function deleteState($id)
    {
        $this->stateTableGateway->delete(['id' => (int) $id]);
    }
}