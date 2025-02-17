<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressManager extends Component
{
    public $addresses;
    public $name, $street, $city, $postal_code, $country = "España", $is_default = false;
    public $showForm = false;

    public function mount()
    {
        $this->refreshAddresses();
    }

    public function refreshAddresses()
    {
        $this->addresses = Auth::user()->addresses;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        if ($this->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Address::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'is_default' => $this->is_default,
        ]);

        $this->reset(['name', 'street', 'city', 'postal_code', 'is_default']);
        $this->refreshAddresses();
        $this->showForm = false; // Ocultar el formulario después de guardar
    }

    public function setDefaultAddress($addressId)
    {
        $user = Auth::user();

        // Desmarcar todas las direcciones actuales
        $user->addresses()->update(['is_default' => false]);

        // Marcar la dirección seleccionada como predeterminada
        Address::where('id', $addressId)->where('user_id', $user->id)->update(['is_default' => true]);

        // Actualizar la lista en tiempo real
        $this->refreshAddresses();
    }


    public function render()
    {
        return view('livewire.address-manager');
    }
}
