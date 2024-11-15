<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Cabecera;
use App\Models\Blog;
use App\Models\Cabecera as ModelsCabecera;
use App\Models\Categoria;
use App\Models\Certificacio;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Nosotro;
use App\Models\Pais;
use App\Models\Tour;
use App\Models\Tripadvisor;
use App\Models\Ubicacion;
use App\Models\Whatsapp;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function alltours(Request $request)
    {
        $tours = Tour::with('categoria','itinerarios','images','ubicaciones')->where('language_id',$request->language_id)->get();
        return response()->json($tours);
    }

    public function allblog(Request $request)
    {
        $blogs = Blog::with('user','images')->where('language_id',$request->language_id);

        if($request->nosotros){
            $blogs = $blogs->where('nosotros',1);
        }
        $blogs = $blogs->get();
        return response()->json($blogs);
    }

    public function allcategorias(Request $request)
    {
        $categorias = Categoria::with('image','tours')->withCount('tours')->where('language_id',$request->language_id)->get();

        return response()->json($categorias);
    }

    public function categoriabyId(Request $request)
    {
        $categoria = Categoria::where('slug',$request->slug)->with('image','tours')->withCount('tours')->where('language_id',$request->language_id)->first();

        return response()->json($categoria);
    }

    public function allubicaciones(Request $request)
    {
        $ubicaciones = Ubicacion::with('image','tours')->withCount('tours')->where('language_id',$request->language_id)->get();

        return response()->json($ubicaciones);
    }

    public function ubicacionbyId(Request $request)
    {
        $ubicacion = Ubicacion::where('slug',$request->slug)->with('image','tours','tours.ubicaciones')->withCount('tours')->where('language_id',$request->language_id)->first();

        return response()->json($ubicacion);
    }

    public function blogbyId(Request $request)
    {
        $blog = Blog::where('slug',$request->slug)->with('image','user')->where('language_id',$request->language_id)->first();

        return response()->json($blog);
    }


    public function tourbyId(Request $request)
    {
        // $tour = Tour::where('slug',$request->slug)->with('categoria','itinerarios','images','ubicaciones')->first();
        // $traduccion = $tour->traduccion($request->language_id);
        // $tour = Tour::where('id',$traduccion->id)->with('categoria','itinerarios','images','ubicaciones')->first();
        // $tour->relacionados = Tour::where('categoria_id',$tour->categoria_id)->where('id','!=',$tour->id)->where('estado',1)
        // ->inRandomOrder()->take(3)->get();
        $tour = Tour::where('slug',$request->slug)->with('categoria','itinerarios','images','ubicaciones')->first();
        $tour->relacionados = Tour::where('categoria_id',$tour->categoria_id)->where('id','!=',$tour->id)->where('estado',1)
        ->inRandomOrder()->take(3)->get();
        return response()->json($tour);
    }

    public function general(Request $request)
    {
        $nosotros = Nosotro::with('images')->where('language_id',$request->language_id)->first();
        $cabecera = ModelsCabecera::with('images')->where('language_id',$request->language_id)->where('estado',1)->first();
        $certificados = Certificacio::with('detalles')->where('language_id',$request->language_id)->first();
        $whatsapp = Whatsapp::all();
        $tripadvisor = Tripadvisor::all();
        $idiomas = Language::all();
        $paises = Pais::all();
        $menu = Menu::with('detalles','detalles.categoria','detalles.categoria.tours')->where('language_id',$request->language_id)->get();
        $data = [
            "nosotros" => $nosotros,
            "cabecera" => $cabecera,
            "certificados" => $certificados,
            "whatsapp" => $whatsapp,
            "idiomas" => $idiomas,
            "menus" => $menu,
            "paises" => $paises,
            "tripadvisor" => $tripadvisor,
        ];

        return response()->json($data);
    }
}
