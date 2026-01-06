<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyList extends Component
{
    public $properties;

    protected $listeners = ['propertyUpdated' => 'loadProperties'];

    public function mount()
    {
        $this->loadProperties();
    }

    public function loadProperties()
    {
        $this->properties = Property::where('user_id', Auth::id())
            ->with('report')
            ->get();
    }

    public function deleteProperty($id)
    {
        $property = Property::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$property) {
            $this->dispatch('error', 'Property not found or unauthorized.');
            return;
        }

        $property->delete();
        $this->dispatch('success', 'Property deleted successfully.');
        $this->loadProperties();
    }

    public function render()
    {
        return view('livewire.user.property-list');
    }
}
