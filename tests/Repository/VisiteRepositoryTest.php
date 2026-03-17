<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of VisiteRepositoryTest.
 *
 * @author Karl
 */
class VisiteRepositoryTest extends KernelTestCase
{
    public const TEST_CITY = 'New York';

    public function recupRepository(): VisiteRepository
    {
        self::bootKernel();

        return self::getContainer()->get(VisiteRepository::class);
    }

    public function testNbVisites()
    {
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(2, $nbVisites);
    }

    public function newVisite(): Visite
    {
        return (new Visite())
                ->setVille(TEST_CITY)
                ->setPays('USA')
                ->setDatecreation(new \DateTime('now'));
    }

    public function testAddVisite()
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $nbVisites = $repository->count([]);
        $repository->add($visite, true);
        $this->assertEquals($nbVisites + 1, $repository->count([]), "erreur lors de l'ajout");
    }

    public function testRemoveVisite()
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $nbVisites = $repository->count([]);
        $repository->remove($visite, true);
        $this->assertEquals($nbVisites - 1, $repository->count([]), 'erreur lors de la suppression');
    }

    public function testFindByEqualValue()
    {
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $visites = $repository->findByEqualValue('ville', TEST_CITY);
        $nbVisites = count($visites);
        $this->assertEquals(1, $nbVisites);
        $this->assertEquals(TEST_CITY, $visites[0]->getVille());
    }
}
