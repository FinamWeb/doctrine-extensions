<?php

namespace Just2trade\DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

/**
 * @Entity
 */
class TestEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    public $id;
}