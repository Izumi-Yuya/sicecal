<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\Department;
use App\Models\Region;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 組織図ヒアリング資料に基づいて全施設を登録
     */
    public function run(): void
    {
        // Get department IDs
        $facilityDept = Department::where('name', '有料老人ホーム')->first();
        $groupHomeDept = Department::where('name', 'グループホーム')->first();
        $dayServiceDept = Department::where('name', 'デイサービスセンター')->first();
        $carePlanDept = Department::where('name', 'ケアプランセンター')->first();
        $nursingDept = Department::where('name', '訪問看護ステーション')->first();
        $helperDept = Department::where('name', 'ヘルパーステーション')->first();
        $otherDept = Department::where('name', '他（事務所など）')->first();

        $eastRegion = Region::where('name', '東日本')->first();
        $westRegion = Region::where('name', '西日本')->first();

        // 組織図データに基づく全施設
        $facilities = [
            // 有料老人ホーム（ラ・ナシカ）
            ['facility_code' => '20101', 'name' => 'ラ・ナシカ　ていね', 'prefecture' => '北海道', 'city' => '札幌市手稲区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '20111', 'name' => 'ラ・ナシカ　あさり', 'prefecture' => '北海道', 'city' => '札幌市厚別区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '20121', 'name' => 'ラ・ナシカ　あさひかわ', 'prefecture' => '北海道', 'city' => '旭川市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '20401', 'name' => 'ラ・ナシカ　せんだい', 'prefecture' => '宮城県', 'city' => '仙台市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '20501', 'name' => 'ラ・ナシカ　あきた', 'prefecture' => '秋田県', 'city' => '秋田市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '20801', 'name' => 'ラ・ナシカ　ひたちなか', 'prefecture' => '茨城県', 'city' => 'ひたちなか市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '20901', 'name' => 'ラ・ナシカ　あしかが', 'prefecture' => '栃木県', 'city' => '足利市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21101', 'name' => 'ラ・ナシカ　みさと', 'prefecture' => '埼玉県', 'city' => '三郷市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21111', 'name' => 'ラ・ナシカ　さいたま', 'prefecture' => '埼玉県', 'city' => 'さいたま市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21201', 'name' => 'ラ・ナシカ　あすみが丘', 'prefecture' => '千葉県', 'city' => '千葉市緑区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21202', 'name' => 'ラ・ナシカ　たかしな', 'prefecture' => '千葉県', 'city' => '柏市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21203', 'name' => 'ラ・ナシカ　こぶけ', 'prefecture' => '千葉県', 'city' => '印西市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21211', 'name' => 'ラ・ナシカ　さくら', 'prefecture' => '千葉県', 'city' => '佐倉市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21301', 'name' => 'ラ・ナシカ　こまつがわ', 'prefecture' => '東京都', 'city' => '江戸川区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21401', 'name' => 'ラ・ナシカ　よこすか', 'prefecture' => '神奈川県', 'city' => '横須賀市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21402', 'name' => 'ラ・ナシカ　よこすか弐番館', 'prefecture' => '神奈川県', 'city' => '横須賀市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21411', 'name' => 'ラ・ナシカ　上大岡', 'prefecture' => '神奈川県', 'city' => '横浜市港南区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '21901', 'name' => 'ラ・ナシカ　こうふ', 'prefecture' => '山梨県', 'city' => '甲府市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22001', 'name' => 'ラ・ナシカ　ちの', 'prefecture' => '長野県', 'city' => '茅野市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22011', 'name' => 'ラ・ナシカ　うえだ', 'prefecture' => '長野県', 'city' => '上田市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22021', 'name' => 'ラ・ナシカ　まつもと', 'prefecture' => '長野県', 'city' => '松本市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22022', 'name' => 'ラ・ナシカ　まつもと弐番館', 'prefecture' => '長野県', 'city' => '松本市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22201', 'name' => 'ラ・ナシカ　しまだ', 'prefecture' => '静岡県', 'city' => '島田市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22211', 'name' => 'ラ・ナシカ　三保の松原', 'prefecture' => '静岡県', 'city' => '静岡市清水区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22301', 'name' => 'ラ・ナシカ　あらこがわ', 'prefecture' => '愛知県', 'city' => '名古屋市港区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22701', 'name' => 'ラ・ナシカ　つるみ', 'prefecture' => '大阪府', 'city' => '大阪市鶴見区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22702', 'name' => 'ラ・ナシカ　すみのえ', 'prefecture' => '大阪府', 'city' => '大阪市住之江区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22703', 'name' => 'ラ・ナシカ　このはな', 'prefecture' => '大阪府', 'city' => '大阪市此花区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '22711', 'name' => 'ラ・ナシカ　かみいし', 'prefecture' => '大阪府', 'city' => '富田林市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '23201', 'name' => 'ラ・ナシカ　こうざい', 'prefecture' => '島根県', 'city' => '江津市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '23301', 'name' => 'ラ・ナシカ　もりまつ', 'prefecture' => '愛媛県', 'city' => '松山市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '23701', 'name' => 'ラ・ナシカ　くらしき', 'prefecture' => '岡山県', 'city' => '倉敷市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '23711', 'name' => 'ラ・ナシカ　くにとみ', 'prefecture' => '岡山県', 'city' => '総社市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '24001', 'name' => 'ラ・ナシカ　ふじまつ', 'prefecture' => '福岡県', 'city' => '北九州市小倉北区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '24002', 'name' => 'ラ・ナシカ　こくら', 'prefecture' => '福岡県', 'city' => '北九州市小倉南区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '24011', 'name' => 'ラ・ナシカ　みとま', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '24012', 'name' => 'ラ・ナシカ　ちはや', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '24021', 'name' => 'ラ・ナシカ　おとがな', 'prefecture' => '福岡県', 'city' => '福岡市西区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],

            // グループホーム
            ['facility_code' => '31301', 'name' => 'グループホーム小松川', 'prefecture' => '東京都', 'city' => '江戸川区', 'business_type' => 'グループホーム', 'department_id' => $groupHomeDept?->id],
            ['facility_code' => '34001', 'name' => 'グループホーム黒崎', 'prefecture' => '福岡県', 'city' => '北九州市八幡西区', 'business_type' => 'グループホーム', 'department_id' => $groupHomeDept?->id],

            // パイン系有料老人ホーム
            ['facility_code' => '90101', 'name' => '麻生の郷', 'prefecture' => '神奈川県', 'city' => '川崎市麻生区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '91101', 'name' => '武蔵野の郷', 'prefecture' => '埼玉県', 'city' => '所沢市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '91111', 'name' => 'わらび 花の郷', 'prefecture' => '埼玉県', 'city' => '蕨市', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '91401', 'name' => '靎見の鄕', 'prefecture' => '神奈川県', 'city' => '横浜市鶴見区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '94001', 'name' => '小文字の郷', 'prefecture' => '福岡県', 'city' => '北九州市小倉北区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],
            ['facility_code' => '94011', 'name' => 'わじろの郷', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => '有料老人ホーム', 'department_id' => $facilityDept?->id],

            // デイサービスセンター（あおぞらの里）
            ['facility_code' => '10901', 'name' => 'あおぞらの里　御幸ヶ原デイサービスセンター', 'prefecture' => '栃木県', 'city' => '宇都宮市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11201', 'name' => 'あおぞらの里　八千代デイサービスセンター', 'prefecture' => '千葉県', 'city' => '八千代市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11211', 'name' => 'あおぞらの里　薬円台デイサービスセンター', 'prefecture' => '千葉県', 'city' => '船橋市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11221', 'name' => 'あおぞらの里　花見川デイサービスセンター', 'prefecture' => '千葉県', 'city' => '千葉市花見川区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11231', 'name' => 'あおぞらの里　六高台デイサービスセンター', 'prefecture' => '千葉県', 'city' => '松戸市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11232', 'name' => 'あおぞらの里　馬橋デイサービスセンター', 'prefecture' => '千葉県', 'city' => '松戸市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11241', 'name' => 'あおぞらの里　鎌ケ谷デイサービスセンター', 'prefecture' => '千葉県', 'city' => '鎌ケ谷市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11251', 'name' => 'あおぞらの里　新柏デイサービスセンター', 'prefecture' => '千葉県', 'city' => '柏市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11301', 'name' => 'あおぞらの里　小松川デイサービスセンター', 'prefecture' => '東京都', 'city' => '江戸川区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11901', 'name' => 'あおぞらの里　甲府デイサービスセンター', 'prefecture' => '山梨県', 'city' => '甲府市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '11902', 'name' => 'あおぞらの里　甲府南デイサービスセンター', 'prefecture' => '山梨県', 'city' => '甲府市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '12001', 'name' => 'あおぞらの里　上田原デイサービスセンター', 'prefecture' => '長野県', 'city' => '上田市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '12301', 'name' => 'あおぞらの里　小牧デイサービスセンター', 'prefecture' => '愛知県', 'city' => '小牧市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '13301', 'name' => 'あおぞらの里　森松デイサービスセンター', 'prefecture' => '愛媛県', 'city' => '松山市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '13901', 'name' => 'あおぞらの里　下関デイサービスセンター', 'prefecture' => '山口県', 'city' => '下関市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '13902', 'name' => 'あおぞらの里　下関幡生デイサービスセンター', 'prefecture' => '山口県', 'city' => '下関市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14001', 'name' => 'あおぞらの里　小文字デイサービスセンター', 'prefecture' => '福岡県', 'city' => '北九州市小倉北区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14003', 'name' => 'あおぞらの里　徳力デイサービスセンター', 'prefecture' => '福岡県', 'city' => '北九州市小倉南区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14005', 'name' => 'あおぞらの里　戸ノ上デイサービスセンター', 'prefecture' => '福岡県', 'city' => '北九州市小倉南区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14006', 'name' => 'あおぞらの里　黒崎デイサービスセンター', 'prefecture' => '福岡県', 'city' => '北九州市八幡西区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14007', 'name' => 'あおぞらの里　鳴水デイサービスセンター', 'prefecture' => '福岡県', 'city' => '北九州市小倉南区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14021', 'name' => 'あおぞらの里　香住ヶ丘デイサービスセンター', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14022', 'name' => 'あおぞらの里　和白デイサービスセンター', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14023', 'name' => 'あおぞらの里　舞松原デイサービスセンター', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14024', 'name' => 'あおぞらの里　福岡西デイサービスセンター', 'prefecture' => '福岡県', 'city' => '福岡市西区', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14041', 'name' => 'あおぞらの里　古賀デイサービスセンター', 'prefecture' => '福岡県', 'city' => '古賀市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14051', 'name' => 'あおぞらの里　行橋デイサービスセンター', 'prefecture' => '福岡県', 'city' => '行橋市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14061', 'name' => 'あおぞらの里　豊前デイサービスセンター', 'prefecture' => '福岡県', 'city' => '豊前市', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],
            ['facility_code' => '14301', 'name' => 'あおぞらの里　西原デイサービスセンター', 'prefecture' => '沖縄県', 'city' => '中頭郡西原町', 'business_type' => 'デイサービス', 'department_id' => $dayServiceDept?->id],

            // 訪問看護ステーション
            ['facility_code' => '41201', 'name' => 'あおぞらの里　花見川訪問看護ステーション', 'prefecture' => '千葉県', 'city' => '千葉市花見川区', 'business_type' => '訪問看護', 'department_id' => $nursingDept?->id],
            ['facility_code' => '43901', 'name' => 'あおぞらの里 　関訪問看護ステーション', 'prefecture' => '岐阜県', 'city' => '関市', 'business_type' => '訪問看護', 'department_id' => $nursingDept?->id],
            ['facility_code' => '44001', 'name' => 'あおぞらの里　小文字訪問看護ステ－ション', 'prefecture' => '福岡県', 'city' => '北九州市小倉北区', 'business_type' => '訪問看護', 'department_id' => $nursingDept?->id],
            ['facility_code' => '44011', 'name' => 'あおぞらの里　和白訪問看護ステーション', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => '訪問看護', 'department_id' => $nursingDept?->id],
            ['facility_code' => '44021', 'name' => 'あおぞらの里　古賀訪問看護ステーション', 'prefecture' => '福岡県', 'city' => '古賀市', 'business_type' => '訪問看護', 'department_id' => $nursingDept?->id],
            ['facility_code' => '44031', 'name' => 'あおぞらの里　行橋訪問看護ステーション', 'prefecture' => '福岡県', 'city' => '行橋市', 'business_type' => '訪問看護', 'department_id' => $nursingDept?->id],
            ['facility_code' => '44041', 'name' => 'あおぞらの里　水巻訪問看護ステーション', 'prefecture' => '福岡県', 'city' => '遠賀郡水巻町', 'business_type' => '訪問看護', 'department_id' => $nursingDept?->id],

            // ヘルパーステーション
            ['facility_code' => '54001', 'name' => 'あおぞらの里　小文字ヘルパーステ－ション', 'prefecture' => '福岡県', 'city' => '北九州市小倉北区', 'business_type' => 'ヘルパーステーション', 'department_id' => $helperDept?->id],
            ['facility_code' => '54011', 'name' => 'あおぞらの里　和白ヘルパーステーション', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => 'ヘルパーステーション', 'department_id' => $helperDept?->id],
            ['facility_code' => '54021', 'name' => 'あおぞらの里　行橋ヘルパーステーション', 'prefecture' => '福岡県', 'city' => '行橋市', 'business_type' => 'ヘルパーステーション', 'department_id' => $helperDept?->id],

            // ケアプランセンター
            ['facility_code' => '60901', 'name' => 'あおぞらの里　御幸ヶ原ケアプランセンター', 'prefecture' => '栃木県', 'city' => '宇都宮市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '61201', 'name' => 'あおぞらの里　薬円台ケアプランセンター', 'prefecture' => '千葉県', 'city' => '船橋市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '61211', 'name' => 'あおぞらの里　六高台ケアプランセンター', 'prefecture' => '千葉県', 'city' => '松戸市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '61212', 'name' => 'あおぞらの里　馬橋ケアプランセンター', 'prefecture' => '千葉県', 'city' => '松戸市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '61221', 'name' => 'あおぞらの里　八千代ケアプランセンター', 'prefecture' => '千葉県', 'city' => '八千代市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '61231', 'name' => 'あおぞらの里　鎌ケ谷ケアプランセンター', 'prefecture' => '千葉県', 'city' => '鎌ケ谷市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '61241', 'name' => 'あおぞらの里　花見川アプランセンター', 'prefecture' => '千葉県', 'city' => '千葉市花見川区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '61251', 'name' => 'あおぞらの里　逆井ケアプランセンター', 'prefecture' => '千葉県', 'city' => '柏市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '62301', 'name' => 'あおぞらの里　小牧ケアプランセンター', 'prefecture' => '愛知県', 'city' => '小牧市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '63301', 'name' => 'あおぞらの里　森松ケアプランセンター', 'prefecture' => '愛媛県', 'city' => '松山市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '63901', 'name' => 'あおぞらの里　下関ケアプランセンター', 'prefecture' => '山口県', 'city' => '下関市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '63902', 'name' => 'あおぞらの里　西の端ケアプランセンター', 'prefecture' => '山口県', 'city' => '下関市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64001', 'name' => 'あおぞらの里　小文字ケアプランセンター', 'prefecture' => '福岡県', 'city' => '北九州市小倉北区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64002', 'name' => 'あおぞらの里　黒崎ケアプランセンター', 'prefecture' => '福岡県', 'city' => '北九州市八幡西区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64003', 'name' => 'あおぞらの里　徳力ケアプランセンター', 'prefecture' => '福岡県', 'city' => '北九州市小倉南区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64011', 'name' => 'あおぞらの里　和白ケアプランセンター', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64012', 'name' => 'あおぞらの里　福岡西ケアプランセンター', 'prefecture' => '福岡県', 'city' => '福岡市西区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64014', 'name' => 'あおぞらの里　舞松原ケアプランセンター', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64015', 'name' => 'あおぞらの里　香住ケ丘ケアプランセンター', 'prefecture' => '福岡県', 'city' => '福岡市東区', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64021', 'name' => 'あおぞらの里　行橋ケアプランセンター', 'prefecture' => '福岡県', 'city' => '行橋市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64031', 'name' => 'あおぞらの里　豊前ケアプランセンター', 'prefecture' => '福岡県', 'city' => '豊前市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64041', 'name' => 'あおぞらの里　古賀ケアプランセンター', 'prefecture' => '福岡県', 'city' => '古賀市', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],
            ['facility_code' => '64301', 'name' => 'あおぞらの里　西原ケアプランセンター', 'prefecture' => '沖縄県', 'city' => '中頭郡西原町', 'business_type' => 'ケアプラン', 'department_id' => $carePlanDept?->id],

            // 事務所・その他
            ['facility_code' => '00001', 'name' => '本社（オフィス）', 'prefecture' => '東京都', 'city' => '千代田区', 'business_type' => '事務所', 'department_id' => $otherDept?->id],
            ['facility_code' => '00002', 'name' => '関東本部（オフィス）', 'prefecture' => '東京都', 'city' => '新宿区', 'business_type' => '事務所', 'department_id' => $otherDept?->id],
            ['facility_code' => '90012', 'name' => '福祉事業部（オフィス）', 'prefecture' => '福岡県', 'city' => '福岡市', 'business_type' => '事務所', 'department_id' => $otherDept?->id],
            ['facility_code' => '90020', 'name' => '就労支援事業部（コインランドリー）', 'prefecture' => '福岡県', 'city' => '福岡市', 'business_type' => 'その他', 'department_id' => $otherDept?->id],
            ['facility_code' => '39001', 'name' => 'ライフサポート なださき', 'prefecture' => '長崎県', 'city' => '長崎市', 'business_type' => 'その他', 'department_id' => $otherDept?->id],
        ];

        foreach ($facilities as $facility) {
            // デフォルト値を設定
            $facilityData = array_merge([
                'postal_code' => null,
                'address' => $facility['prefecture'] . $facility['city'],
                'phone_number' => null,
                'fax_number' => null,
                'opening_date' => null,
                'capacity' => null,
                'floor_area' => null,
                'building_structure' => null,
                'construction_year' => null,
                'land_ownership' => null,
                'building_ownership' => null,
                'lease_start_date' => null,
                'lease_end_date' => null,
                'lease_monthly_rent' => null,
                'management_company' => null,
                'fire_insurance_company' => null,
                'fire_insurance_start_date' => null,
                'fire_insurance_end_date' => null,
                'earthquake_insurance_company' => null,
                'earthquake_insurance_start_date' => null,
                'earthquake_insurance_end_date' => null,
                'region_id' => null,
                'status' => 'active'
            ], $facility);

            Facility::firstOrCreate(
                ['facility_code' => $facility['facility_code']],
                $facilityData
            );
        }
    }
}