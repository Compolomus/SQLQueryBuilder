# Koenig SQLQueryBuilder

[![License](https://img.shields.io/badge/license-GPL%20v.3-blue.svg?style=plastic)](https://www.gnu.org/licenses/gpl-3.0-standalone.html)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/build-status/master)

## Применение:

```php

use Koenig\SQLQueryBuilder\Builder;

use Koenig\SQLQueryBuilder\System\Placeholders;

require __DIR__ . '/vendor/autoload.php';

$builder = new Builder('users');

echo '---SELECT---<br><br>';

echo $builder->select(['user_id' => 'id', 'name', 'email'])
    ->where()
        ->add('id', '=', 15)
        ->add('fid', 'not in', [1,2,3])
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
        WHERE (`id` = :w1 AND `fid` not in :w2)
            AND (`bid` > :w3 OR `fig` >= :w4)
        GROUP BY `mmm`,`t33`
        ORDER BY `giu`, `did` ASC,
                 `gid`, `ffd` DESC
        LIMIT 45 OFFSET 5
*/

echo '<br><br>---SELECT COUNT#1---<br><br>';
echo $builder->select()
    ->count()
    ->get();

/*
    SELECT *,COUNT(*)
        FROM `users`
*/

echo '<br><br>---SELECT COUNT#2---<br><br>';
echo $builder->select()
    ->count('*', 'count')
    ->get();

/*
    SELECT *,COUNT(*) AS `count`
        FROM `users`
*/


echo '<br><br>---DELETE BY ID---<br><br>';

echo $builder->delete(5)
    ->get();

/*
    DELETE FROM `users`
        WHERE (`id` = :w5)
*/

echo '<br><br>---DELETE WITH WHERE---<br><br>';

echo $builder->delete()
    ->where()
        ->add('frrf', 'between', [12, 15])
    ->get();

/*
    DELETE FROM `users`
        WHERE (`frrf` between :w6)
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
    [w5] => 5
    [w6] => 12 AND 15
)
*/

```

