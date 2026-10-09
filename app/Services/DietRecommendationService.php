<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\User;

class DietRecommendationService
{
    public function __construct(
        protected DecisionTreeService $decisionTree,
        protected RuleBasedService $ruleBased
    ) {
    }

    public function forUser(User $user, float $targetKkal, int $usia): array
    {
        if (
            $user->glukosa_darah === null ||
            $user->tekanan_darah_sistolik === null ||
            $user->kolesterol === null
        ) {
            return ['status' => 'data_klinis_kosong'];
        }

        $kategoriDiet = $this->decisionTree->classify(
            (float) $user->glukosa_darah,
            (float) $user->tekanan_darah_sistolik,
            (float) $user->kolesterol,
            $usia
        );

        if (! $kategoriDiet) {
            return ['status' => 'kategori_tidak_ditemukan'];
        }

        $tujuanDiet = in_array($user->defisit, ['Menurunkan', 'Menaikkan'])
            ? $user->defisit
            : 'Stabil';

        $hasil = $this->ruleBased->recommend($kategoriDiet, $tujuanDiet, $targetKkal);

        $mealPlan = $hasil['meal_plan'];
        $portions = $mealPlan
            ? $mealPlan->portions()->orderBy('id')->get()
            : collect();

        return [
            'status' => 'ok',
            'kategori_diet' => $kategoriDiet,
            'tujuan_diet' => $tujuanDiet,
            'meal_plan' => $mealPlan,
            'rule' => $hasil['rule'],
            'portions' => $portions,
            'menu_contoh' => $this->sampleMenus($user, $portions),
        ];
    }

    protected function sampleMenus(User $user, $portions): array
    {
        $diseaseIds = $user->diseases()->pluck('diseases.id');
        $seedBase = $user->id . now()->toDateString();

        $result = [];

        foreach ($portions as $portion) {
            $query = Menu::where('kategori', $portion->kategori_menu);

            if ($diseaseIds->isNotEmpty()) {
                $query->whereDoesntHave('diseases', function ($q) use ($diseaseIds) {
                    $q->whereIn('diseases.id', $diseaseIds);
                });
            }

            $result[$portion->id] = $query->get()
                ->sortBy(fn ($menu) => crc32($seedBase . $menu->kode_menu))
                ->take(4)
                ->pluck('nama_menu')
                ->values()
                ->all();
        }

        return $result;
    }
}
