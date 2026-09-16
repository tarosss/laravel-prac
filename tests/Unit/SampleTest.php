<?php

namespace Tests\Unit;

test('example', function () {
    $page = visit('/a')
        ->click('ここをクリック');
    $page->click('アクリルキーホルダー');
    $page->assertSourceHas('<h1>Welcome</h1>');
});
