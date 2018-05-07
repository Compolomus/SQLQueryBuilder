<?php

namespace Compolomus\LSQLQueryBuilder\System;

use Compolomus\LSQLQueryBuilder\BuilderException;

class Fields
{
    use Traits\Helper;

    private $name;

    private $allias;

    private $result;

    /*
    'COMPRESS',
    'MD5',
    'PASSWORD',
    'SHA',
    'SHA1',
    'UNCOMPRESS',
    'UNCOMPRESSED_LENGTH',
    'VALIDATE_PASSWORD_STRENGTH',

    'AVG',
    'BIT_AND',
    'BIT_OR',
    'BIT_XOR',
    'BIT_COUNT',
    'COUNT',
    'GROUP_CONCAT',
    'JSON_ARRAYAGG',
    'MAX',
    'MIN',
    'STD',
    'STDDEV',
    'STDDEV_POP',
    'STDDEV_SAMP',
    'SUM',
    'VAR_POP',
    'VAR_SAMP',
    'VARIANCE',

    'ASCII',
    'BIN',
    'ORD',
    'CHAR_LENGTH', // multibyte len
    'HEX',
    'OCT',
    'LCASE',
    'LOWER',
    'UCASE',
    'UPPER',
    'REVERSE',
    #'LOAD_FILE', // security
    'TRIM', // rtrim
    'LTRIM',
    'RTRIM',

    'ABS',
    'ACOS',
    'ASIN',
    'ATAN',
    'CEIL',
    'CEILING',
    'COS',
    'COT',
    'CRC32',
    'DEGREES',
    'EXP',
    'FLOOR',
    'LN',
    'LOG',
    'LOG2',
    'LOG10',
    'RADIANS',
    'ROUND',
    'SIGN',
    'SIN',
    'SQRT',
    'TAN',

    'DATE',
    'DAY',
    'DAYNAME',
    'DAYOFMONTH',
    'DAYOFWEEK',
    'DAYOFYEAR',
    'FROM_DAYS',
    'FROM_UNIXTIME',
    'HOUR',
    'LAST_DAY',
    'MICROSECOND',
    'MINUTE',
    'MONTH',
    'MONTHNAME',
    'QUARTER',
    'SECOND',
    'SEC_TO_TIME',
    'TIME',
    'TIME_TO_SEC',
    'TO_DAYS',
    'TO_SECONDS',
    'UNIX_TIMESTAMP',
    'WEEK',
    'WEEKDAY',
    'YEAR',
    'YEARWEEK',
    'WEEKOFYEAR',
     */
    private $functionsList = [
        'MD5',
        'SHA1',
        'AVG',
        'COUNT',
        'MAX',
        'MIN',
        'SUM',
        'ABS',
        'UNIX_TIMESTAMP'
    ];

    public function __construct(string $name)
    {
        $this->result = $this->name = $this->escapeField($name);
    }

    public function setAllias(string $alliasName): void
    {
        $this->allias = $this->escapeField($alliasName);
    }

    public function setFunction(string $functionName): void
    {
        if (!\in_array(strtoupper($functionName), $this->functionsList, true)) {
            throw new BuilderException('MYSQL Функция ' . $functionName . ' не найдена |SELECT setFunction|');
        }
        $this->result = strtoupper($functionName) . '(' . $this->name . ')';
    }

    public function result(): string
    {
        return $this->result . (null !== $this->allias ? ' AS ' . $this->allias : '');
    }
}
