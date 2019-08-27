<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;


class ConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Load all the conversions in the DB
        $conversions = \App\Conversion::all();
        //return view('index', ['message' => 'This is the index', 'list' => $conversions]);
        return view("index", ['list'=>$conversions]);
    }

    /**
     * Show one resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Go to the Form. Load the Redis.
        if (!Cache::has('symbols')) { 
            $client = new Client();
    	    $response = $client->request('GET', 'https://api.exchangeratesapi.io/latest');
    	    $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);
            $symbols=array_keys($body['rates']);
            $symbols[]=$body['base'];
            Cache::put('symbols', sort($symbols));
        } else {
            $symbols=Cache::get('symbols');
        }
        return view('create', ['symbols' => $symbols]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client();
        $base = $request->get('currency1');
        $symbol = $request->get('currency2');
    	$response = $client->request('GET', 'https://api.exchangeratesapi.io/latest', ['query' => "symbols=$symbol&base=$base"]);
    	$statusCode = $response->getStatusCode();
        $body = json_decode($response->getBody()->getContents(), true);
        $currency1=$body['base'];
        $currency2=array_key_first($body['rates']);
        $rate=$body['rates'][$currency2];

        // Store new conversion.
        $conversion = new \App\Conversion;

        $conversion->currency1 = $currency1;
        $conversion->currency2 = $currency2;
        $conversion->rate = $rate;

        $conversion->save();

        flash('New conversion saved.');
        
        return redirect('/conversion');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Remove individual conversions, then return to list.
        $conversion = \App\Conversion::findOrFail($id);
        $conversion->delete();
      
        
        flash('Record deleted.');
        
        return redirect('/conversion');
    }
}
