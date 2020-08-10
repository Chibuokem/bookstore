<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;

class RaveWebHookController extends Controller
{
    //
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface, UserRepositoryInterface $userRepositoryInterface, BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->bookRepositoryInterface = $bookRepositoryInterface;
    }

    public function index(){
        $body = @file_get_contents("php://input");
        $response = json_decode($body);
        //log this into the database

        $reference = $response->txRef;
        $transaction_id = $response->id;
        $transaction_status = $response->status;
        //verify again before giving value
        if ($response->status == 'successful') {
            //verify transaction 
            
            if ($verify === true) {
                //update transaction parameters
                $updateGatewayParams = $this->orderRepositoryInterface->updateGatewayParams($reference, $transaction_id, $transaction_status);
                $verify = $this->orderRepositoryInterface->verifyTransaction($reference);
                if ($verify === true) {
                    //transaction was successsfull
                    //check if value had been given already 
                    if ($updateGatewayParams->status == 1) {
                        //no need to continue, return a successful response 
                       exit(200);
                    }
                    //update status to 1 
                    $status = 1;
                    $confirmOrder = $this->orderRepositoryInterface->updateStatus($updateGatewayParams->id, $status);
                    $data['order'] = $confirmOrder;
                    $data['book'] = $confirmOrder->book;
                   //send an email with
                }
            }  
        }
    }
}