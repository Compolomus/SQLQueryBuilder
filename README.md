# Koenig SQLQueryBuilder

[![License](https://img.shields.io/badge/license-GPL%20v.3-blue.svg?style=plastic)](https://www.gnu.org/licenses/gpl-3.0-standalone.html)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/build-status/master)

## Применение:

```php

use Compolomus\SQLQueryBuilder\Builder;

use Compolomus\SQLQueryBuilder\System\Placeholders;

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
        WHERE (`id` = :w1{uniqid} AND `fid` NOT IN :w2{uniqid})
            AND (`bid` > :w3{uniqid} OR `fig` >= :w4{uniqid})
        GROUP BY `mmm`,`t33`
        ORDER BY `giu`, `did` ASC,
                 `gid`, `ffd` DESC
        LIMIT 45 OFFSET 5
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
        WHERE (`cid` = :w5{uniqid})
        GROUP BY `ffff`
        ORDER BY `ffgid` DESC
        LIMIT 20 OFFSET 10
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
        WHERE (`id` = :w6{uniqid})
*/

echo '<br><br>---DELETE WITH WHERE---<br><br>';

echo $builder->delete()
    ->where()
        ->add('frrf', 'between', [12, 15])
    ->get();

/*
    DELETE FROM `users`
        WHERE (`frrf` BETWEEN :w7{uniqid})
*/

echo '<br><br>---INSERT FIELDS AND VALUES---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age'])
    ->values(['Vasya', 'vasya@gmail.com', 22])
    ->values(['Petya', 'petya@gmail.com', 24])
    ->get();

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
])
    ->get();

/*
    INSERT INTO `users` (`name`,`email`,`age`) VALUES (:i14{uniqid},:i15{uniqid},:i16{uniqid})
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
    UPDATE `users` SET `user` = :u17{uniqid},`post` = :u18{uniqid},`text` = :u19{uniqid}
        WHERE (`test` REGEXP :w20{uniqid})
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
    UPDATE `users` SET `name` = :u21{uniqid},`subname` = :u22{uniqid}
        WHERE (`big` < :w23{uniqid} OR `big` > :w24{uniqid})
        ORDER BY `qwerty` DESC
        LIMIT 10 OFFSET 20
*/

echo '<br><br>---PLACEHOLDERS---<br><br>';

echo count($builder->placeholders());

echo '<pre>' . print_r($builder->placeholders(), 1) . '</pre>';

/*
Array
(
    [w1{uniqid}] => 15
    [w2{uniqid}] => (1,2,3)
    [w3{uniqid}] => 17
    [w4{uniqid}] => 177
    [w5{uniqid}] => 1544
    [w6{uniqid}] => 5
    [w7{uniqid}] => 12 AND 15
    [i8{uniqid}] => Vasya
    [i9{uniqid}] => vasya@gmail.com
    [i10{uniqid}] => 22
    [i11{uniqid}] => Petya
    [i12{uniqid}] => petya@gmail.com
    [i13{uniqid}] => 24
    [i14{uniqid}] => Oleg
    [i15{uniqid}] => oleg@gmail.com
    [i16{uniqid}] => 33
    [u17{uniqid}] => 11
    [u18{uniqid}] => 345
    [u19{uniqid}] => Text
    [w20{uniqid}] => ^.....$
    [u21{uniqid}] => test
    [u22{uniqid}] => testus
    [w23{uniqid}] => 9
    [w24{uniqid}] => 18
)
*/

```

