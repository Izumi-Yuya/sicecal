@extends('layouts.app')

@section('title', '施設新規登録')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('facilities.index') }}">施設一覧</a></li>
                    <li class="breadcrumb-item active" aria-current="page">新規登録</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">
                <i class="bi bi-plus-circle me-2"></i>施設新規登録
            </h1>
        </div>
        
        <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>一覧に戻る
        </a>
    </div>

    <!-- Registration Form -->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('facilities.store') }}" data-enhanced-validation>
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="facility_code" class="form-label">施設コード <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('facility_code') is-invalid @enderror" 
                               id="facility_code" name="facility_code" value="{{ old('facility_code') }}" required>
                        @error('facility_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">施設名 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="department_id" class="form-label">部門</label>
                        <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                            <option value="">選択してください</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="region_id" class="form-label">地区</label>
                        <select class="form-select @error('region_id') is-invalid @enderror" id="region_id" name="region_id">
                            <option value="">選択してください</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="business_type" class="form-label">事業種別</label>
                        <select class="form-select @error('business_type') is-invalid @enderror" id="business_type" name="business_type">
                            <option value="">選択してください</option>
                            <option value="有料老人ホーム" {{ old('business_type') == '有料老人ホーム' ? 'selected' : '' }}>有料老人ホーム</option>
                            <option value="グループホーム" {{ old('business_type') == 'グループホーム' ? 'selected' : '' }}>グループホーム</option>
                            <option value="デイサービス" {{ old('business_type') == 'デイサービス' ? 'selected' : '' }}>デイサービス</option>
                            <option value="訪問看護" {{ old('business_type') == '訪問看護' ? 'selected' : '' }}>訪問看護</option>
                            <option value="ヘルパーステーション" {{ old('business_type') == 'ヘルパーステーション' ? 'selected' : '' }}>ヘルパーステーション</option>
                            <option value="ケアプラン" {{ old('business_type') == 'ケアプラン' ? 'selected' : '' }}>ケアプラン</option>
                            <option value="事務所" {{ old('business_type') == '事務所' ? 'selected' : '' }}>事務所</option>
                        </select>
                        @error('business_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="opening_date" class="form-label">開設年月日</label>
                        <input type="date" class="form-control @error('opening_date') is-invalid @enderror" 
                               id="opening_date" name="opening_date" value="{{ old('opening_date') }}">
                        @error('opening_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="postal_code" class="form-label">郵便番号</label>
                        <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                               id="postal_code" name="postal_code" value="{{ old('postal_code') }}" 
                               placeholder="1234567" maxlength="7">
                        @error('postal_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="prefecture" class="form-label">都道府県</label>
                        <input type="text" class="form-control @error('prefecture') is-invalid @enderror" 
                               id="prefecture" name="prefecture" value="{{ old('prefecture') }}">
                        @error('prefecture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="city" class="form-label">市区町村</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                               id="city" name="city" value="{{ old('city') }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">住所</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="2">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone_number" class="form-label">電話番号</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="fax_number" class="form-label">FAX番号</label>
                        <input type="text" class="form-control @error('fax_number') is-invalid @enderror" 
                               id="fax_number" name="fax_number" value="{{ old('fax_number') }}">
                        @error('fax_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="capacity" class="form-label">定員</label>
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                               id="capacity" name="capacity" value="{{ old('capacity') }}" min="0">
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="floor_area" class="form-label">延床面積（㎡）</label>
                        <input type="number" step="0.01" class="form-control @error('floor_area') is-invalid @enderror" 
                               id="floor_area" name="floor_area" value="{{ old('floor_area') }}" min="0">
                        @error('floor_area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="construction_year" class="form-label">建築年</label>
                        <input type="number" class="form-control @error('construction_year') is-invalid @enderror" 
                               id="construction_year" name="construction_year" value="{{ old('construction_year') }}" 
                               min="1900" max="{{ date('Y') + 10 }}">
                        @error('construction_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">キャンセル</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>登録
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection