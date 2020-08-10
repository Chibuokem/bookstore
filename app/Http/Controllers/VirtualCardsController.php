<?php

namespace App\Http\Controllers;

use App\Interfaces\VirtualCardRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\VirtualCard;
use Illuminate\Support\Facades\Auth;

class VirtualCardsController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(VirtualCardRepositoryInterface $virtualCardRepositoryInterface)
    {
        $this->middleware('auth');
        $this->virtualCardRepositoryInterface = $virtualCardRepositoryInterface;
    }

    /**
     * Function to view cards
     *
     * @return void
     */
    public function createNewCard()
    {
        $user = Auth::user();
        $data['user'] = $user;
        return view('admin.create-virtual-card', $data);
    }
    /**
     * Function to view cards
     *
     * @return void
     */
    public function viewCards()
    {
        $cards = $this->virtualCardRepositoryInterface->all();
        $data['cards'] = $cards;
        return view('admin.virtualcards', $data);
    }
    /**
     * Function to create card
     *
     * @param Request $request
     * @return void
     */
    public function createCard(Request $request)
    {
        $this->validateCard($request);
        $params = array();
        $params['currency'] = $request->currency;
        $params['amount'] = $request->amount;
        $params['billing_name'] = $request->billing_name;
        $params['billing_address'] = $request->billing_address;
        $params['billing_city'] = $request->billing_city;
        $params['billing_state'] = $request->billing_state;
        $params['billing_postal_code'] = $request->billing_postal_code;
        $params['billing_country'] = $request->billing_country;
        $params['callback_url'] = 'https://your-callback-url.com/';
        $store = $this->virtualCardRepositoryInterface->createCard($params);
        if ($store) {
            //send request to flutterwave 
            $card_params = array();
            $card_params["currency"] = $store->currency;
            $card_params["amount"] = $store->amount;
            $card_params["billing_name"] = $store->billing_name;
            $card_params["billing_address"] = $store->billing_address;
            $card_params["billing_city"] = $store->billing_city;
            $card_params["billing_state"] = $store->billing_state;
            $card_params["billing_postal_code"] = $store->billing_postal_code;
            $card_params["billing_country"] = $store->billing_country;
            $card_params["callback_url"] = $store->callback_url;
            $send_request = $this->virtualCardRepositoryInterface->sendCardCreationRequest($card_params);
            $update_card = $this->virtualCardRepositoryInterface->updateCardGatewayResponse($send_request, $store->id);
            if($send_request['status'] != 'success'){
                //delete the created card
                $deleteCard = $this->virtualCardRepositoryInterface->delete($store->id);
            }

            return response()->json(['data' => $store, 'request'=> $send_request]);
        }
    }

    /**
     * Function to fund virtual card
     *
     * @param Request $request
     * @return void
     */
    public function fundVirtualCard(Request $request)
    {
        $this->validateCardFunding($request);
        $id = $request->id;
        $amount = $request->amount;
        $debit_currency = $request->debit_currency;
        $params['id'] = $id;
        $params['amount'] = $amount;
        $params['debit_currency'] = $debit_currency;
        //send request to rave
        $send_request = $this->virtualCardRepositoryInterface->fundCardRequest($params);
        return response()->json(['data' => $send_request]);
    }

    /**
     * Get virtual card
     *
     * @param Request $request
     * @return void
     */
    public function getVirtualCard($id)
    {
        $send_request = $this->virtualCardRepositoryInterface->sendCardGetRequest($id);
        return response()->json(['data' => $send_request]);
    }

    /**
     * Validate card
     *
     * @param Request $request
     * @return array
     */
    private function validateCard(Request $request)
    {
        $validatedData = $request->validate([
            'currency' => 'required|string',
            'amount' => 'required|int',
            'billing_name' => 'required|string',
            'billing_address' => 'required|string',
            'billing_city'  => 'required|string',
            'billing_state' => 'required|string',
            'billing_postal_code' => 'required|int',
            'billing_country' => 'required|string'

        ]);

        return $validatedData;
    }


    /**
     * Function to terminate card
     *
     * @param VirtualCard $card
     * @return void
     */
    public function terminateCard(VirtualCard $card)
    {
        $card_id = $card->card_id;
        $send_request = $this->virtualCardRepositoryInterface->sendCardTerminationRequest($card_id);
        return response()->json(['data' => $send_request]);
    }

    /**
     * Function to block card
     *
     * @param VirtualCard $card
     * @return void
     */
    public function blockCard(VirtualCard $card)
    {
        $card_id = $card->card_id;
        $send_request = $this->virtualCardRepositoryInterface->sendCardBlockRequest($card_id);
        return response()->json(['data' => $send_request]);
    }

    /**
     * Function to unblock card
     *
     * @param VirtualCard $card
     * @return void
     */
    public function unblockCard(VirtualCard $card)
    {
        $card_id = $card->card_id;
        $send_request = $this->virtualCardRepositoryInterface->sendCardUnblockRequest($card_id);
        return response()->json(['data' => $send_request]);
    }

    /**
     *Function to get card transaction records
     *
     * @param VirtualCard $card
     * @return void
     */
    public function getCardTransactions(Request $request)
    {
        $card_id = $request->id;
        $daterange = $request->daterange;
        //split daterange
        $dates = explode(" - ", $daterange);
        $from = $dates[0];
        $to = $dates[1];
        $send_request = $this->virtualCardRepositoryInterface->sendGetCardTransactionsRequest($card_id, $from, $to);
        $data['from'] = $from;
        $data['to'] = $to;
        $data['transactions'] = $send_request;
        return view('admin.card-transactions', $data);
    }

    /**
     * Function to withdraw funds from card
     *
     * @param Request $request
     * @return void
     */
    public function withdrawFromCard(Request $request)
    {
        $this->validateCardWithdrawal($request);
        $id = $request->id;
        $amount = $request->amount;
        $params = array();
        $params['id'] = $id;
        $params['amount'] = $amount;
        $send_request = $this->virtualCardRepositoryInterface->withdrawFromCardRequest($params);
        return response()->json(['data' => $send_request]);
    }

    
    /**
     * Validate card
     *
     * @param Request $request
     * @return array
     */
    private function validateCardFunding(Request $request)
    {
        $validatedData = $request->validate([
            'debit_currency' => 'required|string',
            'amount' => 'required|int',
            'id' => 'required|string'
        ]);

        return $validatedData;
    }

    /**
     * Validate card
     *
     * @param Request $request
     * @return array
     */
    private function validateCardWithdrawal(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|int',
            'id' => 'required|string'
        ]);

        return $validatedData;
    }

    /**
     * Function to sync cards
     *
     * @return void
     */
    public function syncCards()
    {
        $sync = $this->virtualCardRepositoryInterface->getAllCards();
        $cards = $this->virtualCardRepositoryInterface->all();
        $data['cards'] = $cards;
        $data['other_data'] = array();
        $cards = $sync['data'];
        foreach ($cards as $c) {
            $id = $c['id'];
            $data['other_data'][$id] = $c;
        }
        return view('admin.virtualcards-sync', $data);
    }
}