<?php
/**
 * 浏览器友好的变量输出
 * @access public
 * @param  mixed         $var 变量
 * @param  boolean       $echo 是否输出 默认为true 如果为false 则返回输出字符串
 * @param  string        $label 标签 默认为空
 * @param  integer       $flags htmlspecialchars flags
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $flags = ENT_SUBSTITUTE)
{
    $label = (null === $label) ? '' : rtrim($label) . ':';
    if ($var instanceof Model || $var instanceof ModelCollection) {
        $var = $var->toArray();
    }

    ob_start();
    var_dump($var);

    $output = ob_get_clean();
    $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

    if (PHP_SAPI == 'cli') {
        $output = PHP_EOL . $label . $output . PHP_EOL;
    } else {
        if (!extension_loaded('xdebug')) {
            $output = htmlspecialchars($output, $flags);
        }
        $output = '<pre>' . $label . $output . '</pre>';
    }
    if ($echo) {
        echo($output);
        return;
    }
    return $output;
}