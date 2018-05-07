<?php

namespace Compolomus\LSQLQueryBuilder\Tests;

use Compolomus\LSQLQueryBuilder\Builder;
use Compolomus\LSQLQueryBuilder\BuilderException;
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
        $this->assertEquals('SELECT COUNT(`Dummy`) AS `Allias`,`dummy` AS `allias` FROM `table`',
            $builder->select(['Dummy', 'allias' => 'dummy'])->setFunction('Dummy', 'count')->setAllias('Dummy',
                'Allias'));
    }

    public function testFieldsException(): void
    {
        $this->expectException(BuilderException::class);
        (new Builder('table'))->select(['dummy|abcd']);
    }

    public function testSelectException(): void
    {
        $this->expectException(BuilderException::class);
        (new Builder('table'))->select(['dummy'])->setFunction('notDummy', 'count');
    }

    public function testCallerException(): void
    {
        $this->expectException(BuilderException::class);
        (new Builder('table'))->select(['dummy'])->setFun('notDummy', 'count');
    }

    public function testHelperConcat(): void
    {
        $testArray = [1, 2, 3];
        $builder = new Builder('dummy');
        $this->assertEquals('1,2,3', $builder->concat($testArray));
    }

    public function testHelperWhere(): void
    {
        $testArray = ['one', 'two', 'three'];
        $builder = new Builder('dummy');
        $this->assertEquals('one AND two AND three', $builder->concatWhere($testArray));
        $this->assertEquals('one OR two OR three', $builder->concatWhere($testArray, 'or'));
        $this->expectException(BuilderException::class);
        $this->assertEquals('one OR two OR three', $builder->concatWhere($testArray, 'dummy'));
    }

    public function testHelperOrder(): void
    {
        $testArray = ['one', 'two', 'three'];
        $builder = new Builder('dummy');
        $this->assertEquals('`one`,`two`,`three` ASC', $builder->concatOrder($testArray));
        $this->assertEquals('`one`,`two`,`three` DESC', $builder->concatOrder($testArray, 'desc'));
        $this->expectException(BuilderException::class);
        $this->assertEquals('`one`,`two`,`three` DESC', $builder->concatOrder($testArray, 'dummy'));
    }

    public function testHelperMap(): void
    {
        $testArray = ['one', 'two', 'three'];
        $builder = new Builder('dummy');
        $this->assertEquals('dummy = one,two,three', $builder->map('dummy', $builder->concat($testArray)));
    }

    public function testHelperUid(): void
    {
        $this->assertNotFalse(preg_match('/^[a-f0-9]{10}DUMMY$/i', (new Builder('dummy'))->uid('dummy')));
    }
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
