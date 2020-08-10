<?php

namespace App\Repositories;

use App\User;
use App\Interfaces\VirtualCardRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\VirtualCard;
use Illuminate\Support\Facades\Crypt;

class VirtualCardRepository implements VirtualCardRepositoryInterface
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
    public function __construct(VirtualCard $model)
    {
        $this->model = $model;
        $this->secKey = config('values.rave_secret_key');
        $this->baseUrl = 'https://ravesandboxapi.flutterwave.com/v3';
    }

    /**
     * Function to get Model instance
     *
     * @return void
     */
    public function getModelInstance()
    {
        return $this->model;
    }
    /**
     * Function to find a card by id
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Funtion to return all virtual cards
     *
     * @return void
     */
    public function all()
    {
        return $this->model->all();
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

    /**
     *Function to create card 
     *
     * @param array $params
     * @return void
     */
    public function createCard(array $params)
    {
        $cardModel = $this->model;
        $cardModel->currency = $params['currency'];
        $cardModel->amount = $params['amount'];
        $cardModel->billing_name = $params['billing_name'];
        $cardModel->billing_address = $params['billing_address'];
        $cardModel->billing_city = $params['billing_city'];
        $cardModel->billing_state = $params['billing_state'];
        $cardModel->billing_postal_code = $params['billing_postal_code'];
        $cardModel->billing_country = $params['billing_country'];
        $cardModel->reference = $this->createRef();
        $cardModel->callback_url = $params['callback_url'];
        $cardModel->save();

        return $cardModel;
    }

    /**
     * add card from gateway response
     *
     * @param array $params
     * @return void
     */
    public function addCard(array $params)
    {
        $cardModel = $this->model;
        $cardModel->currency = $params['currency'];
        $cardModel->amount = $params['amount'];
        $cardModel->billing_name = $params['name_on_card'];
        $cardModel->name_on_card = $params['name_on_card'];
        $cardModel->address_1 = $params['address_1'];
        $cardModel->billing_address = $params['address_1'];
        $cardModel->billing_postal_code = $params['zip_code'];
        $cardModel->billing_city = $params['city'];
        $cardModel->billing_state = $params['state'];
        $cardModel->billing_country = 'Nigeria';
        $cardModel->reference = $this->createRef();
        $cardModel->callback_url = $params['callback_url'];
        $cardModel->card_id = $params['id'];
        $cardModel->cvv = $params['cvv'];
        $cardModel->card_pan = $params['card_pan'];
        $cardModel->masked_pan = $params['masked_pan'];
        $cardModel->is_active = $params['is_active'];

        $cardModel->save();

        return $cardModel;
    }

    /**
     * function to send card creation request
     *
     * @param array $params
     * @return void
     */
    public function sendCardCreationRequest(array $params)
    {
        $requestUrl = '/virtual-cards';
        $sendRequest = $this->sendRequest($params, $requestUrl);
        return $sendRequest;
    }

    /**
     * function to send card creation request
     *
     * @param array $params
     * @return void
     */
    public function sendCardGetRequest(string $id)
    {
        $requestUrl = '/virtual-cards/' . $id;
        $sendRequest = $this->getRequest($requestUrl);
        return $sendRequest;
    }

    /**
     * function to get and sync all cards
     *
     * @return void
     */
    public function getAllCards()
    {
        $requestUrl = '/virtual-cards';
        $sendRequest = $this->getRequest($requestUrl);
        if ($sendRequest['status'] == 'success') {
            //set active to false
            $cards = $sendRequest['data'];
            foreach ($cards as $c) {
                
                    $cardCheck = $this->model::where('card_id', $c['id'])->count();
                    if ($cardCheck == 0) {
                        //insert card 
                        $add_card = $this->addCard($c);
                    }else{
                        $card = $this->model::where('card_id', $c['id'])->first();
                        $card->amount = $c['amount'];
                        $card->save();
                    }
            
            }
        }
        return $sendRequest;
    }

    /**
     * Function to send cad funding request
     *
     * @param array $params
     * @return void
     */
    public function fundCardRequest(array $params)
    {
        $requestUrl = '/virtual-cards/' . $params['id'] . '/fund';
        $sendRequest = $this->sendRequest($params, $requestUrl);
        return $sendRequest;
    }

    /**
     * Function to send cad funding request
     *
     * @param array $params
     * @return void
     */
    public function withdrawFromCardRequest(array $params)
    {
        $requestUrl = '/virtual-cards/' . $params['id'] . '/withdraw';
        $sendRequest = $this->sendRequest($params, $requestUrl);
        return $sendRequest;
    }

    /**
     *Function to send card termination reques
     *
     * @param string $card_id
     * @return void
     */
    public function sendCardTerminationRequest(string $card_id)
    {
        $requestUrl = '/virtual-cards/' . $card_id . '/terminate';
        $sendRequest = $this->getRequest($requestUrl, "PUT");
        if ($sendRequest['status'] == 'success') {
            //set active to false
            $card = $this->model::where('card_id', $card_id)->first();
            if ($card) {
                $card->delete();
            }
        }
        return $sendRequest;
    }

    /**
     * Function to delete card
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id){
        $card = $this->find($id);
        $card->delete();
        return $card;
    }

    /**
     *Function to send card termination reques
     *
     * @param string $card_id
     * @return void
     */
    public function sendGetCardTransactionsRequest(string $card_id, $from, $to)
    {
        $data['from'] = $from;
        $data['to'] = $to;
        $data['index'] = 0;
        $data['size'] = 10;
        $query = http_build_query($data);
        $requestUrl = '/virtual-cards/' . $card_id . '/transactions?' . $query;
        $sendRequest = $this->getRequest($requestUrl);
        return $sendRequest;
    }

    /**
     *Function to send card termination reques
     *
     * @param string $card_id
     * @return void
     */
    public function sendCardBlockRequest(string $card_id)
    {
        // echo $card_id;
        // exit();
        $requestUrl = '/virtual-cards/' . $card_id . '/status/block';
        $sendRequest = $this->getRequest($requestUrl, "PUT");

        if ($sendRequest['status'] == 'success') {
            //set active to false
            $card = $this->model::where('card_id', $card_id)->first();
            if ($card) {
                $card->is_active = false;
                $card->save();
            }
        }
        return $sendRequest;
    }

    /**
     *Function to send card termination reques
     *
     * @param string $card_id
     * @return void
     */
    public function sendCardUnblockRequest(string $card_id)
    {

        $requestUrl = '/virtual-cards/' . $card_id . '/status/unblock';
        $sendRequest = $this->getRequest($requestUrl, "PUT");
        //set active to false
        $card = $this->model::where('card_id', $card_id)->first();
        if ($card) {
            $card->is_active = true;
            $card->save();
        }
        return $sendRequest;
    }
    /**
     *Send post requests to flutterwave endpoints
     *
     * @param [type] $post
     * @param [type] $endpoint
     * @return void
     */
    private function sendRequest($post, $endpoint)
    {

        header('Content-Type: application/json'); // Specify the type of data
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url); // Initialise cURL
        $post = json_encode($post); // Encode the data array into a JSON string
        $authorization = "Authorization: Bearer " . $this->secKey; // Prepare the authorisation token
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization)); // Inject the token into the header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects for
        //disable ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close the cURL connection
        return json_decode($result, true); // Return the received data

    }

    /**
     * Function to send get/put requests to flutterwave end points
     *
     * @param [type] $endpoint
     * @return void
     */
    public function getRequest($endpoint, $method = "GET")
    {
        $curl = curl_init();
        $url = $this->baseUrl . $endpoint;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->secKey
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
    /**
     * Function to update gateway response 
     *
     * @param array $params
     * @param integer $id
     * @return void
     */
    public function updateCardGatewayResponse(array $params, int $id)
    {
        $card = $this->find($id);
        $card->status = $params['status'];
        $card->message = $params['message'];
        if ($params['data'] != null) {
            $data = $params['data'];
            $card->card_pan = $data['card_pan'];
            $card->card_id = $data['id'];
            $card->masked_pan = $data['masked_pan'];
            $card->city = $data['city'];
            $card->state = $data['state'];
            $card->address_1 = $data['address_1'];
            $card->zip_code = $data['zip_code'];
            $card->cvv = $data['cvv'];
            $card->expiration = $data['expiration'];
            $card->card_type = $data['card_type'];
            $card->name_on_card = $data['name_on_card'];
            $card->is_active = $data['is_active'];
        }
        $card->save();
        return $card;
    }
}