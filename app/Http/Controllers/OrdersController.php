<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

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

        $parameters['order_status_id'] = 75068;
        $parameters['date_add'] = time();
        $parameters['delivery_method'] = "Transport własny (Bromarkt)";
        $parameters['currency'] = 'PLN';
        $parameters['user_login'] = $request->user()->email;
        $parameters['delivery_country_code'] = "PL";
        
        $response = $this->client->request('POST', 'https://api.baselinker.com/connector.php', [
            'form_params' => [
                'token' => '1002410-1010612-6DY8GPOAOWU9SFYR2WTZ18VAZWBN4Y3UVPT1CD3MSE1X6YET9K5ZPZA0CT6VYH3A',
                'method' => 'addOrder',
                'parameters' => $parameters->toJson()
            ]
        ]);

        $result = json_decode($response->getBody(), true);
        
        return [
            'result' => $result,
            'params' => $parameters
        ];
    }
}
