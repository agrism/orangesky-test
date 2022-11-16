<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @dataProvider successDataProvider
     */
    public function testSuccess(float $operandOne, float $operandTwo, string $operator, float $expected): void
    {
        $r = $this->post('api', [
            'operandOne' => $operandOne,
            'operandTwo' => $operandTwo,
            'operator' => $operator,
        ])->assertStatus(200)
            ->assertJsonStructure(['result', 'history'])
            ->assertJson(['result' => $expected]);

        $this->assertEquals($expected, json_decode($r->getContent(), true)['result']);
    }

    public function successDataProvider(): array
    {
        return [
            [1, 1, '+', 2],
            [0, 0, '-', 0],
            [0, 0, '*', 0],
            [10, 2, '/', 5],
            [11, 3.1, '/', 3.54839],
            [1000000000000, 1000000000000, '+', 2000000000000],
        ];
    }

    /**
     * A basic feature test example.
     *
     * @dataProvider failDataProvider
     */
    public function testFail(float $operandOne, float $operandTwo, string $operator): void
    {
        $this->post('api', [
            'operandOne' => $operandOne,
            'operandTwo' => $operandTwo,
            'operator' => $operator,
        ])->assertNoContent(400);
    }

    public function failDataProvider(): array
    {
        return [
            [1, 0, '/'],
            [1, 0, ''],
            [1, 0, '2'],
            [1, 0, '2'],
            [1, 0, '++'],
        ];
    }
}
