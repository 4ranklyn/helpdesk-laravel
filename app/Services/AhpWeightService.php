<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class AhpWeightService
{
    public function getWeights()
    {
        return Cache::rememberForever('ahp_calculated_weights', function () {
            return $this->calculateWeightsFromMatrix();
        });
    }

    public function clearCache()
    {
        Cache::forget('ahp_calculated_weights');
    }

    private function calculateWeightsFromMatrix()
    {
        $matrixConfig = Config::get('ahp_criteria_matrix');
        
        // Default fallback if config is missing
        if (!$matrixConfig) {
            return ['solved_ratio' => 0.50, 'avg_sla_score' => 0.30, 'avg_rating' => 0.20];
        }

        $matrix = $matrixConfig['matrix'];
        $labels = $matrixConfig['labels'];
        $n = count($matrix);

        // 1. Sum Columns
        $colSums = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $colSums[$j] += $matrix[$i][$j];
            }
        }

        // 2. Normalize & Calculate Weights
        $weights = [];
        for ($i = 0; $i < $n; $i++) {
            $rowSumNormalized = 0;
            for ($j = 0; $j < $n; $j++) {
                $rowSumNormalized += ($matrix[$i][$j] / $colSums[$j]);
            }
            $weights[$labels[$i]] = $rowSumNormalized / $n;
        }

        return $weights;
    }
}