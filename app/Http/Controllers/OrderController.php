<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Book;
use App\Models\Order;

class OrderController extends Controller
{
    //
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface, UserRepositoryInterface $userRepositoryInterface, BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->bookRepositoryInterface = $bookRepositoryInterface;
    }

    /**
     * Function to store order 
     *
     * @param Request $request
     * @return void
     */
    public function storeOrder(Request $request)
    {
        $params = array();
        $params['name'] = $request->name;
        $params['email'] = $request->email;
        $params['phone'] = $request->phone;
        $params['book_id'] = $request->book_id;
        $params['amount'] = $request->amount;
        $params['quantity'] = $request->quantity;
        $params['reference'] = $request->reference;
        //confirm that an order doesnt already exist for this reference, if it exists return the order data
        $check = $this->orderRepositoryInterface->checkRef($params['reference']);
        if ($check) {
            $order =  $this->orderRepositoryInterface->getOrderByRef($params['reference']);
            return response()->json(['data' => $order]);
        } else {
            $store = $this->orderRepositoryInterface->storeOrder($params);
            return response()->json(['data' => $store]);
        }
    }

    /**
     * Function to get order summary
     *
     * @param Request $request
     * @return void
     */
    public function orderSummary(Request $request)
    {
        //validate order
        $this->validateOrder($request);
        $book_id = $request->book_id;
        $customer_name = $request->customer_name;
        $customer_email = $request->customer_email;
        $customer_phone = $request->customer_phone;
        $quantity = $request->quantity;
        $book = $this->bookRepositoryInterface->find($book_id);
        $reference = $this->orderRepositoryInterface->createRef();
        $data['name'] = $customer_name;
        $data['email'] = $customer_email;
        $data['phone'] = $customer_phone;
        $data['book'] = $book;
        $data['reference'] = $reference;
        $data['quantity'] = $quantity;
        $data['rave_public_key'] = $this->ravePublicKey();
        return view('pages.order_summary', $data);
    }

    /**
     * Function to verify transaction
     *
     * @param Request $request
     * @return void
     */
    public function verifyTransaction(Request $request)
    {
        $amount = $request->amount;
        $reference = $request->reference;
        $status = $request->status;
        $transaction_id = $request->transaction_id;
        $gatewayParams = $this->orderRepositoryInterface->updateGatewayParams($reference, $transaction_id, $status);
        //check if webhook has given a value already
        if($gatewayParams->status == 1){
            //no need to continue, return a successful response 
            $data['order'] = $gatewayParams;
            $data['book'] = $gatewayParams->book;
            return response()->json(['data' => $data, 'status' => 1]);
        }
        $verify = $this->orderRepositoryInterface->verifyTransaction($reference);
        if ($verify === true) {
            //transaction was successsfull
            //update status to 1 
            $status = 1;
            $confirmOrder = $this->orderRepositoryInterface->updateStatus($gatewayParams->id, $status);
            $data['order'] = $confirmOrder;
            $data['book'] = $confirmOrder->book;
            return response()->json(['data' => $data, 'status' => 1]);
        }
        else{
            return response()-json(['data'=> $verify, 'status' => 0]);
        }
    }
    /**
     * function to return paystack secret key
     */
    public function raveSecretKey()
    {
        return config('values.rave_secret_key');
    }

    /**
     * function to return paystack public key
     */
    public function ravePublicKey()
    {
        return config('values.rave_public_key');
    }

    /**
     * Validate book upload
     *
     * @param Request $request
     * @return array
     */
    private function validateOrder(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|string',
            'quantity' => 'required|integer'
        ]);

        return $validatedData;
    }
}