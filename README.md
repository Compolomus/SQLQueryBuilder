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
        WHERE (`id` = :w1 AND `fid` NOT IN :w2)
            AND (`bid` > :w3 OR `fig` >= :w4)
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
        WHERE (`cid` = :w5)
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
        WHERE (`id` = :w6)
*/

echo '<br><br>---DELETE WITH WHERE---<br><br>';

echo $builder->delete()
    ->where()
        ->add('frrf', 'between', [12, 15])
    ->get();

/*
    DELETE FROM `users`
        WHERE (`frrf` BETWEEN :w7)
*/

echo '<br><br>---INSERT FIELDS AND VALUES---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age'])
    ->values(['Vasya', 'vasya@gmail.com', 22])
    ->values(['Petya', 'petya@gmail.com', 24])
    ->get();

/*
    INSERT INTO `users` (`name`,`email`,`age`)
                VALUES (:i8,:i9,:i10),
                    (:i11,:i12,:i13)
*/

echo '<br><br>---INSERT ARRAY(FIELDS => VALUES)---<br><br>';

echo $builder->insert([
    'name' => 'Oleg',
    'email' => 'oleg@gmail.com',
    'age' => 33
])
    ->get();

/*
    INSERT INTO `users` (`name`,`email`,`age`) VALUES (:i14,:i15,:i16)
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
    UPDATE `users` SET `user` = :u17,`post` = :u18,`text` = :u19
        WHERE (`test` REGEXP :w20)
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
    UPDATE `users` SET `name` = :u21,`subname` = :u22
        WHERE (`big` < :w23 OR `big` > :w24)
        ORDER BY `qwerty` DESC
        LIMIT 10 OFFSET 20
*/

echo '<br><br>---PLACEHOLDERS---<br><br>';

echo '<pre>' . print_r(Placeholders::$placeholders, 1) . '</pre>';

/*
Array
(
    [w1] => 15
    [w2] => (1,2,3)
    [w3] => 17
    [w4] => 177
    [w5] => 1544
    [w6] => 5
    [w7] => 12 AND 15
    [i8] => Vasya
    [i9] => vasya@gmail.com
    [i10] => 22
    [i11] => Petya
    [i12] => petya@gmail.com
    [i13] => 24
    [i14] => Oleg
    [i15] => oleg@gmail.com
    [i16] => 33
    [u17] => 11
    [u18] => 345
    [u19] => Text
    [w20] => ^.....$
    [u21] => test
    [u22] => testus
    [w23] => 9
    [w24] => 18
)
*/

```

