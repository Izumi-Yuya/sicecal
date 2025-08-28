<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Department;
use App\Models\Region;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities with search and filtering capabilities.
     */
    public function index(Request $request)
    {
        // Get filter options for dropdowns
        $departments = Department::orderBy('name')->get();
        
        // Get unique prefectures from facilities
        $prefectures = Facility::select('prefecture')
            ->whereNotNull('prefecture')
            ->where('prefecture', '!=', '')
            ->distinct()
            ->orderBy('prefecture')
            ->pluck('prefecture');

        // Start building the query
        $query = Facility::with(['department', 'region']);

        // Apply search filters
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('facility_code', 'like', "%{$searchTerm}%");
            });
        }

        // Facility name specific search
        if ($request->filled('facility_name')) {
            $query->where('name', 'like', "%{$request->facility_name}%");
        }

        // Prefecture filter
        if ($request->filled('prefecture')) {
            $query->where('prefecture', $request->prefecture);
        }

        // Department filter
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Keyword search (searches across multiple fields)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('address', 'like', "%{$keyword}%")
                  ->orWhere('phone_number', 'like', "%{$keyword}%")
                  ->orWhere('fax_number', 'like', "%{$keyword}%")
                  ->orWhere('city', 'like', "%{$keyword}%")
                  ->orWhere('postal_code', 'like', "%{$keyword}%")
                  ->orWhere('business_type', 'like', "%{$keyword}%");
            });
        }

        // Apply role-based access control
        $user = session('user');
        if ($user) {
            $userRole = $user['role'];
            
            switch ($userRole) {
                case 'system_admin':
                case 'editor':
                case 'approver':
                case 'viewer_executive':
                    // Can view all facilities
                    break;
                    
                case 'viewer_department':
                    // Can only view facilities in their department
                    // For demo purposes, we'll show all facilities
                    // In real implementation, filter by user's department_id
                    break;
                    
                case 'viewer_district':
                    // Can only view facilities in their region
                    // For demo purposes, we'll show all facilities
                    // In real implementation, filter by user's region_id
                    break;
                    
                case 'viewer_facility':
                    // Can only view their own facility
                    // For demo purposes, we'll show all facilities
                    // In real implementation, filter by user's facility_id
                    break;
                    
                default:
                    // Default to no access
                    $query->whereRaw('1 = 0');
                    break;
            }
        }

        // Order by prefecture first, then by facility name
        $query->orderBy('prefecture')
              ->orderBy('name');

        // Get all results without pagination
        $facilities = $query->get();

        return view('facilities.index', compact(
            'facilities',
            'departments',
            'prefectures'
        ));
    }

    /**
     * Show the form for creating a new facility.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        
        return view('facilities.create', compact('departments', 'regions'));
    }

    /**
     * Store a newly created facility in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_code' => 'required|string|max:255|unique:facilities',
            'name' => 'required|string|max:255|unique:facilities',
            'department_id' => 'nullable|exists:departments,id',
            'region_id' => 'nullable|exists:regions,id',
            'business_type' => 'nullable|string|max:255',
            'opening_date' => 'nullable|date',
            'postal_code' => 'nullable|string|size:7',
            'prefecture' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:255',
            'fax_number' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'floor_area' => 'nullable|numeric|min:0',
            'construction_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
        ], [
            'facility_code.required' => '施設コードは必須です',
            'facility_code.unique' => 'この施設コードは既に使用されています',
            'name.required' => '施設名は必須です',
            'name.unique' => 'この施設名は既に使用されています',
            'postal_code.size' => '郵便番号は7桁で入力してください',
            'capacity.min' => '定員は0以上で入力してください',
            'floor_area.min' => '延床面積は0以上で入力してください',
        ]);

        $facility = Facility::create($validated);

        return redirect()->route('facilities.show', $facility)
            ->with('success', '施設「' . $facility->name . '」を登録しました。');
    }

    /**
     * Show the specified facility.
     */
    public function show(Facility $facility)
    {
        $facility->load(['department', 'region']);
        
        return view('facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified facility.
     */
    public function edit(Facility $facility)
    {
        $departments = Department::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        
        return view('facilities.edit', compact('facility', 'departments', 'regions'));
    }

    /**
     * Update the specified facility in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            // Basic information
            'company_name' => 'nullable|string|max:30',
            'facility_code' => 'required|string|max:10|unique:facilities,facility_code,' . $facility->id,
            'designation_number' => 'nullable|string|max:10',
            'name' => 'required|string|max:20|unique:facilities,name,' . $facility->id,
            'postal_code' => 'nullable|string|max:8',
            'address' => 'nullable|string|max:30',
            'building_name' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:13',
            'fax_number' => 'nullable|string|max:13',
            'free_dial' => 'nullable|string|max:14',
            'email' => 'nullable|email|max:100',
            'url' => 'nullable|url|max:100',
            'opening_date' => 'nullable|date',
            'building_structure' => 'nullable|string|max:20',
            'building_floors' => 'nullable|integer|min:1',
            'room_count_paid' => 'nullable|integer|min:0',
            'internal_ss_count' => 'nullable|integer|min:0',
            'capacity' => 'nullable|integer|min:0',
            'service_types' => 'nullable|string|max:200',
            'designation_renewal_date' => 'nullable|date',
            
            // Land information
            'land_ownership' => 'nullable|in:自社,賃借,自社（賃貸）',
            'site_parking_spaces' => 'nullable|integer|min:0',
            'site_area_sqm' => 'nullable|numeric|min:0',
            'site_area_tsubo' => 'nullable|numeric|min:0',
            'land_purchase_price' => 'nullable|integer|min:0',
            'land_rent' => 'nullable|integer|min:0',
            'land_contract_start_date' => 'nullable|date',
            'land_contract_end_date' => 'nullable|date|after_or_equal:land_contract_start_date',
            'land_auto_renewal' => 'nullable|in:あり,なし',
            
            // Building information
            'building_ownership' => 'nullable|in:自社,賃借,賃貸',
            'building_area_sqm' => 'nullable|numeric|min:0',
            'building_area_tsubo' => 'nullable|numeric|min:0',
            'floor_area_sqm' => 'nullable|numeric|min:0',
            'floor_area_tsubo' => 'nullable|numeric|min:0',
            'building_main_price' => 'nullable|integer|min:0',
            'building_cooperation_fund' => 'nullable|integer|min:0',
            'building_rent_monthly' => 'nullable|integer|min:0',
            'building_contract_start_date' => 'nullable|date',
            'building_contract_end_date' => 'nullable|date|after_or_equal:building_contract_start_date',
            'building_auto_renewal' => 'nullable|in:あり,なし',
            'completion_date' => 'nullable|date',
            'useful_life' => 'nullable|integer|min:1|max:100',
            'building_inspection_type' => 'nullable|in:自社手配,外部手配,対象外',
            'building_inspection_date' => 'nullable|date',
            
            'department_id' => 'nullable|exists:departments,id',
            'region_id' => 'nullable|exists:regions,id',
        ], [
            'facility_code.required' => '施設コードは必須です',
            'facility_code.unique' => 'この施設コードは既に使用されています',
            'name.required' => '施設名は必須です',
            'name.unique' => 'この施設名は既に使用されています',
            'email.email' => '正しいメールアドレス形式で入力してください',
            'url.url' => '正しいURL形式で入力してください',
            'land_contract_end_date.after_or_equal' => '契約終了日は契約開始日以降の日付を入力してください',
            'building_contract_end_date.after_or_equal' => '契約終了日は契約開始日以降の日付を入力してください',
        ]);

        // Process service_types as array
        if (isset($validated['service_types'])) {
            $validated['service_types'] = array_map('trim', explode(',', $validated['service_types']));
        }

        $facility->update($validated);

        return redirect()->route('facilities.show', $facility)
            ->with('success', '施設情報を更新しました。');
    }
}