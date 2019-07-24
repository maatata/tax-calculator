<?php
namespace Tax\Controller;

use Tax\Model\StateTable;
use Tax\Model\CountryTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Form\StateForm;
use Tax\Model\State;
use Tax\Model\Country;

class StateController extends AbstractActionController
{
    private $stateTable;
    private $countryTable;

    public function __construct(StateTable $stateTable, CountryTable $countryTable)
    {
        $this->stateTable = $stateTable;
        $this->countryTable = $countryTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'states' => $this->stateTable->fetchAll(),
        ]);        
    }

    public function addAction()
    {
        $countries = $this->countryTable->getCountries();
        $form = new StateForm($countries);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        

        if (! $request->isPost()) {
            return ['form' => $form];
        }


        $state = new State();
        $form->setInputFilter($state->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $state->exchangeArray($form->getData());
        $this->stateTable->saveState($state);
        return $this->redirect()->toRoute('state');
    }

    public function editAction()
    {
        $countries = $this->countryTable->getCountries();
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('state', ['action' => 'add']);
        }

        // Retrieve the state with the specified id. Doing so raises
        // an exception if the state is not found, which should result
        // in redirecting to the landing page.
        try {
            $state = $this->stateTable->getState($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('state', ['action' => 'index']);
        }

        $form = new StateForm($countries);
        $form->bind($state);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($state->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->stateTable->saveState($state);

        // Redirect to state list
        return $this->redirect()->toRoute('state', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('state');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->stateTable->deleteState($id);
            }

            // Redirect to state list
            return $this->redirect()->toRoute('state');
        }

        return [
            'id'    => $id,
            'state' => $this->stateTable->getState($id),
        ];
    }

}