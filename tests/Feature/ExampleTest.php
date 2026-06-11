<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the application returns a successful response', function () {
    $response = $this->withHeaders(['Accept-Language' => 'id'])->get('/');

    $response->assertSuccessful();
});
