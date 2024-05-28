<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Services\UploadedService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;
use TaliumAttributes\Collection\Rutes\Put;
use TaliumAttributes\Collection\Rutes\Delete;

#[Controllers()]
#[Group(prefix: 'paymenttype', middleware: ['auth'])]
class PaymentTypeController extends Controller
{
   

    // crud toko
    #[Get("")]
    public function index()
    {
        $paymentTypes = PaymentType::all();
        return view('Page.PaymentType.index', compact('paymentTypes'));
    }

    #[Get("tambah")]
    public function formtambah()
    {
        return view('Page.PaymentType.tambah');
    }

    #[Get("edit/{id}")]
    public function edit($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        return view('Page.PaymentType.edit', compact('paymentType'));
    }

    #[Post("tambahdata")]
    public function store(Request $request, UploadedService $uploadedService)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $paymentType = new PaymentType();
    $paymentType->name = $request->name;
    $paymentType->description = $request->description;
    
    if ($request->hasFile('icon')) {
        $paymentType->icon = $uploadedService->saveImage($request, 'icon', 'image/icons/')->name;
    }

    $paymentType->save();

    Alert::success('Success', 'Payment type added successfully!');
    return redirect()->route('paymenttype.index');
}


    #[Put("editdata/{id}")]
    public function update(Request $request, UploadedService $uploadedService, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $paymentType = PaymentType::findOrFail($id);
    
        $paymentType->name = $request->name;
        $paymentType->description = $request->description;
    
        if ($request->hasFile('icon')) {
            // Optionally, delete the old icon file if necessary
            if ($paymentType->icon) {
                Storage::delete('image/icons/' . $paymentType->icon);
            }
            $paymentType->icon = $uploadedService->saveImage($request, 'icon', 'image/icons/')->name;
        }
    
        $paymentType->save();
    
        Alert::success('Success', 'Payment type updated successfully!');
        return redirect()->route('paymenttype.index');
    }
    

    #[Delete("destroy/{id}")]
    public function destroy($id)
    {
        try {
            $paymentType = PaymentType::findOrFail($id);
    
            // Delete the icon file if it exists
            if ($paymentType->icon && Storage::exists('image/icons/' . $paymentType->icon)) {
                Storage::delete('image/icons/' . $paymentType->icon);
            }
    
            // Delete the payment type
            $paymentType->delete();
    
            Alert::success('Success', 'Payment type deleted successfully!');
            return redirect()->route('paymenttype.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete payment type: ' . $e->getMessage());
            return redirect()->route('paymenttype.index');
        }
    }
    
    
}
