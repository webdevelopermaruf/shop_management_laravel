<?php

namespace App\Http\Livewire;

use App\Models\SiteSettings;
use Livewire\Component;

class Appsettings extends Component
{
    public $app_name, $app_location, $app_mobile;
    protected $rules = [
        'app_name' => 'required',
        'app_location' => 'required',
        'app_mobile' => 'required',
    ];

    public function mount(){
        $data = SiteSettings::where('site_no',1)->first();
        $this->app_name = $data->site_name;
        $this->app_location = $data->site_location;
        $this->app_mobile = $data->site_phone;
    }
    public function render()
    {
        return view('livewire.appsettings');
    }
    public function updateSettings()
    {
        $validated = $this->validate();
        $updated = SiteSettings::where('site_no',1)->update([
            'site_name' => $this->app_name,
            'site_location' => $this->app_location,
            'site_phone'=> $this->app_mobile,
        ]);

        $this->app_name = '';
        $this->app_location = '';
        $this->app_mobile = '';
        $this->mount();
        $this->dispatchBrowserEvent('updateSettings',[]);
        return;
    
    }
}
