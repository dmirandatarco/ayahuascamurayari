<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Tripadvisor;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reservasPorUsuario = Reserva::groupBy('user_id')
        ->selectRaw('user_id, count(*) as total_reservas')
        ->get();
        return view('dashboard',compact('reservasPorUsuario'));
    }

    public function webscraping()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.tripadvisor.com.pe/Attraction_Review-g294314-d11543752-Reviews-Day_Expeditions_Travel-Cusco_Cusco_Region.html');
        $crawler2= $crawler->filter("[class='LbPSX']")->first();
        $crawler2->filter("[data-automation='tab']")->each(function ($node){
            $node->filter("[ data-automation='reviewCard']")->each(function ($node2){
                $tripadvisor = new Tripadvisor();
                $node2->filter("[ class='mwPje f M k']")->each(function ($node3) use ($tripadvisor){
                    $tripadvisor->name= $node3->filter("[class='biGQs _P fiohW fOtGX']")->first()->text();
                    $tripadvisor->url  = $node3->filter('img')->attr('src');
                });
                $divs = $node2->children()->filter('div');
                $divsWithSVG= $divs->eq(15);
                $valorAtributoD = 'M 12 0C5.388 0 0 5.388 0 12s5.388 12 12 12 12-5.38 12-12c0-6.612-5.38-12-12-12z';
                $conteoPaths = $divsWithSVG->filterXPath('//path[@d="' . $valorAtributoD . '"]')->count();
                $node2->filter("[ class='biGQs _P fiohW qWPrE ncFvv fOtGX']")->each(function ($node4) use ($tripadvisor){
                    $tripadvisor->title  = $node4->filter("[class='yCeTE']")->first()->text();
                });
                $node2->filter("[ class='biGQs _P pZUbB KxBGd']")->each(function ($node5)  use ($tripadvisor){
                    $tripadvisor->description  = $node5->filter("[class='yCeTE']")->first()->text();
                });

                $node2->filter("[ class='TreSq']")->each(function ($node6)  use ($tripadvisor){
                    $fecha  = $node6->filter("[class='biGQs _P pZUbB ncFvv osNWb']")->first();
                    $tripadvisor->fecha = str_replace("Escrita el ", "", $fecha->text());
                });
                $tripadvisor->rating = $conteoPaths;
                $tripadvisor->save();

            });
        });
        
    }

}
