<?php
namespace Tax\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class PaymentTable
{
    private $paymentTableGateway;
    private $countyTableGateway;

    public function __construct(TableGatewayInterface $paymentTableGateway, TableGatewayInterface $countyTableGateway)
    {
        $this->paymentTableGateway = $paymentTableGateway;
        $this->countyTableGateway = $countyTableGateway;
    }

    public function fetchAll()
    {
        $sqlSelect = $this->paymentTableGateway->getSql()->select();
        $sqlSelect->columns(array('id' => 'id', 'amount' => 'amount', 'county_id' => 'county_id', 'tax' => 'tax'));
        $sqlSelect->join('counties', 'payments.county_id = counties.id', array('state_id' => 'state_id', 'county_name' => 'name', 'tax_rate' => 'tax_rate'), 'left');
        $sqlSelect->join('states', 'counties.state_id = states.id', array('country_id' => 'country_id', 'state_name' => 'name'), 'left');
        $sqlSelect->join('countries', 'states.country_id = countries.id', array('country_name' => 'name'), 'left');
        $resultSet = $this->paymentTableGateway->selectWith($sqlSelect);

        return $resultSet;
    }

    public function getPayment($id)
    {
        $id = (int) $id;
        $rowset = $this->paymentTableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function savePayment(Payment $payment)
    {

        $rowset = $this->countyTableGateway->select(['id' => (int) $payment->county_id]);
        $county = $rowset->current();
        if (! $county) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $payment->county_id
            ));
        }

        $data = [
            'amount' => $payment->amount,
            'tax'  => ($payment->amount * $county->tax_rate) / 100,
            'county_id' => $payment->county_id,
        ];

        $id = (int) $payment->id;

        if ($id === 0) {
            $this->paymentTableGateway->insert($data);
            return;
        }

        if (! $this->getPayment($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update payment with identifier %d; does not exist',
                $id
            ));
        }

        $this->paymentTableGateway->update($data, ['id' => $id]);
    }

    public function deletePayment($id)
    {
        $this->paymentTableGateway->delete(['id' => (int) $id]);
    }
}