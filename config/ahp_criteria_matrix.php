<?php

return [

    // urutan label harus sama dengan urutan matrix
    'labels' => [
        'solved_ratio',
        'avg_sla_score',
        'avg_rating',
    ],

    // contoh matrix pairwise AHP (kamu bisa ubah)
    // Interpretasi:
    // solved_ratio 3x lebih penting dari avg_sla_score, 5x dari avg_rating
    'matrix' => [
        [1,   3,   5],
        [1/3, 1,   3],
        [1/5, 1/3, 1],
    ],
];