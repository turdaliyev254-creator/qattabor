<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Location;
use App\Models\Place;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IshonchTelefonlariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "📞 Creating Ishonch telefonlari (Trust Phone Numbers)...\n";

        // Get the Government organizations category
        $category = Category::where('slug', 'government-organizations')->first();
        
        if (!$category) {
            echo "❌ Government organizations category not found!\n";
            return;
        }

        // Get or create the Ishonch telefonlari subcategory
        $subcategory = Subcategory::firstOrCreate(
            [
                'slug' => 'ishonch-telefonlari',
                'category_id' => $category->id
            ],
            [
                'name' => 'Ishonch telefonlari',
                'slug' => 'ishonch-telefonlari',
                'category_id' => $category->id,
                'icon' => 'phone.png',
            ]
        );

        // Get Toshkent location (or create if not exists)
        $toshkent = Location::firstOrCreate(
            ['slug' => 'toshkent'],
            [
                'name' => 'Toshkent',
                'slug' => 'toshkent',
            ]
        );

        // Ishonch telefonlari data from the PDF
        $organizations = [
            [
                'name' => 'O\'zbekiston Respublikasi Prezidenti huzuridagi Milliy axborot agentligi',
                'phone' => '1010',
                'description' => 'Davlat organlari faoliyatiga doir shikoyat va takliflar uchun ishonch telefoni',
                'working_hours' => '24/7',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Vazirlar Mahkamasi huzuridagi Fuqarolarning murojaatlarini ko\'rib chiqish markazi',
                'phone' => '1177',
                'description' => 'Fuqarolarning murojaatlari va shikoyatlari uchun ishonch telefoni',
                'working_hours' => '24/7',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Adliya vazirligi',
                'phone' => '1007',
                'description' => 'Huquqiy masalalar va adliya xizmatlari bo\'yicha ma\'lumot',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Favqulodda vaziyatlar vazirligi',
                'phone' => '1050',
                'description' => 'Favqulodda vaziyatlar, yong\'in va boshqa hodisalar haqida xabar berish',
                'working_hours' => '24/7',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Ichki ishlar vazirligi',
                'phone' => '1002 / 102',
                'description' => 'Politsiya, xavfsizlik va tartib-intizom masalalari',
                'working_hours' => '24/7',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Iqtisodiy rivojlanish va kambag\'allikni qisqartirish vazirligi',
                'phone' => '1008',
                'description' => 'Iqtisodiy rivojlanish, tadbirkorlik va investitsiyalar bo\'yicha',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Sog\'liqni saqlash vazirligi',
                'phone' => '1003 / 103',
                'description' => 'Tez tibbiy yordam, shifokorlar chaqirish va sog\'liqni saqlash',
                'working_hours' => '24/7',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Tashqi iqtisodiy aloqalar, investitsiyalar va savdo vazirligi',
                'phone' => '1127',
                'description' => 'Xalqaro savdo, investitsiyalar va tashqi iqtisodiy aloqalar',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Transport vazirligi',
                'phone' => '1009',
                'description' => 'Transport xizmatlari, yo\'l harakati va transport infratuzilmasi',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Xalq ta\'limi vazirligi',
                'phone' => '1146',
                'description' => 'Maktabgacha va umumiy o\'rta ta\'lim masalalari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Oliy ta\'lim, fan va innovatsiyalar vazirligi',
                'phone' => '1199',
                'description' => 'Oliy ta\'lim muassasalari, fan va innovatsiyalar',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Madaniyat vazirligi',
                'phone' => '1011',
                'description' => 'Madaniyat, san\'at va merosni saqlash masalalari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Mehnat va aholini ijtimoiy himoya qilish vazirligi',
                'phone' => '1106',
                'description' => 'Mehnat huquqlari, bandlik va ijtimoiy himoya',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Moliya vazirligi',
                'phone' => '1012',
                'description' => 'Moliyaviy masalalar, byudjet va soliqlar',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Prezidenti devonining Davlat xizmati agentligi',
                'phone' => '1013',
                'description' => 'Davlat xizmati va davlat apparati islohotlari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Prezidenti huzuridagi Davlat mulki qo\'mitasi',
                'phone' => '1014',
                'description' => 'Davlat mulki va xususiylashtirish masalalari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Ekologiya, atrof-muhitni muhofaza qilish va iqlim o\'zgarishi vazirligi',
                'phone' => '1155',
                'description' => 'Ekologiya, atrof-muhit va iqlim o\'zgarishi masalalari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Energetika vazirligi',
                'phone' => '1015',
                'description' => 'Energetika, elektr ta\'minoti va energiya tejamkorligi',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Jismoniy tarbiya va sport vazirligi',
                'phone' => '1016',
                'description' => 'Sport, jismoniy tarbiya va sog\'lom turmush tarzi',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Investitsiyalar, sanoat va savdo vazirligi',
                'phone' => '1017',
                'description' => 'Sanoat, savdo va investitsiyalarni rivojlantirish',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Mahalla va oilani qo\'llab-quvvatlash vazirligi',
                'phone' => '1096',
                'description' => 'Mahalla, oila va fuqarolar jamiyati masalalari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Maktabgacha va maktab ta\'limi vazirligi',
                'phone' => '1018',
                'description' => 'Maktabgacha ta\'lim muassasalari va bola parvarishi',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Qishloq xo\'jaligi vazirligi',
                'phone' => '1019',
                'description' => 'Qishloq xo\'jaligi, fermerlik va agrosanoat',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Qurilish va uy-joy kommunal xo\'jaligi vazirligi',
                'phone' => '1005',
                'description' => 'Qurilish, uy-joy va kommunal xizmatlar',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Raqamli texnologiyalar vazirligi',
                'phone' => '1144',
                'description' => 'Raqamli texnologiyalar, IT va innovatsiyalar',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Suv xo\'jaligi vazirligi',
                'phone' => '1020',
                'description' => 'Suv ta\'minoti, kanalizatsiya va suv resurslari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Turizm va sport vazirligi',
                'phone' => '1021',
                'description' => 'Turizm rivojlantirish va mehmonxonalar',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'Davlat xavfsizlik xizmati',
                'phone' => '1004',
                'description' => 'Davlat xavfsizligi va terrorizmga qarshi kurash',
                'working_hours' => '24/7',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Bosh prokuraturasi',
                'phone' => '1022',
                'description' => 'Prokuratura nazorati va huquqbuzarliklar',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Oliy Majlisi Senati',
                'phone' => '1023',
                'description' => 'Senat va qonunchilik organlari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Oliy Majlisi Qonunchilik palatasi',
                'phone' => '1024',
                'description' => 'Qonunchilik palatasi va qonun loyihalari',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'O\'zbekiston Respublikasi Markaziy saylov komissiyasi',
                'phone' => '1098',
                'description' => 'Saylovlar va referendumlar bo\'yicha',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'Toshkent shahar hokimligi',
                'phone' => '1025',
                'description' => 'Toshkent shahar hokimligi va mahalliy boshqaruv',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'Antikorrupsiya agentligi',
                'phone' => '1059',
                'description' => 'Korrupsiyaga qarshi kurash va shikoyatlar',
                'working_hours' => '24/7',
            ],
            [
                'name' => 'Yoshlar ishlari agentligi',
                'phone' => '1026',
                'description' => 'Yoshlar siyosati va yoshlar bilan ishlash',
                'working_hours' => '09:00-18:00',
            ],
            [
                'name' => 'Ayollar va oilani qo\'llab-quvvatlash bo\'yicha komissiya',
                'phone' => '1027',
                'description' => 'Ayollar huquqlari va oila muammolari',
                'working_hours' => '09:00-18:00',
            ],
        ];

        $count = 0;
        foreach ($organizations as $orgData) {
            $place = Place::firstOrCreate(
                [
                    'slug' => Str::slug($orgData['name']),
                ],
                [
                    'name' => $orgData['name'],
                    'slug' => Str::slug($orgData['name']),
                    'description' => $orgData['description'],
                    'phone' => $orgData['phone'],
                    'category_id' => $category->id,
                    'subcategory_id' => $subcategory->id,
                    'location_id' => $toshkent->id,
                    'working_hours' => $orgData['working_hours'],
                    'rating' => 5.0,
                    'is_popular' => true,
                    'address' => 'Toshkent, O\'zbekiston',
                ]
            );
            $count++;
            echo "  ✓ {$place->name} ({$place->phone})\n";
        }

        echo "\n✅ Created {$count} Ishonch telefonlari organizations\n";
    }
}
