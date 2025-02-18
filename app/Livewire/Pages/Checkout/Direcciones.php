<?php

namespace App\Livewire\Pages\Checkout;

use Livewire\Component;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class Direcciones extends Component
{
    public $addresses;
    public $name, $street, $city, $postal_code, $country = "España", $is_default = false;
    public $showForm = false;
    public $isResumenPago = false;

    public function mount($isResumenPago = false)
    {
        $this->isResumenPago = $isResumenPago;

        $user = auth()->user();
        $this->addresses = $user->addresses;

        if ($this->addresses->count() === 1) {
            $this->setDefaultAddress($this->addresses->first()->id);
        }
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

        $user = Auth::user();

        $user->addresses()->update(['is_default' => false]);

        $newAddress = Address::create([
            'user_id' => $user->id,
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'is_default' => true,
        ]);

        $this->refreshAddresses();

        $this->reset(['name', 'street', 'city', 'postal_code', 'is_default']);
        $this->showForm = false;
    }


    public function setDefaultAddress($addressId)
    {
        $user = Auth::user();

        $user->addresses()->update(['is_default' => false]);

        $address = Address::where('id', $addressId)->where('user_id', $user->id)->first();

        if (!$address) {
            session()->flash('error', 'La dirección seleccionada no existe.');
            return;
        }

        $address->update(['is_default' => true]);

        $this->dispatch('addressUpdated');

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

        session()->put('shipping_name', $defaultAddress->name);
        session()->put('shipping_street', $defaultAddress->street);
        session()->put('shipping_city', $defaultAddress->city);
        session()->put('shipping_postal_code', $defaultAddress->postal_code);
        session()->put('shipping_country', $defaultAddress->country);

        return redirect()->route('cart.checkout.entrega');
    }

    public function deleteAddress($addressId)
    {
        $user = auth()->user();

        $address = $user->addresses()->find($addressId);

        if ($address) {
            $address->delete();

            $this->addresses = $user->addresses;

            if ($this->addresses->count() === 1) {
                $this->setDefaultAddress($this->addresses->first()->id);
            }

            session()->flash('message', 'Dirección eliminada correctamente.');
        }
    }


    public function render()
    {
        $this->isResumenPago = request()->routeIs('cart.checkout.resumen_pago');
        return view('livewire.pages.Checkout.direcciones')
            ->layout('layouts.checkout');
    }
}
