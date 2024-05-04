<?php

namespace App\Tests\Entity;

use App\Entity\Ingredient;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IngredientTest extends KernelTestCase
{
    public function testEntity()
    {
        $ingredient = new Ingredient();
        $ingredient->setName(1);
        
       $this->assertIsString($ingredient->getName(), "error h");
    }

    public function assertHasError(Ingredient $ingredient,int $number = 0)
    {
        self::bootKernel();
        $container=static::getContainer();
        $error = $container->get('validator')->validate($ingredient);
        $this->assertCount($number, $error);
    }
    

    public function testHasError()
    {
        $ingredient = new Ingredient();
        $ingredient->setName("Siou");
        $ingredient->setPrice(20);
        $ingredient->setCreatedAt(new DateTimeImmutable());

       
        $this->assertHasError($ingredient,1);
    }


}