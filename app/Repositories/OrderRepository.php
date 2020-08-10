<?php

namespace App\Repositories;

use App\User;
use App\Models\Book;
use App\Models\Order;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseInvoiceInformation;


class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Order $model, Book $bookModel)
    {
        $this->model = $model;
        $this->bookModel = $bookModel;
        $this->secKey = config('values.rave_secret_key');
    }

    /* Function to find a  model by id
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Funtion to return all orders
     *
     * @return void
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Function to get a  Model instance
     *
     * @return void
     */
    public function getModelInstance()
    {
        return $this->model;
    }

    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function storeOrder(array $params)
    {
        $orderModel = $this->model;
        $orderModel->name = $params['name'];
        $orderModel->email = $params['email'];
        $orderModel->phone = $params['phone'];
        $orderModel->book_id = $params['book_id'];
        $orderModel->amount = $params['amount'];
        $orderModel->quantity = $params['quantity'];
        $orderModel->reference = $params['reference'];
        $orderModel->save();
        return $orderModel;
    }

    /**
     * Function to store book
     *
     * @param array $params
     * @return void
     */
    public function updateStatus(int $id, $status)
    {
        $book = $this->find($id);
        $book->status = $status;
        $book->save();
        return $book;
    }

    /**
     * Function to delete book
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $book = $this->find($id);
        $book->delete();
        return $book;
    }

    /**
     * Function to create reference
     *
     * @return void
     */
    public function createRef()
    {
        return $this->model->create_id();
    }

    public function checkRef($reference)
    {
        $orderCheck = $this->model::where('reference', $reference)->count();
        if ($orderCheck > 0) {
            return true;
        }
        return false;
    }

    public function getOrderByRef($reference)
    {
        $order = $this->model::where('reference', $reference)->first();
        return $order;
    }

    /**
     * Verify transaction
     *
     * @param [type] $reference
     * @return void
     */
    public function verifyTransaction($reference){

        $order = $this->getOrderByRef($reference);
        $transaction_id = $order->transaction_flutterwave_id;
        $amount = $order->amount;
        $currency = $order->currency;
        $curl = curl_init();
        $secKey = config('values.rave_secret_key');
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ravesandboxapi.flutterwave.com/v3/transactions/". $transaction_id."/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
         CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
                "Authorization: Bearer ".$secKey
        ),
        ));

        $response = curl_exec($curl);
       
        curl_close($curl);
       // echo $response;
        $resp = json_decode($response, true);
       // print_r($resp);
        $paymentStatus = $resp['data']['status'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        if (($paymentStatus == "successful") && ($chargeAmount == $amount)) {
            //transaction was successful
            return true;
        }
        else{
            return false;
        }
    }
    
    /**
     * Function to update gateway param
     *
     * @param [type] $reference
     * @param [type] $transaction_id
     * @param [type] $status
     * @return void
     */
   public function updateGatewayParams($reference, $transaction_id, $status)
   {
        $order = $this->getOrderByRef($reference);
        $order->transaction_flutterwave_id = $transaction_id;
        $order->rave_status = $status;
        $order->save();
        return $order;
   }

    public function sendEmail($data)
    {
        return Mail::to($data->email)->send(new PurchaseInvoiceInformation($data));
    }

    
}