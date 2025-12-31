<?php 


namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::latest()->get();
        return view('admin.addresses', compact('addresses'));
    }
    public function state_view()
    {
        $addresses = Address::latest()->get();
        return view('admin.addresses', compact('addresses'));
    }
    public function user_location()
    {
        $addresses = Address::latest()->get();
        return view('user_new.location', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_address' => 'required|string|max:255',
        ]);

        Address::create([
            'full_address' => $request->full_address,
        ]);
        return GeneralController::sendNotification('', 'success', '', 'Address added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_address' => 'required|string|max:255',
        ]);

        Address::where('id', $id)->update([
            'full_address' => $request->full_address,
        ]);
        return GeneralController::sendNotification('', 'success', '', 'Address updated successfully.');
    }

    public function destroy($id)
    {
        Address::destroy($id);
        return GeneralController::sendNotification('', 'success', '', 'Address deleted successfully.');
    }
}

?>