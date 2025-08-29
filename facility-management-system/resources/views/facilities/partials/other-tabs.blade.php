<!-- 建物タブ -->
<div class="tab-pane fade" id="building" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">建物情報</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">建物に関する詳細情報を管理します。</p>
            <div class="text-center">
                <span class="badge bg-secondary">実装予定</span>
            </div>
        </div>
    </div>
</div>

<!-- ライフライン・設備タブ -->
<div class="tab-pane fade" id="utilities" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-3">ライフライン・設備</h5>
            <!-- カテゴリータブ -->
            <ul class="nav nav-pills nav-fill" id="utilities-category-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active category-tab" data-category="all" type="button">
                        <i class="bi bi-grid-3x3-gap me-1"></i>すべて
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="electrical" type="button">
                        <i class="bi bi-lightning-charge me-1"></i>電気
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="gas" type="button">
                        <i class="bi bi-fire me-1"></i>ガス
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="water" type="button">
                        <i class="bi bi-droplet me-1"></i>給排水
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="communication" type="button">
                        <i class="bi bi-wifi me-1"></i>通信
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="elevator" type="button">
                        <i class="bi bi-arrow-up-square me-1"></i>EV
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="hvac" type="button">
                        <i class="bi bi-wind me-1"></i>空調
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <!-- Utilities Accordion -->
            <div class="accordion facility-accordion utilities-accordion" id="utilitiesAccordion">
                <!-- 電気設備 -->
                <div class="accordion-item utilities-section" data-category="electrical">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#electricalCollapse" aria-expanded="true" aria-controls="electricalCollapse">
                            <i class="bi bi-lightning-charge me-2"></i>電気設備
                        </button>
                    </h2>
                    <div id="electricalCollapse" class="accordion-collapse collapse show" data-bs-parent="#utilitiesAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-toggle-container">
                                        <label class="form-label">電力会社</label>
                                        <div class="form-display empty"></div>
                                        <div class="form-edit">
                                            <input type="text" class="form-control" name="electrical_company" placeholder="例）東京電力">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-toggle-container">
                                        <label class="form-label">契約容量</label>
                                        <div class="form-display empty"></div>
                                        <div class="form-edit">
                                            <input type="text" class="form-control" name="electrical_capacity" placeholder="例）50kW">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ガス設備 -->
                <div class="accordion-item utilities-section" data-category="gas">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#gasCollapse" aria-expanded="false" aria-controls="gasCollapse">
                            <i class="bi bi-fire me-2"></i>ガス設備
                        </button>
                    </h2>
                    <div id="gasCollapse" class="accordion-collapse collapse" data-bs-parent="#utilitiesAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-toggle-container">
                                        <label class="form-label">ガス会社</label>
                                        <div class="form-display empty"></div>
                                        <div class="form-edit">
                                            <input type="text" class="form-control" name="gas_company" placeholder="例）東京ガス">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-toggle-container">
                                        <label class="form-label">ガス種別</label>
                                        <div class="form-display empty"></div>
                                        <div class="form-edit">
                                            <div class="facility-dropdown">
                                                <select class="form-select dropdown-toggle" name="gas_type">
                                                    <option value="">選択してください</option>
                                                    <option value="都市ガス">都市ガス</option>
                                                    <option value="プロパンガス">プロパンガス</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 給排水設備 -->
            <div class="utilities-section" data-category="water">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-droplet me-2"></i>給排水設備
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">上水道</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="water_supply" placeholder="例）市営水道">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">下水道</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="sewerage" placeholder="例）公共下水道">
                    </div>
                </div>
            </div>

            <!-- 通信設備 -->
            <div class="utilities-section" data-category="communication">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-wifi me-2"></i>通信設備
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">インターネット回線</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="internet_provider" placeholder="例）NTT東日本">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ナースコール</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="nurse_call_system" placeholder="例）パナソニック">
                    </div>
                </div>
            </div>

            <!-- エレベーター -->
            <div class="utilities-section" data-category="elevator">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-arrow-up-square me-2"></i>エレベーター
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">エレベーター（有無）</label>
                        <div class="form-display">未設定</div>
                        <select class="form-select form-edit d-none" name="elevator_available">
                            <option value="">選択してください</option>
                            <option value="あり">あり</option>
                            <option value="なし">なし</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">保守業者</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="elevator_maintenance_company" placeholder="例）三菱電機ビルテクノサービス">
                    </div>
                </div>
            </div>

            <!-- 空調機 -->
            <div class="utilities-section" data-category="hvac">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-wind me-2"></i>空調機
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">空調システム</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="hvac_system" placeholder="例）セントラル空調">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">フロンガス点検日</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="freon_inspection_date">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 防犯・防災タブ -->
<div class="tab-pane fade" id="security" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-3">防犯・防災</h5>
            <!-- カテゴリータブ -->
            <ul class="nav nav-pills nav-fill" id="security-category-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active category-tab" data-category="all" type="button">
                        <i class="bi bi-grid-3x3-gap me-1"></i>すべて
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="camera" type="button">
                        <i class="bi bi-camera-video me-1"></i>防犯カメラ
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="lock" type="button">
                        <i class="bi bi-key me-1"></i>電子錠
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="fire" type="button">
                        <i class="bi bi-fire me-1"></i>消防・防災
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <!-- 防犯カメラ -->
            <div class="security-section" data-category="camera">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-camera-video me-2"></i>防犯カメラ
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">契約会社</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="camera_contract_company" placeholder="例）セコム">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">設置台数</label>
                        <div class="form-display">未設定</div>
                        <input type="number" class="form-control form-edit d-none" name="camera_count" placeholder="例）12">
                    </div>
                </div>
            </div>

            <!-- 電子錠 -->
            <div class="security-section" data-category="lock">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-key me-2"></i>電子錠
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">契約会社</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="lock_contract_company" placeholder="例）美和ロック">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">設置箇所数</label>
                        <div class="form-display">未設定</div>
                        <input type="number" class="form-control form-edit d-none" name="lock_count" placeholder="例）5">
                    </div>
                </div>
            </div>

            <!-- 消防・防災 -->
            <div class="security-section" data-category="fire">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-fire me-2"></i>消防・防災
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">防火管理者</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="fire_manager" placeholder="例）田中太郎">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">消防設備点検業者</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="fire_equipment_company" placeholder="例）○○防災">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">消防訓練（実施日）</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="fire_drill_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">実地訓練（実施日）</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="practical_drill_date">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 契約書タブ -->
<div class="tab-pane fade" id="contracts" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-3">契約書</h5>
            <!-- カテゴリータブ -->
            <ul class="nav nav-pills nav-fill flex-wrap" id="contracts-category-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active category-tab" data-category="all" type="button">
                        <i class="bi bi-grid-3x3-gap me-1"></i>すべて
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="kitchen" type="button">
                        <i class="bi bi-house me-1"></i>厨房
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="cleaning" type="button">
                        <i class="bi bi-brush me-1"></i>清掃
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="pest" type="button">
                        <i class="bi bi-bug me-1"></i>害虫駆除
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="linen" type="button">
                        <i class="bi bi-basket me-1"></i>リネン
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="other" type="button">
                        <i class="bi bi-three-dots me-1"></i>その他
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <!-- 厨房委託 -->
            <div class="contracts-section" data-category="kitchen">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-house me-2"></i>厨房委託
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">会社名</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="kitchen_company" placeholder="例）○○給食サービス">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">契約期間</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="kitchen_contract_period" placeholder="例）2024/04/01 - 2025/03/31">
                    </div>
                </div>
            </div>

            <!-- 定期清掃 -->
            <div class="contracts-section" data-category="cleaning">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-brush me-2"></i>定期清掃
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">会社名</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="cleaning_company" placeholder="例）○○清掃サービス">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">清掃頻度</label>
                        <div class="form-display">未設定</div>
                        <select class="form-select form-edit d-none" name="cleaning_frequency">
                            <option value="">選択してください</option>
                            <option value="毎日">毎日</option>
                            <option value="週2回">週2回</option>
                            <option value="週1回">週1回</option>
                            <option value="月2回">月2回</option>
                            <option value="月1回">月1回</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 害虫駆除 -->
            <div class="contracts-section" data-category="pest">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-bug me-2"></i>害虫駆除
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">会社名</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="pest_company" placeholder="例）○○害虫駆除">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">実施頻度</label>
                        <div class="form-display">未設定</div>
                        <select class="form-select form-edit d-none" name="pest_frequency">
                            <option value="">選択してください</option>
                            <option value="月1回">月1回</option>
                            <option value="2ヶ月に1回">2ヶ月に1回</option>
                            <option value="3ヶ月に1回">3ヶ月に1回</option>
                            <option value="年2回">年2回</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- その他の契約 -->
            <div class="contracts-section" data-category="linen">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-basket me-2"></i>リネン
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">会社名</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="linen_company" placeholder="例）○○リネンサービス">
                    </div>
                </div>
            </div>

            <div class="contracts-section" data-category="other">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-three-dots me-2"></i>その他契約
                </h6>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">備考</label>
                        <div class="form-display">未設定</div>
                        <textarea class="form-control form-edit d-none" name="other_contracts" rows="3" placeholder="その他の契約について記載"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 図面タブ -->
<div class="tab-pane fade" id="blueprints" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-3">図面関係</h5>
            <!-- カテゴリータブ -->
            <ul class="nav nav-pills nav-fill" id="blueprints-category-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active category-tab" data-category="all" type="button">
                        <i class="bi bi-grid-3x3-gap me-1"></i>すべて
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="floor" type="button">
                        <i class="bi bi-grid me-1"></i>平面図
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="elevation" type="button">
                        <i class="bi bi-building me-1"></i>立面図
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="site" type="button">
                        <i class="bi bi-geo-alt me-1"></i>配置図
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="plumbing" type="button">
                        <i class="bi bi-droplet me-1"></i>給排水
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="electrical" type="button">
                        <i class="bi bi-lightning me-1"></i>電気
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <!-- 平面図 -->
            <div class="blueprints-section" data-category="floor">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-grid me-2"></i>平面図
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ファイル</label>
                        <div class="form-display">
                            <span class="text-muted">ファイルなし</span>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2 form-edit d-none">
                                <i class="bi bi-upload me-1"></i>アップロード
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">更新日</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="floor_plan_date">
                    </div>
                </div>
            </div>

            <!-- 立面図 -->
            <div class="blueprints-section" data-category="elevation">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-building me-2"></i>立面図
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ファイル</label>
                        <div class="form-display">
                            <span class="text-muted">ファイルなし</span>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2 form-edit d-none">
                                <i class="bi bi-upload me-1"></i>アップロード
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 配置図 -->
            <div class="blueprints-section" data-category="site">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-geo-alt me-2"></i>配置図
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ファイル</label>
                        <div class="form-display">
                            <span class="text-muted">ファイルなし</span>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2 form-edit d-none">
                                <i class="bi bi-upload me-1"></i>アップロード
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 給排水衛生設備図面 -->
            <div class="blueprints-section" data-category="plumbing">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-droplet me-2"></i>給排水衛生設備図面
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ファイル</label>
                        <div class="form-display">
                            <span class="text-muted">ファイルなし</span>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2 form-edit d-none">
                                <i class="bi bi-upload me-1"></i>アップロード
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 電気設備図面 -->
            <div class="blueprints-section" data-category="electrical">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-lightning me-2"></i>電気設備図面
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ファイル</label>
                        <div class="form-display">
                            <span class="text-muted">ファイルなし</span>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2 form-edit d-none">
                                <i class="bi bi-upload me-1"></i>アップロード
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 大規模修繕履歴タブ -->
<div class="tab-pane fade" id="maintenance" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-3">大規模修繕履歴</h5>
            <!-- カテゴリータブ -->
            <ul class="nav nav-pills nav-fill" id="maintenance-category-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active category-tab" data-category="all" type="button">
                        <i class="bi bi-grid-3x3-gap me-1"></i>すべて
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="waterproof" type="button">
                        <i class="bi bi-droplet-half me-1"></i>防水
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="painting" type="button">
                        <i class="bi bi-palette me-1"></i>塗装
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="roof" type="button">
                        <i class="bi bi-house-door me-1"></i>屋根
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link category-tab" data-category="equipment" type="button">
                        <i class="bi bi-gear me-1"></i>設備
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <!-- 外壁（防水） -->
            <div class="maintenance-section" data-category="waterproof">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-droplet-half me-2"></i>外壁（防水）
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">施工日</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="waterproof_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">施工会社</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="waterproof_company" placeholder="例）○○防水工業">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">保証終了日</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="waterproof_warranty_end">
                    </div>
                </div>
            </div>

            <!-- 外壁（塗装） -->
            <div class="maintenance-section" data-category="painting">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-palette me-2"></i>外壁（塗装）
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">施工日</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="painting_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">施工会社</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="painting_company" placeholder="例）○○塗装">
                    </div>
                </div>
            </div>

            <!-- 屋根修繕 -->
            <div class="maintenance-section" data-category="roof">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-house-door me-2"></i>屋根修繕
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">施工日</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="roof_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">施工会社</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="roof_company" placeholder="例）○○屋根工事">
                    </div>
                </div>
            </div>

            <!-- 設備更新 -->
            <div class="maintenance-section" data-category="equipment">
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="bi bi-gear me-2"></i>設備更新
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">更新日</label>
                        <div class="form-display">未設定</div>
                        <input type="date" class="form-control form-edit d-none" name="equipment_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">設備種類</label>
                        <div class="form-display">未設定</div>
                        <input type="text" class="form-control form-edit d-none" name="equipment_type" placeholder="例）エレベーター、空調設備">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ドキュメントタブ -->
<div class="tab-pane fade" id="documents" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">ドキュメント</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">施設に関連する各種ドキュメントを管理します。</p>
            <div class="text-center">
                <span class="badge bg-secondary">実装予定</span>
            </div>
        </div>
    </div>
</div>