<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller
{
    public function index(){
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('services.index', compact('services'));
    }

    public function create(){
        return view('services.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')
            ->with('success', 'Usluga je uspešno dodata!'); 
    }

    public function edit(Service $service){
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service){
     $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'duration_minutes' => 'required|integer|min:1',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')
               ->with('success', "Usluga je uspešno izmenjena!");
    }
    
    public function destroy(Service $service){
        if($service->bookings()->exists()){
            return redirect()->route('services.index')
                ->with('error', 'Usluga ima rezervacije i ne može se obrisati');
        }

        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Usluga je uspešno obrisana!');
    }
}
