<?php

namespace App\Http\Livewire\User;

use App\Models\Activity;
use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyModal extends Component
{
    public $property_id;
    public $property_owner;
    public $ownership_type = 'owned';
    public $address;
    public $latitude;
    public $longitude;
    public $floors_count;
    public $residents_count = 1;
    public $documents;


    protected $listeners = ['openPropertyModal' => 'loadProperty' , 'setCoordinates'];

    protected $rules = [
        'property_owner' => 'required|string|max:100',
        'ownership_type' => 'required|in:owned,rented',
        'address' => 'required|string|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'floors_count' => 'nullable|integer|min:0',
        'residents_count' => 'nullable|integer|min:1',
        'documents' => 'nullable|string',
    ];

    public function loadProperty($id = null)
    {
        if ($id) {
            $property = Property::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $this->property_id = $property->id;
            $this->property_owner = $property->property_owner;
            $this->ownership_type = $property->ownership_type;
            $this->address = $property->address;
            $this->latitude = $property->latitude;
            $this->longitude = $property->longitude;
            $this->floors_count = $property->floors_count;
            $this->residents_count = $property->residents_count;
            $this->documents = $property->documents;
        } else {
            $this->reset(['property_id', 'property_owner', 'ownership_type', 'address', 'latitude', 'longitude', 'floors_count', 'residents_count', 'documents']);
            $this->ownership_type = 'owned';
            $this->residents_count = 1;
        }
    }

    public function save()
    {
        $this->validate();

        Property::updateOrCreate(
            ['id' => $this->property_id],
            [
                'user_id' => Auth::id(),
                'property_owner' => $this->property_owner,
                'ownership_type' => $this->ownership_type,
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'floors_count' => $this->floors_count,
                'residents_count' => $this->residents_count,
                'documents' => $this->documents,
            ]
        );

        Activity::create([
            'user_id' => auth()->id(), // صاحب الطلب
            'title' => __('menu.added_property', ['user' => auth()->user()->name]),
            'type' => 'info',          // اللون (success, danger, warning, info)
            'icon' => 'bi-clipboard-check', // أيقونة مناسبة من Bootstrap Icons
        ]);

        $this->dispatch('propertyUpdated');
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('swal:success', [
            'title' => __('menu.success_title'), // 'نجاح' أو 'Success'
            'text'  => __('menu.property_saved_success'), // 'تم حفظ العقار بنجاح 🎉'
        ]);
    }

    public function setCoordinates($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }




    public function render()
    {
        return view('livewire.user.property-modal');
    }
}
