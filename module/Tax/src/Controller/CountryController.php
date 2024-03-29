<?php
namespace Tax\Controller;

use Tax\Model\CountryTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Form\CountryForm;
use Tax\Model\Country;

class CountryController extends AbstractActionController
{
    private $table;

    public function __construct(CountryTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'countries' => $this->table->fetchAll(),
        ]);        
    }

    public function addAction()
    {
        $form = new CountryForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $country = new Country();
        $form->setInputFilter($country->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $country->exchangeArray($form->getData());
        $this->table->saveCountry($country);
        return $this->redirect()->toRoute('country');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('country', ['action' => 'add']);
        }

        // Retrieve the country with the specified id. Doing so raises
        // an exception if the country is not found, which should result
        // in redirecting to the landing page.
        try {
            $country = $this->table->getCountry($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('country', ['action' => 'index']);
        }

        $form = new CountryForm();
        $form->bind($country);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($country->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveCountry($country);

        // Redirect to country list
        return $this->redirect()->toRoute('country', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('country');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteCountry($id);
            }

            // Redirect to country list
            return $this->redirect()->toRoute('country');
        }

        return [
            'id'    => $id,
            'country' => $this->table->getCountry($id),
        ];
    }
}