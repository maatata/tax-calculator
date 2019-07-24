<?php
namespace Tax\Controller;

use Tax\Model\DashboardTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Model\Country;

class DashboardController extends AbstractActionController
{
    private $table;

    public function __construct(DashboardTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'countries_average_tax_rates' => $this->table->getCountriesAverageTaxRates(),
            'countries_collected_taxes' => $this->table->getCountriesCollectedTaxes(),
            'states_collected_taxes' => $this->table->getStatesCollectedTaxes(),
            'states_average_tax_rates' => $this->table->getStatesAverageTaxRates(),
        ]);        
    }
}