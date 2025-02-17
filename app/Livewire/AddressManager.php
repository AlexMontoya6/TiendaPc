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

        // Buscar la dirección seleccionada
        $address = Address::where('id', $addressId)->where('user_id', $user->id)->first();

        if (!$address) {
            session()->flash('error', 'La dirección seleccionada no existe.');
            return;
        }

        // Marcar la dirección seleccionada como predeterminada
        $address->update(['is_default' => true]);

        // Emitir evento para actualizar la interfaz en tiempo real
        $this->dispatch('addressUpdated');

        // Actualizar la lista de direcciones en tiempo real
        $this->refreshAddresses();
    }


    public function continueToDelivery()
    {
        $user = Auth::user();
        $defaultAddress = $user->addresses()->where('is_default', true)->first();

        if (!$defaultAddress) {
            session()->flash('error', 'Por favor, selecciona una dirección de envío antes de continuar.');
            return;
        }

        // Guardar la dirección en sesión
        session()->put('shipping_name', $defaultAddress->name);
        session()->put('shipping_street', $defaultAddress->street);
        session()->put('shipping_city', $defaultAddress->city);
        session()->put('shipping_postal_code', $defaultAddress->postal_code);
        session()->put('shipping_country', $defaultAddress->country);

        // Redireccionar a opciones de entrega
        return redirect()->route('cart.checkout.entrega');
    }


    public function render()
    {
        return view('livewire.address-manager');
    }
}
