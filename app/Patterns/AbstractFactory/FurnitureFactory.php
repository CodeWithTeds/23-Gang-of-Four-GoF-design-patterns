<?php

namespace App\Patterns\AbstractFactory;



/**
 * Abstract Factory
 * its a creational design pattern
 * its let you to product a family of objects
 * without specifying a concrete classes
 * its let create a new group of family without
 * rewriting the whole codebased
 */
interface FurnitureFactory
{
    public function createChair(): Chair;
    public function createSofa(): Sofa;
}
