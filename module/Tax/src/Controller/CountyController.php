<?php
namespace Tax\Controller;

use Tax\Model\CountyTable;
use Tax\Model\StateTable;
use Tax\Model\CountryTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Form\CountyForm;
use Tax\Model\County;

class CountyController extends AbstractActionController
{
    private $countyTable;
    private $stateTable;
    private $countryTable;    

    public function __construct(CountyTable $countyTable, StateTable $stateTable)
    {
        $this->countyTable = $countyTable;
        $this->stateTable = $stateTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'counties' => $this->countyTable->fetchAll(),
        ]);        
    }

    public function addAction()
    {
        $states = $this->stateTable->getStates();

        $form = new CountyForm($states);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        

        if (! $request->isPost()) {
            return ['form' => $form];
        }


        $county = new County();
        $form->setInputFilter($county->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $county->exchangeArray($form->getData());
        $this->countyTable->saveCounty($county);
        return $this->redirect()->toRoute('county');
    }

    public function editAction()
    {
        $states = $this->stateTable->getStates();

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('county', ['action' => 'add']);
        }

        // Retrieve the county with the specified id. Doing so raises
        // an exception if the county is not found, which should result
        // in redirecting to the landing page.
        try {
            $county = $this->countyTable->getCounty($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('county', ['action' => 'index']);
        }

        $form = new CountyForm($states);
        $form->bind($county);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($county->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->countyTable->saveCounty($county);

        // Redirect to county list
        return $this->redirect()->toRoute('county', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('county');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->countyTable->deleteCounty($id);
            }

            // Redirect to county list
            return $this->redirect()->toRoute('county');
        }

        return [
            'id'    => $id,
            'county' => $this->countyTable->getCounty($id),
        ];
    }

}