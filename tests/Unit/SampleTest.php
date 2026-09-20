<?php

namespace Tests\Unit;

// test('example100', function () {
//     session(['mkelmclka;smlcl;aslc;sm' => 10]);
//     $page = visit('/a');
//     session(['second' => 10]);

//     $page->click('ここをクリック');

//     $page->assertPathBeginsWith('/wel');
// });

test('example100', function () {
    $page = visit('/a')
        ->pressAndWaitFor('印刷', 5)
        ->screenshot()
        ->radio('body_material', '1')
        ->screenshot();
});

// test('example100', function () {
//     $page = visit('/a')
//         ->pressAndWaitFor('ここをクリック')
//         ->screenshot();
// });
