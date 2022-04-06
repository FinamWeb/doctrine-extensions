<?php
declare(strict_types=1);

namespace Just2trade\DoctrineExtensions\Tests\Query;

use Just2trade\DoctrineExtensions\Tests\DoctrineExtensionTestCase;

class FunctionsTest extends DoctrineExtensionTestCase
{
    public function testDateTrunc(): void
    {
        $q = $this
            ->entityManager
            ->createQuery("select date_trunc('year', '2001-02-16 20:38:40'), entity.id from Test:TestEntity entity");

        $this->assertEquals(
            "SELECT date_trunc('year','2001-02-16 20:38:40') AS sclr_0, t0_.id AS id_1 FROM TestEntity t0_",
            $q->getSql()
        );
    }

    public function testEvery(): void
    {
        $q = $this
            ->entityManager
            ->createQuery("select entity from Test:TestEntity entity where every(entity.id IS NOT NULL OR entity.id IS NULL) = true");


        $this->assertEquals(
            "SELECT t0_.id AS id_0 FROM TestEntity t0_ WHERE EVERY(t0_.id IS NOT NULL OR t0_.id IS NULL) = 1",
            $q->getSql()
        );
    }

    public function testInArray(): void
    {
        $q = $this->entityManager
            ->createQuery("select entity from Test:TestEntity entity where inarray(:val, entity.id) = TRUE")
            ->setParameter('val', 4);

        $this->assertEquals(
            "SELECT t0_.id AS id_0 FROM TestEntity t0_ WHERE (? <@ t0_.id) = 1",
            $q->getSql()
        );
    }

    public function testRight(): void
    {
        $q = $this->entityManager
            ->createQuery("select entity from Test:TestEntity entity where right(entity.id, 10) = 14");

        $this->assertEquals(
            "SELECT t0_.id AS id_0 FROM TestEntity t0_ WHERE right(t0_.id, 10) = 14",
            $q->getSQL()
        );
    }

    public function testToChar()
    {
        $q = $this->entityManager
            ->createQuery("select to_char(1649124682, 'YYYYMMDD') AS date, entity.id from Test:TestEntity entity");

        $this->assertEquals(
            "SELECT to_char(1649124682,'YYYYMMDD') AS sclr_0, t0_.id AS id_1 FROM TestEntity t0_",
            $q->getSQL()
        );

    }
}