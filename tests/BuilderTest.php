<?php

namespace Compolomus\LSQLQueryBuilder\Tests;

use Compolomus\LSQLQueryBuilder\Builder;
use Compolomus\LSQLQueryBuilder\BuilderFactory;
use Compolomus\LSQLQueryBuilder\System\Fields;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{

    public function test__construct(): void
    {
        try {
            $builder = new Builder();
            $this->assertInternalType('object', $builder);
            $this->assertInstanceOf(Builder::class, $builder);
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testTable(): void
    {
        $builder = new Builder();
        $this->assertEquals('', $builder->table());
    }

    public function testEscapeField(): void
    {
        $builder = new Builder();
        $testString = 'Dummy';
        $testArray = ['Dummy', 'Dummy'];
        $this->assertEquals($builder->escapeField($testString), '`Dummy`');
        $this->assertEquals($builder->escapeField($testArray), ['`Dummy`', '`Dummy`']);
    }

    public function testSetTable(): void
    {
        $builder = new Builder('Dummy');
        $this->assertEquals('`Dummy`', $builder->table());
    }

    public function testFactory(): void
    {
        $builder = (new BuilderFactory)('Dummy');
        $this->assertInstanceOf(Builder::class, $builder);
        $this->assertEquals('`Dummy`', $builder->table());
    }

    public function testFields(): void
    {
        $field = new Fields('Dummy');
        $this->assertEquals('`Dummy`', $field->result());
        $field->setAllias('Allias');
        $this->assertEquals('`Dummy` AS `Allias`', $field->result());
        $field->setFunction('count');
        $this->assertEquals('COUNT(`Dummy`) AS `Allias`', $field->result());
    }

    public function testSelect(): void
    {
        $builder = (new Builder('Dummy'))->select();
        $this->assertEquals('SELECT * FROM `Dummy`', $builder);
        $builder = new Builder('table');
        $this->assertEquals('SELECT COUNT(`Dummy`) AS `Allias`,`dummy` FROM `table`', $builder->select(['Allias' => 'Dummy|count', 'dummy']));
    }

//    public function testException(): void
//    {
//
//    }

    //    public function testConcat()
//    {
//
//    }
//
//    public function testInsert()
//    {
//
//    }
//
//    public function test__isset()
//    {
//
//    }
//

//
//    public function test__call()
//    {
//
//    }
//
//    public function testMap()
//    {
//
//    }
//
//    public function test__unset()
//    {
//
//    }
//
//    public function test__set()
//    {
//
//    }
//
//    public function testDelete()
//    {
//
//    }
//
//    public function testPlaceholders()
//    {
//
//    }
//
//    public function testConcatOrder()
//    {
//
//    }
//

//
//    public function testAddPlaceholders()
//    {
//
//    }
//

//
//    public function testUpdate()
//    {
//
//    }
//

//
//    public function test__get()
//    {
//
//    }
//
//    public function testConcatWhere()
//    {
//
//    }
//
//    public function testUid()
//    {
//
//    }
}
