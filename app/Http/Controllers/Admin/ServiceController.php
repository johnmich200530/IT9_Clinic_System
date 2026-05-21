<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $services = Service::when($search, function ($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('duration', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.services.index', compact('services', 'search'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'duration'     => 'required|string|max:100',
            'description'  => 'nullable|string',
        ]);

        Service::create($request->only(['service_name', 'price', 'duration', 'description']));

        return redirect()->route('admin.services.index')
            ->with('success', 'Service added successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'duration'     => 'required|string|max:100',
            'description'  => 'nullable|string',
        ]);

        $service->update($request->only(['service_name', 'price', 'duration', 'description']));

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
