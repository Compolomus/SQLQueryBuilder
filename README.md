# Koenig LSQLQueryBuilder

[![License](https://img.shields.io/badge/license-GPL%20v.3-blue.svg?style=plastic)](https://www.gnu.org/licenses/gpl-3.0-standalone.html)

[![Build Status](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/?branch=master)
[![Code Climate](https://codeclimate.com/github/Compolomus/SQLQueryBuilder/badges/gpa.svg)](https://codeclimate.com/github/Compolomus/SQLQueryBuilder)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/783c680b-cf5e-49ec-bc21-c4d50f257974/mini.png)](https://insight.sensiolabs.com/projects/783c680b-cf5e-49ec-bc21-c4d50f257974)
[![Downloads](https://poser.pugx.org/compolomus/light-sql-query-builder/downloads)](https://packagist.org/packages/compolomus/light-sql-query-builder)

## Установка:

composer require compolomus/light-sql-query-builder

## Применение:

```php
use Compolomus\LSQLQueryBuilder\Builder;

require __DIR__ . '/vendor/autoload.php';

$builder = new Builder('users');

echo '---SELECT---<br><br>';

echo $builder->select(['user_id' => 'id', 'name', 'email'])
    ->where([['id', '=', 15], ['firm_id', 'not in', [1, 2, 3]]])
    ->where([['age', '>', 17], ['friends', '>=', 177]], 'or')
    ->group(['age', 'friends'])
    ->order(['salary', 'experience'], 'desc')
        ->asc(['age', 'size'])
    ->limit(5, 10, 'page');

/*
    SELECT `user_id` AS `id`,`name`,`email`
        FROM `users`
        WHERE (`id` = :W-6fa17117 AND `firm_id` NOT IN :W-6fa26444)
            AND (`age` > :W-6fa12048 OR `friends` >= :W-6fa74078)
        GROUP BY `age`,`friends`
        ORDER BY `salary`,`experience` ASC,
            `age`,`size` DESC
        LIMIT :L-ae294743 OFFSET :L-ae248761
*/

echo '<br><br>---COUNT#1---<br><br>';
echo $builder->count()
    ->where()
        ->add('age', '=', 32)
    ->group(['position'])
    ->order(['name'], 'desc')
    ->limit(10, 20);

/*
    SELECT COUNT(*) FROM `users`
        WHERE (`age` = :W-19260558)
        GROUP BY `position`
        ORDER BY `name` DESC
        LIMIT :L-19260533 OFFSET :L-19217522
*/

echo '<br><br>---COUNT#2---<br><br>';
echo $builder->count('*', 'count');

/*
    SELECT COUNT(*) AS `count`
        FROM `users`
*/

echo '<br><br>---DELETE BY ID---<br><br>';

echo $builder->delete(5);

/*
    DELETE FROM `users`
        WHERE (`id` = :w6{uniqid})
*/

echo '<br><br>---DELETE BY FIELD---<br><br>';

echo $builder->delete(15, 'userid');

/*
    DELETE FROM `users`
        WHERE (`userid` = :w6{uniqid})
*/

echo '<br><br>---DELETE WITH WHERE---<br><br>';

echo $builder->delete()
    ->where()
        ->add('rank', 'between', [12, 15]);

/*
    DELETE FROM `users`
        WHERE (`rank` BETWEEN :w7{uniqid})
*/

echo '<br><br>---INSERT FIELDS AND VALUES---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age'])
    ->values(['Vasya', 'vasya@gmail.com', 22])
    ->values(['Petya', 'petya@gmail.com', 24]);

/*
    INSERT INTO `users` (`name`,`email`,`age`)
                VALUES (:i8{uniqid},:i9{uniqid},:i10{uniqid}),
                    (:i11{uniqid},:i12{uniqid},:i13{uniqid})
*/

echo '<br><br>---INSERT ARRAY(FIELDS => VALUES)---<br><br>';

echo $builder->insert([
    'name' => 'Oleg',
    'email' => 'oleg@gmail.com',
    'age' => 33
]);

/*
    INSERT INTO `users` (`name`,`email`,`age`) VALUES (:i14{uniqid},:i15{uniqid},:i16{uniqid})
*/

echo '<br><br>---INSERT PREPARE WITH FIELDS---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age']);

/*
    INSERT INTO `users` (`name`,`email`,`age`) VALUES (?,?,?)
*/

echo '<br><br>---UPDATE#1---<br><br>';

echo $builder->update([
    'user' => 11,
    'post' => 345,
    'text' => 'Text'
])
    ->where()
        ->add('test', 'regexp', '^.....$');

/*
    UPDATE `users` SET `user` = :u17{uniqid},`post` = :u18{uniqid},`text` = :u19{uniqid}
        WHERE (`test` REGEXP :w20{uniqid})
*/

echo '<br><br>---UPDATE#2---<br><br>';
echo $builder->update()
    ->fields(['name', 'subname'])
    ->values(['test', 'testus'])
    ->where([], 'or')
        ->add('growth', '<', 180)
        ->add('growth', '>', 140)
    ->order(['name'], 'desc')
    ->limit(10, 20, 'offset');

/*
    UPDATE `users` SET `name` = :u21{uniqid},`subname` = :u22{uniqid}
        WHERE (`growth` < :w23{uniqid} OR `growth` > :w24{uniqid})
        ORDER BY `name` DESC
        LIMIT 10 OFFSET 20
*/

echo '<br><br>---UPDATE#3---<br><br>';
echo $builder->update()
    ->fields(['name', 'email', 'age']);

/*
    UPDATE `users` SET `name` = ?,`email` = ?,`age` = ?
*/

echo '<br><br>---JOIN#1---<br><br>';
echo $builder->select()
    ->join('test', 't', [['id', 'tid'], ['did', 'mid']], 'cross');

/*
    SELECT * FROM `users`
        CROSS JOIN `test` AS `t`
        ON `users`.`id` = `t`.`tid` AND `users`.`did` = `t`.`mid`
*/

echo '<br><br>---JOIN#2---<br><br>';
echo $builder->select()
    ->join('test2')
    ->addOn([['fid', 'gid']])
    ->setType('right');

/*
    SELECT * FROM `users`
        RIGHT JOIN `test2`
        ON `users`.`fid` = `test2`.`gid`
*/

echo '<br><br>---JOIN#3---<br><br>';
echo $builder->select()
    ->join('test3')
    ->using('qwerty');

/*
    SELECT * FROM `users` LEFT JOIN `test3` USING(`qwerty`)
*/

echo '<br><br>---JOIN#4---<br><br>';
echo $builder->select()
    ->join('test4')
    ->addOn([['rid', 'vid']])
    ->setAlias('t4')
    ->setType('cross')
    ->join('test5', 't5', [['aid', 'mid'], ['bid', 'cid']], 'inner');

echo '<br><br>---JOIN#5---<br><br>';
echo $builder->select()
    ->join('testus', 'ts')
    ->setType('right')
    ->join('testus2', 'ts2')
    ->using('user');

/*
    SELECT * FROM `users`
        RIGHT JOIN `testus` AS `ts`
        LEFT JOIN `testus2` AS `ts2`
    USING(`user`)
*/

echo '<br><br>---PLACEHOLDERS---<br><br>';

echo '<pre>' . print_r($builder->placeholders(), true) . '</pre>';

/*
Array
(
    [W-8b237313] => 15
    [W-8b277941] => (1,2,3)
    [W-8b208993] => 17
    [W-8b230349] => 177
    [L-08245666] => 45
    [L-08243748] => 5
    [W-46a97418] => 32
    [L-46a45037] => 20
    [L-46a18403] => 10
    [W-85264315] => 5
    [W-85259851] => 15
    [W-85201400] => 12 AND 15
    [I-c3b29595] => Vasya
    [I-c3b22112] => vasya@gmail.com
    [I-c3b95433] => 22
    [I-c3b42677] => Petya
    [I-c3b54646] => petya@gmail.com
    [I-c3b24548] => 24
    [I-c3b53493] => Oleg
    [I-c3b63813] => oleg@gmail.com
    [I-c3b64637] => 33
    [U-c3b20186] => 11
    [U-c3b90942] => 345
    [U-c3b81871] => Text
    [W-02371938] => ^.....$
    [U-02332943] => test
    [U-02368365] => testus
    [W-02317242] => 180
    [W-02345100] => 140
    [L-02373834] => 10
    [L-02363296] => 20
)
*/

```

