<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Axios\Axios;


class ShowController extends Controller
{
        // public function index()
        // {
        //         // $response = Http::timeout(10)->get('http://127.0.0.1:8000/api/users');
        //         // $data = $response->json();
        // //     try {
        // //         $response = Http::timeout(3)->get('http://127.0.0.1:8000/api/users');
        // //         dd($response);
        // //         return $response;
        // //         // if ($response->successful()) {
        // //         //     $users = $response->json();
        // //         //     return view('welcome', ['users' => $users]);
        // //         // } else {
        // //         //     return response()->json(['error' => 'Failed to retrieve data from API'], $response->status());
        // //         // }
        // //     } catch (\Exception $e) {
        // //        // return response()->json(['error' => $e->getMessage()], 500);
        // //     }
        // $client = new Client();

        // try {
        //     $response = $client->get('http://127.0.0.1:8000/api/users');
        //     $data = json_decode($response->getBody(), true);
        //     // Manipuler les données reçues
        //     return response()->json($data);
        // } catch (RequestException $e) {
        //     // Gérer les erreurs
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
    
        // }
        // public function index()
        // {
        //     $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
        //     $response = $client->request('GET', 'posts');
        //     $posts = json_decode($response->getBody(), true);
    
        //     return view('posts.index', compact('posts'));
        // }
        // public function index()
        // {
        //     $response = Axios::get('http://localhost:8000/api/users');
        //     $posts = $response->data;
    
        //     return view('welcome', compact('users'));
        // }

}
