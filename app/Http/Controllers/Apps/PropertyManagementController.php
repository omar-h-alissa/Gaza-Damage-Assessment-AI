<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersAssignedRoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Property;
use App\Models\Report;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PropertyManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.apps.user-management.properties.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $properties = Property::where('user_id', auth()->id())->get(['property_owner', 'address', 'ownership_type', 'latitude', 'longitude']);

        return view('pages.apps.user-management.properties.create', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'property_owner' => 'required|string',
            'ownership_type' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $property = Property::create([
            'user_id' => auth()->id(),
            'property_owner' => $request->property_owner,
            'ownership_type' => $request->ownership_type,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'floors_count' => $request->floors_count,
            'residents_count' => $request->residents_count,
        ]);


        if ($request->hasFile('documents')) {
            $file = $request->file('documents');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/properties'), $filename);

            $property->documents = $filename;
            $property->save();
        }

        Activity::create([
            'user_id' => auth()->id(), // صاحب الطلب
            'title' => __('menu.added_property', ['user' => auth()->user()->name]),
            'type' => 'info',          // اللون (success, danger, warning, info)
            'icon' => 'bi-clipboard-check', // أيقونة مناسبة من Bootstrap Icons
        ]);


        return redirect()->route('user-management.properties.index')->with('success', 'Property added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property, UsersAssignedRoleDataTable $dataTable)
    {
        return $dataTable->with('property', $property)
            ->render('pages.apps.user-management.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('pages.apps.user-management.properties.create', compact('property'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. التحقق من صحة البيانات (Validation)
        // ملاحظة: قمنا بتغيير اسم حقل الملف في الكود الخاص بك من 'document' إلى 'documents' ليتوافق مع اسم الحقل في النموذج
        $request->validate([
            'property_owner' => 'required|string',
            'ownership_type' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            // الملف: nullable، ويتم تطبيقه على اسم الحقل 'documents'
            'documents' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // 2. البحث عن العقار للتعديل
        $property = Property::findOrFail($id);

        // 3. تحديث بيانات العقار (Update)
        $property->update([
            // لا نحتاج لتحديث user_id عادةً
            'property_owner' => $request->property_owner,
            'ownership_type' => $request->ownership_type,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'floors_count' => $request->floors_count,
            'residents_count' => $request->residents_count,
        ]);

        if ($request->hasFile('documents')) {

            if ($property->documents && file_exists(public_path('uploads/properties/' . $property->documents))) {
                unlink(public_path('uploads/properties/' . $property->documents));
            }

            $file = $request->file('documents');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/properties'), $filename);

            $property->documents = $filename;
            $property->save();
        }

        // 5. إعادة التوجيه ورسالة النجاح
        return redirect()->route('user-management.properties.index')->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        //
    }

    public function userMap()
    {
        $properties = \App\Models\Property::where('user_id', auth()->id())->get(['property_owner', 'address', 'ownership_type', 'latitude', 'longitude']);
        return view('pages.apps.user-management.properties.properties-map', compact('properties'));
    }
}
