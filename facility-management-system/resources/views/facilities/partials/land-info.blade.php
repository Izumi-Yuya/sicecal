<!-- 土地タブ -->
<div class="tab-pane fade" id="land" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">土地情報</h5>
        </div>
        <div class="card-body">
            <form id="landForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">所有</label>
                        <div class="form-display">{{ $facility->land_ownership ?? '未設定' }}</div>
                        <select class="form-select form-edit d-none" name="land_ownership">
                            <option value="">選択してください</option>
                            <option value="自社" {{ $facility->land_ownership === '自社' ? 'selected' : '' }}>自社</option>
                            <option value="賃借" {{ $facility->land_ownership === '賃借' ? 'selected' : '' }}>賃借</option>
                            <option value="自社（賃貸）" {{ $facility->land_ownership === '自社（賃貸）' ? 'selected' : '' }}>自社（賃貸）</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">敷地内駐車場台数</label>
                        <div class="form-display">{{ $facility->site_parking_spaces ? $facility->site_parking_spaces . '台' : '未設定' }}</div>
                        <input type="number" class="form-control form-edit d-none" name="site_parking_spaces" value="{{ $facility->site_parking_spaces }}" placeholder="例）20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">敷地面積（㎡）</label>
                        <div class="form-display">{{ $facility->site_area_sqm ? number_format($facility->site_area_sqm, 2) . '㎡' : '未設定' }}</div>
                        <input type="number" step="0.01" class="form-control form-edit d-none" name="site_area_sqm" value="{{ $facility->site_area_sqm }}" placeholder="例）290.00">
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-toggle-container manual-input-field">
                            <label class="form-label">敷地面積（坪数）</label>
                            <div class="form-display {{ empty($facility->site_area_tsubo) ? 'empty' : '' }}">{{ $facility->site_area_tsubo ? number_format($facility->site_area_tsubo, 2) . '坪' : '' }}</div>
                            <div class="form-edit">
                                <input type="number" step="0.01" class="form-control" name="site_area_tsubo" value="{{ $facility->site_area_tsubo }}" placeholder="例）89.05">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-toggle-container manual-input-field">
                            <label class="form-label">購入金額</label>
                            <div class="form-display {{ empty($facility->land_purchase_price) ? 'empty' : '' }}">{{ $facility->land_purchase_price ? '¥' . number_format($facility->land_purchase_price) : '' }}</div>
                            <div class="form-edit">
                                <input type="number" class="form-control" name="land_purchase_price" value="{{ $facility->land_purchase_price }}" placeholder="例）10000000">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="auto-calculated-field" data-calculation="land-unit-price" data-depends-on="input[name='land_purchase_price'], input[name='site_area_tsubo']">
                            <label class="form-label">坪単価（自動計算）</label>
                            <div class="form-display">{{ $facility->land_unit_price ? '¥' . number_format($facility->land_unit_price) . '/坪' : '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">家賃</label>
                        <div class="form-display">{{ $facility->land_rent ? '¥' . number_format($facility->land_rent) . '/月' : '未設定' }}</div>
                        <input type="number" class="form-control form-edit d-none" name="land_rent" value="{{ $facility->land_rent }}" placeholder="例）100000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">契約期間（契約開始日）</label>
                        <div class="form-display">{{ $facility->land_contract_start_date ? $facility->land_contract_start_date->format('Y年m月d日') : '未設定' }}</div>
                        <input type="date" class="form-control form-edit d-none" name="land_contract_start_date" value="{{ $facility->land_contract_start_date ? $facility->land_contract_start_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">契約期間（契約終了日）</label>
                        <div class="form-display">{{ $facility->land_contract_end_date ? $facility->land_contract_end_date->format('Y年m月d日') : '未設定' }}</div>
                        <input type="date" class="form-control form-edit d-none" name="land_contract_end_date" value="{{ $facility->land_contract_end_date ? $facility->land_contract_end_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">自動更新の有無</label>
                        <div class="form-display">{{ $facility->land_auto_renewal ?? '未設定' }}</div>
                        <select class="form-select form-edit d-none" name="land_auto_renewal">
                            <option value="">選択してください</option>
                            <option value="あり" {{ $facility->land_auto_renewal === 'あり' ? 'selected' : '' }}>あり</option>
                            <option value="なし" {{ $facility->land_auto_renewal === 'なし' ? 'selected' : '' }}>なし</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">契約年数（自動計算）</label>
                        <div class="form-display text-info">{{ $facility->land_contract_years ?? '未計算' }}</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>