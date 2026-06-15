<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Tidak bergantung pada aset Vite yang sudah di-build saat pengujian.
        $this->withoutVite();
    }
}
