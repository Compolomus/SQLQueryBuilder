# Koenig SQLQueryBuilder

[![License](https://img.shields.io/badge/license-GPL%20v.3-blue.svg?style=plastic)](https://www.gnu.org/licenses/gpl-3.0-standalone.html)

## Применение:

```php

use Koenig\SQLQueryBuilder\Builder;

use Koenig\SQLQueryBuilder\System\Placeholders;

require __DIR__ . '/vendor/autoload.php';

$builder = new Builder('users');

echo '---WHERE---<br><br>';

echo $builder->where()->add('id', '=', 15)->add('fid', 'not in', [1,2,3])->where('or')->add('bid', '>', '17')->add('fig', '>=', 177)->result();

echo '<br><br>---ORDER---<br><br>';

echo $builder->order('gid', 'desc')->add('giu')->add('did')->add('ffd', 'desc')->result();

echo '<br><br>---PLACEHOLDERS---<br><br>';

echo '<pre>' . print_r(Placeholders::$placeholders, 1) . '</pre>';

#echo '<pre>' . print_r($builder, 1) . '</pre>';
var_dump($builder->db());

```

