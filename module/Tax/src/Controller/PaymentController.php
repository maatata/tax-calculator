<?php
namespace Tax\Controller;

use Tax\Model\PaymentTable;
use Tax\Model\CountyTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tax\Form\PaymentForm;
use Tax\Model\Payment;

class PaymentController extends AbstractActionController
{
    private $paymentTable;
    private $countyTable;

    public function __construct(PaymentTable $paymentTable, CountyTable $countyTable)
    {
        $this->paymentTable = $paymentTable;
        $this->countyTable = $countyTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'payments' => $this->paymentTable->fetchAll(),
        ]);        
    }

    public function addAction()
    {
        $counties = $this->countyTable->getCounties();

        $form = new PaymentForm($counties);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        

        if (! $request->isPost()) {
            return ['form' => $form];
        }


        $payment = new Payment();
        $form->setInputFilter($payment->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $payment->exchangeArray($form->getData());
        $this->paymentTable->savePayment($payment);
        return $this->redirect()->toRoute('payment');
    }

    public function editAction()
    {
        $counties = $this->countyTable->getCounties();

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('payment', ['action' => 'add']);
        }

        // Retrieve the payment with the specified id. Doing so raises
        // an exception if the payment is not found, which should result
        // in redirecting to the landing page.
        try {
            $payment = $this->paymentTable->getPayment($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('payment', ['action' => 'index']);
        }

        $form = new PaymentForm($counties);
        $form->bind($payment);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($payment->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->paymentTable->savePayment($payment);

        // Redirect to payment list
        return $this->redirect()->toRoute('payment', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('payment');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->paymentTable->deletePayment($id);
            }

            // Redirect to payment list
            return $this->redirect()->toRoute('payment');
        }

        return [
            'id'    => $id,
            'payment' => $this->paymentTable->getPayment($id),
        ];
    }

}