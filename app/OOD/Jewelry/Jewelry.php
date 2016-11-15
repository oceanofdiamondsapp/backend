<?php

namespace OOD\Jewelry;

class Jewelry
{
    protected static $images = [
        '3935.jpg',
        '4333.jpg',
        '4613.jpg',
        '5003.jpg',
        '7093.jpg',
        '7095.jpg',
        '8034.jpg',
        '8051.jpg',
        '8052-8053.jpg',
        '8052.jpg',
        '8054.jpg',
        '8055.jpg',
        '8133.jpg',
        '8309.jpg',
        '8475.jpg',
        '8910.jpg',
        '8911.jpg',
        '9013.jpg',
        '9087.jpg',
        'Bra01.jpg',
        'Ear01.jpg',
        'JNeck.jpg',
        'Monogram.jpg',
        'New2.jpg',
        'StkRg01.jpg',
    ];

    public function image()
    {
        $randomKey = array_rand(static::$images);

        return '/img/jewelry/' . static::$images[$randomKey];
    }
}
