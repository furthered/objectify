<?php

use Objectify\Objectify;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class ObjectifyTest extends PHPUnit_Framework_TestCase {

    /** @test */
    public function it_can_create_a_fluent_object_from_an_array()
    {
        $data = [
            'test'  => 'one',
            'other' => 'two',
            'third' => 'three',
        ];

        $converted = (new Objectify())->make($data);

        $this->assertInstanceOf('Illuminate\Support\Fluent', $converted);
    }

    /** @test */
    public function it_can_create_a_fluent_object_from_an_object()
    {
        $data = new StdClass([
            'test'  => 'one',
            'other' => 'two',
            'third' => 'three',
        ]);

        $converted = (new Objectify())->make($data);

        $this->assertInstanceOf('Illuminate\Support\Fluent', $converted);
    }

    /** @test */
    public function it_can_create_a_collection()
    {
        $data = [
            [
                'test'  => 'one',
                'other' => 'two',
                'third' => 'three',
            ]
        ];

        $converted = (new Objectify())->make($data);

        $this->assertInstanceOf('Illuminate\Support\Collection', $converted);
    }

    /** @test */
    public function it_can_create_a_mixed_collection()
    {
        $data = [
            [
                'test'  => 'one',
                'other' => 'two',
                'third' => 'three',
                'fourth' => [
                    'an' => 'associative array'
                ],
            ]
        ];

        $converted = (new Objectify())->make($data);

        $this->assertInstanceOf('Illuminate\Support\Collection', $converted);
        $this->assertInstanceOf('Illuminate\Support\Fluent', $converted->first());
    }

    /** @test */
    public function it_can_create_a_nested_mixed_collection()
    {
        $data = [
            [
                'test'  => 'one',
                'other' => 'two',
                'third' => 'three',
                'fourth' => [
                    'an' => 'associative array'
                ],
                'fifth' => [
                    'oh hey',
                    'this too',
                    'what',
                ],
            ],
        ];

        $converted = (new Objectify())->make($data);

        $this->assertInstanceOf('Illuminate\Support\Collection', $converted);

        $first = $converted->first();
        $this->assertInstanceOf('Illuminate\Support\Fluent', $first);

        $this->assertInstanceOf('Illuminate\Support\Fluent', $first->fourth);
        $this->assertInstanceOf('Illuminate\Support\Collection', $first->fifth);
    }

}
