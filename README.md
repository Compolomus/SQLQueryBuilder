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
    ->where()
        ->add('id', '=', 15)
        ->add('fid', 'not in', [1, 2, 3])
    ->where('or')
        ->add('bid', '>', '17')
        ->add('fig', '>=', 177)
    ->group('mmm')
        ->add('t33')
    ->order('gid', 'desc')
        ->add('giu')
        ->add('did')
        ->add('ffd', 'desc')
    ->limit(5, 10, 'page')
    ->get();

/*
    SELECT `user_id` AS `id`,`name`,`email` 
        FROM `users` 
        WHERE (`id` = :W-4e521848 AND `fid` NOT IN :W-80d99658) 
          AND (`bid` > :W-80d50495 OR `fig` >= :W-80d65633) 
        GROUP BY `mmm`,`t33` 
        ORDER BY `giu`, `did` ASC,
                 `gid`, `ffd` DESC 
        LIMIT :L-33017614 OFFSET :L-33097564
*/

echo '<br><br>---COUNT#1---<br><br>';
echo $builder->count()
    ->where()
        ->add('cid', '=', 1544)
    ->group('ffff')
    ->order('ffgid', 'desc')
    ->limit(10, 20)
    ->get();

/*
    SELECT COUNT(*) 
        FROM `users` 
        WHERE (`cid` = :W-33066156) 
        GROUP BY `ffff` 
        ORDER BY `ffgid` DESC 
        LIMIT :L-33020415 OFFSET :L-33050757
*/

echo '<br><br>---COUNT#2---<br><br>';
echo $builder->count('*', 'count')
    ->get();

/*
    SELECT COUNT(*) AS `count`
        FROM `users`
*/

echo '<br><br>---DELETE BY ID---<br><br>';

echo $builder->delete(5)
    ->get();

/*
    DELETE FROM `users`
        WHERE (`id` = :W-5be88440)
*/

echo $builder->delete(15, 'userid')
    ->get();

/*
    DELETE FROM `users`
        WHERE (`userid` = :W-5be72385)
*/

echo '<br><br>---DELETE WITH WHERE---<br><br>';

echo $builder->delete()
    ->where()
        ->add('frrf', 'between', [12, 15])
    ->get();

/*
    DELETE FROM `users`
        WHERE (`frrf` BETWEEN :W-5be16681)
*/

echo '<br><br>---INSERT FIELDS AND VALUES---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age'])
    ->values(['Vasya', 'vasya@gmail.com', 22])
    ->values(['Petya', 'petya@gmail.com', 24])
    ->get();

/*
    INSERT INTO `users` (`name`,`email`,`age`)
                VALUES (:I-9a663499,:I-9a655473,:I-9a632999),
                       (:I-9a665659,:I-9a609771,:I-9a638944)
*/

echo '<br><br>---INSERT ARRAY(FIELDS => VALUES)---<br><br>';

echo $builder->insert([
    'name' => 'Oleg',
    'email' => 'oleg@gmail.com',
    'age' => 33
])
    ->get();

/*
    INSERT INTO `users` (`name`,`email`,`age`) VALUES (:I-9a670814,:I-9a657832,:I-9a600062)
*/

echo '<br><br>---INSERT PREPARE WITH FIELDS---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age'])
    ->get();

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
        ->add('test', 'regexp', '^.....$')
    ->get();

/*
    UPDATE `users` SET `user` = :U-9a621176,`post` = :U-9a631060,`text` = :U-9a686956 
        WHERE (`test` REGEXP :W-9a602213)
*/

echo '<br><br>---UPDATE#2---<br><br>';
echo $builder->update()
    ->fields(['name', 'subname'])
    ->values(['test', 'testus'])
    ->where('or')
        ->add('big', '<', 9)
        ->add('big', '>', 18)
    ->order('qwerty', 'desc')
    ->limit(10, 20, 'offset')
    ->get();

/*
    UPDATE `users` SET `name` = :U-9a610261,`subname` = :U-9a651523 
        WHERE (`big` < :W-9a646315 OR `big` > :W-9a672443) 
        ORDER BY `qwerty` DESC 
        LIMIT :L-9a608262 OFFSET :L-9a649802
*/

echo '<br><br>---UPDATE#3---<br><br>';
echo $builder->update()
    ->fields(['name', 'email', 'age'])
    ->get();

/*
    UPDATE `users` SET `name` = ?,`email` = ?,`age` = ?
*/

echo '<br><br>---JOIN#1---<br><br>';
echo $builder->select()
    ->join('test', 't', [['id', 'tid'], ['did', 'mid']], 'cross')
    ->get();

/*
    SELECT * FROM `users`
        CROSS JOIN `test` AS `t`
        ON `users`.`id` = `t`.`tid` AND `users`.`did` = `t`.`mid`
*/

echo '<br><br>---JOIN#2---<br><br>';
echo $builder->select()
    ->join('test2')
    ->addOn([['fid', 'gid']])
    ->setType('right')
    ->get();

/*
    SELECT * FROM `users`
        RIGHT JOIN `test2`
        ON `users`.`fid` = `test2`.`gid`
*/

echo '<br><br>---JOIN#3---<br><br>';
echo $builder->select()
    ->join('test3')
    ->using('qwerty')
    ->get();

/*
    SELECT * FROM `users` LEFT JOIN `test3` USING(`qwerty`)
*/

echo '<br><br>---JOIN#4---<br><br>';
echo $builder->select()
    ->join('test4')
    ->addOn([['rid', 'vid']])
    ->setAlias('t4')
    ->setType('cross')
    ->join('test5', 't5', [['aid', 'mid'], ['bid', 'cid']], 'inner')
    ->get();

/*
    SELECT * FROM `users` 
        CROSS JOIN `test4` AS `t4` 
        INNER JOIN `test5` AS `t5` 
        ON `users`.`rid` = `test4`.`vid` 
            AND `users`.`aid` = `test5`.`mid` 
            AND `users`.`bid` = `test5`.`cid` 
*/

echo '<br><br>---PLACEHOLDERS---<br><br>';

echo '<pre>' . print_r($builder->placeholders(), 1) . '</pre>';

/*
Array
(
    [W-dee57705] => 15
    [W-dee62202] => (1,2,3)
    [W-dee91458] => 17
    [W-dee45671] => 177
    [L-1d640579] => 45
    [L-1d625851] => 5
    [W-5be82015] => 1544
    [L-5be78159] => 20
    [L-5be00543] => 10
    [W-5be88440] => 5
    [W-5be72385] => 15
    [W-5be16681] => 12 AND 15
    [I-9a663499] => Vasya
    [I-9a655473] => vasya@gmail.com
    [I-9a632999] => 22
    [I-9a665659] => Petya
    [I-9a609771] => petya@gmail.com
    [I-9a638944] => 24
    [I-9a670814] => Oleg
    [I-9a657832] => oleg@gmail.com
    [I-9a600062] => 33
    [U-9a621176] => 11
    [U-9a631060] => 345
    [U-9a686956] => Text
    [W-9a602213] => ^.....$
    [U-9a610261] => test
    [U-9a651523] => testus
    [W-9a646315] => 9
    [W-9a672443] => 18
    [L-9a608262] => 10
    [L-9a649802] => 20
)
*/

```

