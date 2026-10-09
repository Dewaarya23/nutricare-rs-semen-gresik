<?php

namespace App\Services;

use App\Models\RuleDecisionTree;

class DecisionTreeService
{
    public function classify(
        float $glukosaDarah,
        float $tekananDarahSistolik,
        float $kolesterol,
        int $usia
    ): ?string {
        $params = [
            'glukosa_darah' => $glukosaDarah,
            'tekanan_darah_sistolik' => $tekananDarahSistolik,
            'kolesterol' => $kolesterol,
            'usia' => $usia,
        ];

        $groups = RuleDecisionTree::orderBy('rule_group')
            ->orderBy('urutan')
            ->get()
            ->groupBy('rule_group');

        foreach ($groups as $conditions) {
            if ($this->groupMatches($conditions, $params)) {
                return $conditions->first()->kategori_diet;
            }
        }

        return null;
    }

    protected function groupMatches($conditions, array $params): bool
    {
        foreach ($conditions as $condition) {
            $value = $params[$condition->parameter] ?? null;

            if ($value === null) {
                return false;
            }

            $matches = match ($condition->operator) {
                '<=' => $value <= $condition->threshold,
                '>' => $value > $condition->threshold,
                default => false,
            };

            if (! $matches) {
                return false;
            }
        }

        return true;
    }
}
