<?php

namespace App\Http\Livewire;

use App\Models\Language;
use App\Models\Tour;
use Livewire\Component;

class SearchTour extends Component
{
    public $tours=[];
    public $buscarTour='';

    public function render()
    {
        return view('livewire.search-tour');
    }

    public function updatedbuscarTour($value)
    {
        $lang=Language::where('abreviatura',session('lang'))->first();
        if($value!=''){
            $this->tours=Tour::where('nombre','LIKE','%'.$value.'%')->where('language_id',$lang->id)->where('web',1)->take(3)->get();
        }else{
            $this->tours=[];
        }
        
    }
}
