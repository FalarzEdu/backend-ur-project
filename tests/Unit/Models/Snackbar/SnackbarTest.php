<?php

namespace Tests\Unit\Models;

use App\Models\SnackbarGood;
use Tests\TestCase;

use function PHPUnit\Framework\assertArrayNotHasKey;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class SnackbarTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testShouldCreateASnackbarGood(): void
    {
        $snack = new SnackbarGood(params: [
            'price' => 5.5,
            'description' => 'Coxinha'
        ]);
        assertTrue(condition: $snack->save());

        assertEquals(
            expected: SnackbarGood::findById(id: $snack->id)->id,
            actual: $snack->id
        );
    }

    public function testShouldNotCreateASnackbarGood(): void
    {
        $snack = new SnackbarGood(params: [
            'price' => 5.5,
            'description' => ''
        ]);
        assertFalse(condition: $snack->save());

        assertNull(
            actual: $snack->id
        );
    }

    public function testShouldDesytroyASnackbarGood(): void
    {
        $snack = new SnackbarGood(params: [
            'price' => 5.5,
            'description' => 'Coxinha'
        ]);
        assertTrue(condition: $snack->save());

        assertNotNull(
            actual: SnackbarGood::findById(id: $snack->id)
        );

        assertTrue(condition: $snack->destroy());

        assertNull(
            actual: SnackbarGood::findById(id: $snack->id)
        );
    }

    public function testShouldRunValidations(): void
    {
        $snack = new SnackbarGood(params: [
            'price' => 5.5,
            'description' => ''
        ]);
        $snack->validates();

        assertNotEmpty(actual: $snack->allErrors());
        assertFalse(condition: $snack->save());

        $snack->__set(property: 'price', value: null);
        $snack->__set(property: 'description', value: 'Coxinha');

        $snack->validates();

        assertNotEmpty(actual: $snack->allErrors());
        assertFalse(condition: $snack->save());
    }
}
