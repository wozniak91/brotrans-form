<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class OrdersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'delivery_fullname' => 'required|string',
            'email' => 'required|email',
            'delivery_company' => 'string|nullable',
            'delivery_address' => 'required|string',
            'delivery_city' => 'required|string',
            'delivery_postcode' => 'required|string',
            'phone' => 'required|string',
            'paid' => 'required|boolean',
            'delivery_price' => 'required|numeric',
            'products' => 'required|array',
            // 'products.*.name' => 'required|string',
            // 'products.*.price_brutton' => 'required|numeric',
            // 'products.*.quantity' => 'required|quantity',
            // 'products.*.weight' => 'required|quantity'
        ]);
        $this->client = new Client();

        $parameters = collect($request);

        $parameters['order_status_id'] = 76198;
        $parameters['date_add'] = time();
        $parameters['delivery_method'] = "Transport własny (Bromarkt)";
        $parameters['currency'] = 'PLN';
        $parameters['user_login'] = $request->user()->email;
        $parameters['delivery_country_code'] = "PL";
        
        $response = $this->client->request('POST', 'https://api.baselinker.com/connector.php', [
            'form_params' => [
                'token' => '1001051-1003443-02JAUKZRRE92WM7BXH7X56ZQEN1UY0OWIQEUE5XKKWNTMOA3T1BFAJZPLDIP1M18',
                'method' => 'addOrder',
                'parameters' => $parameters->toJson()
            ]
        ]);

        $result = json_decode($response->getBody(), true);
        
        if($result['status'] == "SUCCESS") {
            $request->user()->sendOrderConfirmationNotification($result['order_id']);
        }

        return [
            'result' => $result,
            'params' => $parameters
        ];
    }
}
