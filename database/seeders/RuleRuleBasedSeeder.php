<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MealPlan;
use App\Models\RuleRuleBased;

class RuleRuleBasedSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            'Diet Normal' => [
                'anjuran' => 'Variasi makanan bergizi seimbang, konsumsi sayur dan buah setiap hari',
                'pantangan' => 'Tidak ada pantangan khusus, tetap batasi makanan tinggi lemak dan gula berlebih',
                'menu' => 'Menu seimbang :kkal kkal: nasi/karbohidrat kompleks, protein hewani & nabati, sayur, dan buah',
            ],
            'Diet Diabetes Melitus' => [
                'anjuran' => 'Karbohidrat kompleks, serat minimal 20g, protein rendah lemak, sayur tidak bertepung',
                'pantangan' => 'Gula sederhana, sirup, kue manis, minuman bersoda, nasi putih berlebih, gorengan',
                'menu' => 'Menu diabetes :kkal kkal: karbohidrat kompleks terkontrol, protein rendah lemak, sayur tinggi serat',
            ],
            'Diet Hipertensi Esensial' => [
                'anjuran' => 'Pola makan DASH: buah, sayur, biji-bijian utuh, sumber protein rendah lemak, kalium & kalsium cukup',
                'pantangan' => 'Natrium dibatasi maksimal 2.000 mg/hari, makanan asin, kecap, saus, penyedap tinggi natrium',
                'menu' => 'Menu DASH :kkal kkal: rendah natrium, tinggi kalium dan serat',
            ],
            'Diet Jantung Hipertensi' => [
                'anjuran' => 'Ikan laut, minyak zaitun, serat minimal 25g, kacang-kacangan dan biji-bijian',
                'pantangan' => 'Natrium maksimal 2.000 mg/hari, kolesterol <200 mg/hari, lemak jenuh, jeroan, ikan asin, gorengan, santan kental',
                'menu' => 'Menu jantung :kkal kkal: rendah natrium & lemak jenuh, tinggi serat dan lemak tak jenuh',
            ],
        ];

        $tujuanLabel = [
            'Menurunkan' => 'menurunkan berat badan',
            'Stabil' => 'mempertahankan berat badan',
            'Menaikkan' => 'menaikkan berat badan',
        ];

        $mealPlans = MealPlan::orderBy('target_energi')->get();

        if ($mealPlans->isEmpty()) {
            $this->command->warn('Meal plans kosong. Jalankan MealPlanSeeder dulu sebelum seeder ini.');
            return;
        }

        RuleRuleBased::truncate();

        foreach ($templates as $kategoriDiet => $template) {
            foreach ($tujuanLabel as $tujuanDiet => $labelTujuan) {
                foreach ($mealPlans as $mealPlan) {

                    $kkal = (int) $mealPlan->target_energi;

                    $rekomendasiMenu = str_replace(':kkal', $kkal, $template['menu'])
                        . ", dengan tujuan {$labelTujuan}";

                    RuleRuleBased::create([
                        'kategori_diet' => $kategoriDiet,
                        'tujuan_diet' => $tujuanDiet,
                        'meal_plan_id' => $mealPlan->id,
                        'rekomendasi_menu' => $rekomendasiMenu,
                        'anjuran' => $template['anjuran'],
                        'pantangan' => $template['pantangan'],
                    ]);
                }
            }
        }
    }
}
