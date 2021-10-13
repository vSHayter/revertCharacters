<?php

/**
 * Метод разбивает входящую строку на слова отправляя их в handler.
 *
 * @param string $str
 * @return string
 */
function revertCharacters(string $str)
{
    if(empty($str))
        return "Строка пустая.";
    else {
        $array = explode(' ', $str);

        foreach ($array as &$item)
            $item = handler($item);

        return implode(' ', $array);
    }
}

/**
 * Метод обрабатывает входное слово проверяя регистр и знаки пунктуации.
 *
 * @param string $str
 * @return string
 */
function handler(string $str)
{
    $upper = checkUpperCase($str);

    if($upper) {
        $str = mb_ucfirst(checkMarksAndRevers(mb_strtolower($str)));

        return $str;
    } else {
        $str = checkMarksAndRevers($str);

        return $str;
    }
}

/**
 * Метод проверки регистра входного слова.
 *
 * @param string $str
 * @param string|null $encoding
 * @return bool
 */
function checkUpperCase(string $str, string $encoding = null)
{
    $first = mb_substr($str, 0, 1, $encoding ?: mb_internal_encoding());

    if(mb_strtolower($first, $encoding ?: mb_internal_encoding()) != $first)
        return true;
    else
        return false;
}

/**
 * Метод проверки наличия знака пунктуации и дальнейшей обработки слова.
 *
 * @param string $str
 * @param string|null $encoding
 * @return string
 */
function checkMarksAndRevers(string $str, string $encoding = null)
{
    preg_match('/\w+/u', $str, $matches);
    if($matches[0] == $str) {
        $str = revers($str);
        return $str;
    } else {
        $marks = preg_split('/[^[:punct:]]+/', $str, -1, 1);
        $str = mb_substr(revers($str), 1, null, $encoding ?: mb_internal_encoding());
        $str .= $marks[0];
        return $str;
    }
}

/**
 * Метод реверса слова.
 *
 * @param string $str
 * @param string|null $encoding
 * @return string
 */
function revers(string $str, string $encoding = null)
{
    $chars = mb_str_split($str, 1, $encoding ?: mb_internal_encoding());
    $str = implode('', array_reverse($chars));
    return $str;
}

/**
 * Метод изменения регистра.
 *
 * @param string $str
 * @param string|null $encoding
 * @return string
 */
function mb_ucfirst(string $str, string $encoding = null)
{
    $firstChar = mb_substr($str, 0, 1, $encoding ?: mb_internal_encoding());
    $then = mb_substr($str, 1, null, $encoding ?: mb_internal_encoding());
    return mb_strtoupper($firstChar, $encoding ?: mb_internal_encoding()) . $then;
}