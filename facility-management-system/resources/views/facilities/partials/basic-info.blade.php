<!-- 基本情報タブ -->
<div class="tab-pane fade show active" id="basic" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">基本情報</h5>
        </div>
        <div class="card-body">
            <form id="basicForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">会社名</label>
                        <div class="form-display">{{ $facility->company_name ?? '未設定' }}</div>
                        <select class="form-select form-edit d-none" name="company_name">
                            <option value="">選択してください</option>
                            <option value="株式会社シダー" {{ $facility->company_name === '株式会社シダー' ? 'selected' : '' }}>株式会社シダー</option>
                            <option value="株式会社パイン" {{ $facility->company_name === '株式会社パイン' ? 'selected' : '' }}>株式会社パイン</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">事業所コード</label>
                        <div class="form-display">{{ $facility->facility_code ?? '未設定' }}</div>
                        <input type="text" class="form-control form-edit d-none" name="facility_code" value="{{ $facility->facility_code }}" placeholder="例）12345">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">指定番号</label>
                        <div class="form-display">{{ $facility->designation_number ?? '未設定' }}</div>
                        <input type="text" class="form-control form-edit d-none" name="designation_number" value="{{ $facility->designation_number }}" placeholder="例）1234567890">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">施設名 <span class="text-danger">*</span></label>
                        <div class="form-display fw-bold">{{ $facility->name }}</div>
                        <input type="text" class="form-control form-edit d-none" name="name" value="{{ $facility->name }}" placeholder="例）○○介護センター" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">郵便番号</label>
                        <div class="form-display">{{ $facility->postal_code ? '〒' . substr($facility->postal_code, 0, 3) . '-' . substr($facility->postal_code, 3) : '未設定' }}</div>
                        <input type="text" class="form-control form-edit d-none" name="postal_code" value="{{ $facility->postal_code }}" placeholder="例）123-4567" pattern="[0-9]{3}-[0-9]{4}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">住所</label>
                        <div class="form-display">{{ $facility->address ?? '未設定' }}</div>
                        <input type="text" class="form-control form-edit d-none" name="address" value="{{ $facility->address }}" placeholder="例）千葉県千葉市花見川区畑町455-5">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">住所（建物名）</label>
                        <div class="form-display">{{ $facility->building_name ?? '未設定' }}</div>
                        <input type="text" class="form-control form-edit d-none" name="building_name" value="{{ $facility->building_name }}" placeholder="例）ハイネス高橋202号室">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">電話番号</label>
                        <div class="form-display">{{ $facility->phone_number ?? '未設定' }}</div>
                        <input type="tel" class="form-control form-edit d-none" name="phone_number" value="{{ $facility->phone_number }}" placeholder="例）03-1234-5678">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">FAX番号</label>
                        <div class="form-display">{{ $facility->fax_number ?? '未設定' }}</div>
                        <input type="tel" class="form-control form-edit d-none" name="fax_number" value="{{ $facility->fax_number }}" placeholder="例）03-1234-5679">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">フリーダイヤル</label>
                        <div class="form-display">{{ $facility->free_dial ?? '未設定' }}</div>
                        <input type="tel" class="form-control form-edit d-none" name="free_dial" value="{{ $facility->free_dial }}" placeholder="例）0120-123-456">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">メールアドレス</label>
                        <div class="form-display">{{ $facility->email ?? '未設定' }}</div>
                        <input type="email" class="form-control form-edit d-none" name="email" value="{{ $facility->email }}" placeholder="例）info@example.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">URL</label>
                        <div class="form-display">
                            @if($facility->url)
                                <a href="{{ $facility->url }}" target="_blank">{{ $facility->url }}</a>
                            @else
                                未設定
                            @endif
                        </div>
                        <input type="url" class="form-control form-edit d-none" name="url" value="{{ $facility->url }}" placeholder="例）https://www.example.com">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">開設日</label>
                        <div class="form-display">{{ $facility->opening_date ? $facility->opening_date->format('Y年m月d日') : '未設定' }}</div>
                        <input type="date" class="form-control form-edit d-none" name="opening_date" value="{{ $facility->opening_date ? $facility->opening_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">開設年数（自動計算）</label>
                        <div class="form-display text-info operating-years-display">{{ $facility->operating_years ?? '未計算' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">部門</label>
                        <div class="form-display">{{ $facility->department?->name ?? '未設定' }}</div>
                        <select class="form-select form-edit d-none" name="department_id">
                            <option value="">選択してください</option>
                            @foreach(\App\Models\Department::orderBy('name')->get() as $department)
                                <option value="{{ $department->id }}" {{ $facility->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">地区</label>
                        <div class="form-display">{{ $facility->region?->name ?? '未設定' }}</div>
                        <select class="form-select form-edit d-none" name="region_id">
                            <option value="">選択してください</option>
                            @foreach(\App\Models\Region::orderBy('name')->get() as $region)
                                <option value="{{ $region->id }}" {{ $facility->region_id == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">建物構造</label>
                        <div class="form-display">{{ $facility->building_structure ?? '未設定' }}</div>
                        <input type="text" class="form-control form-edit d-none" name="building_structure" value="{{ $facility->building_structure }}" placeholder="例）鉄筋コンクリート造">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">建物階数</label>
                        <div class="form-display">{{ $facility->building_floors ? $facility->building_floors . '階建' : '未設定' }}</div>
                        <input type="number" class="form-control form-edit d-none" name="building_floors" value="{{ $facility->building_floors }}" placeholder="例）4">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">居室数（有料）</label>
                        <div class="form-display">{{ $facility->room_count_paid ? $facility->room_count_paid . '室' : '未設定' }}</div>
                        <input type="number" class="form-control form-edit d-none" name="room_count_paid" value="{{ $facility->room_count_paid }}" placeholder="例）90">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">内SS数</label>
                        <div class="form-display">{{ $facility->internal_ss_count ? $facility->internal_ss_count . '室' : '未設定' }}</div>
                        <input type="number" class="form-control form-edit d-none" name="internal_ss_count" value="{{ $facility->internal_ss_count }}" placeholder="例）90">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">定員数</label>
                        <div class="form-display">{{ $facility->capacity ? $facility->capacity . '名' : '未設定' }}</div>
                        <input type="number" class="form-control form-edit d-none" name="capacity" value="{{ $facility->capacity }}" placeholder="例）80">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">サービスの種類</label>
                        <div class="form-display">
                            @if($facility->service_types && is_array($facility->service_types))
                                @foreach($facility->service_types as $service)
                                    <span class="badge bg-info me-1">{{ $service }}</span>
                                @endforeach
                            @else
                                未設定
                            @endif
                        </div>
                        <textarea class="form-control form-edit d-none" name="service_types" rows="3" placeholder="例）通所介護、訪問介護、居宅介護支援">{{ is_array($facility->service_types) ? implode(', ', $facility->service_types) : $facility->service_types }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">指定更新</label>
                        <div class="form-display">{{ $facility->designation_renewal_date ? $facility->designation_renewal_date->format('Y年m月d日') : '未設定' }}</div>
                        <input type="date" class="form-control form-edit d-none" name="designation_renewal_date" value="{{ $facility->designation_renewal_date ? $facility->designation_renewal_date->format('Y-m-d') : '' }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>