<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuleDecisionTree;

class RuleDecisionTreeSeeder extends Seeder
{
    public function run(): void
    {
        RuleDecisionTree::truncate();

        $rules = [
            // Rule Group 1: Diet Normal
            // Glukosa <=113.5 AND TD Sistolik <=129 AND Kolesterol <=197.5
            [
                ['parameter' => 'glukosa_darah', 'operator' => '<=', 'threshold' => 113.5],
                ['parameter' => 'tekanan_darah_sistolik', 'operator' => '<=', 'threshold' => 129],
                ['parameter' => 'kolesterol', 'operator' => '<=', 'threshold' => 197.5],
            ],

            // Rule Group 2: Diet Jantung Hipertensi
            // Glukosa <=113.5 AND TD Sistolik <=129 AND Kolesterol >197.5
            [
                ['parameter' => 'glukosa_darah', 'operator' => '<=', 'threshold' => 113.5],
                ['parameter' => 'tekanan_darah_sistolik', 'operator' => '<=', 'threshold' => 129],
                ['parameter' => 'kolesterol', 'operator' => '>', 'threshold' => 197.5],
            ],

            // Rule Group 3: Diet Hipertensi Esensial
            // Glukosa <=113.5 AND TD Sistolik >129 AND Kolesterol <=200
            [
                ['parameter' => 'glukosa_darah', 'operator' => '<=', 'threshold' => 113.5],
                ['parameter' => 'tekanan_darah_sistolik', 'operator' => '>', 'threshold' => 129],
                ['parameter' => 'kolesterol', 'operator' => '<=', 'threshold' => 200],
            ],

            // Rule Group 4: Diet Jantung Hipertensi
            // Glukosa <=113.5 AND TD Sistolik >129 AND Kolesterol >200
            [
                ['parameter' => 'glukosa_darah', 'operator' => '<=', 'threshold' => 113.5],
                ['parameter' => 'tekanan_darah_sistolik', 'operator' => '>', 'threshold' => 129],
                ['parameter' => 'kolesterol', 'operator' => '>', 'threshold' => 200],
            ],

            // Rule Group 5: Diet Normal (dominan, meski glukosa tinggi)
            // Glukosa >113.5 AND Usia <=44.5
            [
                ['parameter' => 'glukosa_darah', 'operator' => '>', 'threshold' => 113.5],
                ['parameter' => 'usia', 'operator' => '<=', 'threshold' => 44.5],
            ],

            // Rule Group 6: Diet Diabetes Melitus
            // Glukosa >113.5 AND Usia >44.5
            [
                ['parameter' => 'glukosa_darah', 'operator' => '>', 'threshold' => 113.5],
                ['parameter' => 'usia', 'operator' => '>', 'threshold' => 44.5],
            ],
        ];

        $kategoriPerGroup = [
            1 => 'Diet Normal',
            2 => 'Diet Jantung Hipertensi',
            3 => 'Diet Hipertensi Esensial',
            4 => 'Diet Jantung Hipertensi',
            5 => 'Diet Normal',
            6 => 'Diet Diabetes Melitus',
        ];

        foreach ($rules as $index => $conditions) {
            $ruleGroup = $index + 1;

            foreach ($conditions as $urutan => $condition) {
                RuleDecisionTree::create([
                    'rule_group' => $ruleGroup,
                    'urutan' => $urutan + 1,
                    'parameter' => $condition['parameter'],
                    'operator' => $condition['operator'],
                    'threshold' => $condition['threshold'],
                    'kategori_diet' => $kategoriPerGroup[$ruleGroup],
                ]);
            }
        }
    }
}
