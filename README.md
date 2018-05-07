# Koenig LSQLQueryBuilder

[![License](https://poser.pugx.org/compolomus/light-sql-query-builder/license)](https://packagist.org/packages/compolomus/light-sql-query-builder)

[![Build Status](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/SQLQueryBuilder/?branch=master)
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

echo $builder->select(['id' => 'user_id', 'name', 'email'])
    ->where([['id', '=', 15], ['firm_id', 'not in', [1, 2, 3]]])
    ->where([['age', '>', 17], ['friends', '>=', 177]], 'or')
    ->group(['age', 'friends'])
    ->order(['salary', 'experience'], 'desc')
        ->asc(['age', 'size'])
    ->limit(5, 10, 'page');

/*
    SELECT `user_id` AS `id`,`name`,`email` 
        FROM `users` 
        WHERE (`id` = :59ee533076W AND `firm_id` NOT IN :59ee571790W) 
            AND (`age` > :592cd57379W OR `friends` >= :592cd61484W) 
        GROUP BY `age`,`friends` 
        ORDER BY `age`,`size` ASC,
                    `salary`,`experience` DESC 
        LIMIT 45 OFFSET 5
*/

/*
    Support 89 MYSQL Field function[one argument] (count, min, max... etc)
*/

echo '<br><br>---COUNT#1---<br><br>';

echo $builder->select()
    ->setFunction('*', 'count')
    ->where()
        ->add('age', '=', 32)
    ->group(['position'])
    ->order(['name'], 'desc')
    ->limit(10, 20);

/*
    SELECT COUNT(*) 
        FROM `users` 
        WHERE (`age` = :598bf03980W) 
        GROUP BY `position` 
        ORDER BY `name` DESC 
        LIMIT 20 OFFSET 10
*/

echo '<br><br>---COUNT#2---<br><br>';

echo $builder->select(['count' => '*|count']);

/*
    SELECT COUNT(*) AS `count`
        FROM `users`
*/

echo '<br><br>---DELETE BY ID---<br><br>';

echo $builder->delete(5);

/*
    DELETE FROM `users` 
        WHERE (`id` = :593b785726W)
*/

echo '<br><br>---DELETE BY FIELD---<br><br>';

echo $builder->delete(15, 'userid');

/*
    DELETE FROM `users` 
        WHERE (`userid` = :593b756573W)
*/

echo '<br><br>---DELETE WITH WHERE---<br><br>';

echo $builder->delete()
    ->where()
        ->add('rank', 'between', [12, 15]);

/*
    DELETE FROM `users` 
        WHERE (`rank` BETWEEN :5979f19816W)
*/

echo '<br><br>---INSERT FIELDS AND VALUES---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age'])
    ->values(['Vasya', 'vasya@gmail.com', 22])
    ->values(['Petya', 'petya@gmail.com', 24]);

/*
    INSERT INTO `users` 
        (`name`,`email`,`age`) 
        VALUES 
            (:59b8773308I,:59b8798017I,:59b8791062I),
            (:59b8754434I,:59b8727155I,:59b8728332I)
*/

echo '<br><br>---INSERT ARRAY(FIELDS => VALUES)---<br><br>';

echo $builder->insert([
    'name' => 'Oleg',
    'email' => 'oleg@gmail.com',
    'age' => 33
]);

/*
    INSERT INTO `users` 
        (`name`,`email`,`age`) 
        VALUES 
            (:59b8702032I,:59b8702274I,:59b8735242I)
*/

echo '<br><br>---INSERT PREPARE WITH FIELDS---<br><br>';

echo $builder->insert()
    ->fields(['name', 'email', 'age']);

/*
    INSERT INTO `users` 
        (`name`,`email`,`age`) 
        VALUES (?,?,?)
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
    UPDATE `users` 
        SET 
            `user` = :5923849640U,
            `post` = :5923828461U,
            `text` = :5923846245U 
        WHERE (`test` REGEXP :5923827411W)
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
    UPDATE `users` 
        SET 
            `name` = :5923864911U,
            `subname` = :5923845311U 
        WHERE (`growth` < :5923863542W OR `growth` > :5923879798W) 
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
            ON 
                `users`.`id` = `test`.`tid` 
            AND `users`.`did` = `test`.`mid`
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
    
/*
    SELECT * FROM `users` 
        CROSS JOIN `test4` AS `t4` 
        INNER JOIN `test5` AS `t5` 
            ON `users`.`rid` = `test4`.`vid` 
            AND `users`.`aid` = `test5`.`mid` 
            AND `users`.`bid` = `test5`.`cid`
*/    

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
    [:59ee533076W] => 15
    [:59ee571790W] => (1,2,3)
    [:592cd57379W] => 17
    [:592cd61484W] => 177
    [:598bf03980W] => 32
    [:593b785726W] => 5
    [:593b756573W] => 15
    [:5979f19816W] => 12 AND 15
    [:59b8773308I] => Vasya
    [:59b8798017I] => vasya@gmail.com
    [:59b8791062I] => 22
    [:59b8754434I] => Petya
    [:59b8727155I] => petya@gmail.com
    [:59b8728332I] => 24
    [:59b8702032I] => Oleg
    [:59b8702274I] => oleg@gmail.com
    [:59b8735242I] => 33
    [:5923849640U] => 11
    [:5923828461U] => 345
    [:5923846245U] => Text
    [:5923827411W] => ^.....$
    [:5923864911U] => test
    [:5923845311U] => testus
    [:5923863542W] => 180
    [:5923879798W] => 140
)
*/

```

