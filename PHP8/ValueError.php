<?php
declare(strict_types = 1);

/**
 * array_rand 第一个参数不能是空数组，否则会引发 ValueError
 *  ValueError: array_rand(): Argument #1 ($array) cannot be empty
 */
array_rand([], 0);

/**
 * 第三个参数 depth 必须是大于0的整数，否则会引发 ValueError
 * ValueError: json_decode(): Argument #3 ($depth) must be greater than 0
 */
json_decode('{}', true, -1);
