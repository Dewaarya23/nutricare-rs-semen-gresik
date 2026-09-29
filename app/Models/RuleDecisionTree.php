<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleDecisionTree extends Model
{
    protected $table = 'rules_decision_tree';

    protected $fillable = [
        'rule_group',
        'urutan',
        'parameter',
        'operator',
        'threshold',
        'kategori_diet',
    ];
}
