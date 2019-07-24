<?php
namespace Tax\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class DashboardTable
{
    private $countryTableGateway;
    private $stateTableGateway;
    private $countyTableGateway;

    public function __construct(TableGatewayInterface $countryTableGateway, TableGatewayInterface $stateTableGateway, TableGatewayInterface $countyTableGateway)
    {
        $this->countryTableGateway = $countryTableGateway;
        $this->stateTableGateway = $stateTableGateway;
        $this->countyTableGateway = $countyTableGateway;
    }

    public function getCountriesAverageTaxRates()
    {
        $sqlSelect = $this->countryTableGateway->getSql()->select();
        $sqlSelect->columns(array('name' => 'name'));
        $sqlSelect->join('states', 'states.country_id = countries.id', array('state_name' => 'name'), 'left');
        $sqlSelect->join('counties', 'counties.state_id = states.id', array('average_tax_rate' => new \Zend\Db\Sql\Expression('SUM(counties.tax_rate)/COUNT(DISTINCT counties.id)')), 'left');
        $sqlSelect->order('countries.name ASC');
        $sqlSelect->group('countries.id');
        $resultSet = $this->countryTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    public function getCountriesCollectedTaxes()
    {
        $sqlSelect = $this->countryTableGateway->getSql()->select();
        $sqlSelect->columns(array('name' => 'name'));
        $sqlSelect->join('states', 'states.country_id = countries.id', array('state_name' => 'name'), 'left');
        $sqlSelect->join('counties', 'counties.state_id = states.id', array(), 'left');
        $sqlSelect->join('payments', 'payments.county_id = counties.id', array('overall_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)'), 'average_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)/COUNT(DISTINCT payments.id)')), 'left');
        $sqlSelect->order('countries.name ASC');
        $sqlSelect->group('countries.id');
        $resultSet = $this->countryTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    public function getStatesCollectedTaxes()
    {
        $sqlSelect = $this->stateTableGateway->getSql()->select();
        $sqlSelect->columns(array('name' => 'name'));
        $sqlSelect->join('countries', 'states.country_id = countries.id', array('country_name' => 'name'), 'left');
        $sqlSelect->join('counties', 'counties.state_id = states.id', array(), 'left');
        $sqlSelect->join('payments', 'payments.county_id = counties.id', array('overall_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)'), 'average_collected_tax' => new \Zend\Db\Sql\Expression('SUM(payments.tax)/COUNT(DISTINCT payments.id)')), 'left');
        $sqlSelect->order('states.name ASC, countries.name ASC');
        $sqlSelect->group('states.id');
        $resultSet = $this->stateTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    public function getStatesAverageTaxRates()
    {
        $sqlSelect = $this->stateTableGateway->getSql()->select();
        $sqlSelect->columns(array('name' => 'name'));
        $sqlSelect->join('countries', 'states.country_id = countries.id', array('country_name' => 'name'), 'left');
        $sqlSelect->join('counties', 'counties.state_id = states.id', array('average_tax_rate' => new \Zend\Db\Sql\Expression('SUM(counties.tax_rate)/COUNT(DISTINCT counties.id)')), 'left');
        $sqlSelect->order('states.name ASC, countries.name ASC');
        $sqlSelect->group('states.id');
        $resultSet = $this->stateTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    
}