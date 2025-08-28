@extends('layouts.app')

@section('title', '- Bootstrap テスト')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Bootstrap 5 コンポーネントテスト</h1>
        <p class="lead">Bootstrap 5の各種コンポーネントが正常に動作することを確認します。</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">ボタンテスト</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary me-2">Primary</button>
                <button type="button" class="btn btn-secondary me-2">Secondary</button>
                <button type="button" class="btn btn-success me-2">Success</button>
                <button type="button" class="btn btn-danger me-2">Danger</button>
                <button type="button" class="btn btn-warning me-2">Warning</button>
                <button type="button" class="btn btn-info me-2">Info</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">アラートテスト</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    成功メッセージです！
                </div>
                <div class="alert alert-warning" role="alert">
                    警告メッセージです！
                </div>
                <div class="alert alert-danger" role="alert">
                    エラーメッセージです！
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">フォームテスト</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="testInput" class="form-label required">テスト入力</label>
                        <input type="text" class="form-control" id="testInput" placeholder="テキストを入力してください">
                    </div>
                    <div class="mb-3">
                        <label for="testSelect" class="form-label">選択テスト</label>
                        <select class="form-select" id="testSelect">
                            <option selected>選択してください</option>
                            <option value="1">オプション 1</option>
                            <option value="2">オプション 2</option>
                            <option value="3">オプション 3</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="testCheck">
                        <label class="form-check-label" for="testCheck">
                            チェックボックステスト
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">送信</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">モーダルテスト</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModal">
                    モーダルを開く
                </button>
                
                <div class="modal fade" id="testModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">テストモーダル</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>これはBootstrap 5のモーダルテストです。</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                <button type="button" class="btn btn-primary">保存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">テーブルテスト</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">施設名</th>
                            <th scope="col">都道府県</th>
                            <th scope="col">ステータス</th>
                            <th scope="col">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>テスト施設A</td>
                            <td>東京都</td>
                            <td><span class="badge bg-success">承認済み</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">編集</button>
                                <button class="btn btn-sm btn-outline-danger">削除</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>テスト施設B</td>
                            <td>大阪府</td>
                            <td><span class="badge bg-warning">承認待ち</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">編集</button>
                                <button class="btn btn-sm btn-outline-danger">削除</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>テスト施設C</td>
                            <td>愛知県</td>
                            <td><span class="badge bg-danger">却下</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">編集</button>
                                <button class="btn btn-sm btn-outline-danger">削除</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">ファイルアップロードテスト</h5>
            </div>
            <div class="card-body">
                <div class="file-upload-area">
                    <i class="bi bi-cloud-upload fs-1 text-muted"></i>
                    <p class="mt-2 mb-0">ファイルをドラッグ&ドロップするか、クリックして選択してください</p>
                    <input type="file" class="form-control mt-3" multiple>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection