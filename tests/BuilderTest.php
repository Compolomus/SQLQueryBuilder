<?php

namespace Compolomus\LSQLQueryBuilder\Tests;

use Compolomus\LSQLQueryBuilder\Builder;
use Compolomus\LSQLQueryBuilder\BuilderException;
use Compolomus\LSQLQueryBuilder\BuilderFactory;
use Compolomus\LSQLQueryBuilder\Parts\Group;
use Compolomus\LSQLQueryBuilder\Parts\Where;
use Compolomus\LSQLQueryBuilder\System\Conditions;
use Compolomus\LSQLQueryBuilder\System\Fields;
use Compolomus\LSQLQueryBuilder\System\Placeholders;
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
        $uid = (new Builder('dummy'))->uid('w');
        preg_match('/^([a-f0-9]{10}w|i|u{1})$/i', $uid, $matches);
        $this->assertCount(2, $matches);
    }

    public function testPlaceholders(): void
    {
        $placeholders = new Placeholders();
        $this->assertEquals($placeholders->get(), []);
        $placeholders->set('dummy', 'dummy');
        $placeholders->set('dummy1', 'dummy1');
        $this->assertEquals($placeholders->get(), [':dummy' => 'dummy', ':dummy1' => 'dummy1']);
    }

    public function testConditions(): void
    {
        $conditions = new Conditions();
        $this->assertEquals($conditions->conditions(), []);
        $conditions->add('dummy1', '<', 123);
        $conditions->add('dummy2', 'between', [1, 2]);
        $conditions->add('dummy3', 'not in', [3, 4, 5]);
        $conditions->add('dummy4', '>', 456);
        $this->assertCount(4, $conditions->conditions());
    }

    public function testConditionsException(): void
    {
        $conditions = new Conditions();
        $this->expectException(BuilderException::class);
        $conditions->add('dummy', 'qwerty', 1);
    }

    public function testWhere(): void
    {
        $select = (new Builder('dummy'))
            ->select()
                ->where([['id', '=', 15], ['firm_id', 'not in', [1, 2, 3]]])
                    ->add('dummy', '<', 123)
                ->where([['age', '>', 17], ['friends', '>=', 177]], 'or');
        $pattern = "/^(SELECT \* FROM `dummy` WHERE \(`id` \= \:[a-f0-9]{10}W AND `firm_id` NOT IN \:[a-f0-9]{10}W AND `dummy` \< \:[a-f0-9]{10}W\) AND \(`age` \> \:[a-f0-9]{10}W OR `friends` \>\= \:[a-f0-9]{10}W\))$/i";
        preg_match($pattern, $select, $matches);
        $this->assertCount(2, $matches);
        $this->assertCount(5, $select->placeholders());
    }

    public function testBuilderToString(): void
    {
        $builder = new Builder('dummy');
        $builder->select();
        $this->assertEquals($builder, 'SELECT * FROM `dummy`');
    }

    public function testWhereException(): void
    {
        $this->expectException(BuilderException::class);
        new Where([], 'dummy');
    }

    public function testGroup(): void
    {
        $group = new Group(['dummy', 'dummy2']);
        $group->add('dummy3');
        $this->assertEquals('GROUP BY `dummy`,`dummy2`,`dummy3`', $group->result());
    }

    public function testBuilderCallException(): void
    {
        $this->expectException(BuilderException::class);
        (new Builder('dummy'))->dummy();
    }
//
//    public function testOrder(): void
//    {
//
//    }
}
