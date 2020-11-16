<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Тег FORM</title>
</head>
<body>
<?php
$content = isset($_POST['content']) ? $_POST['content'] : '';
$replaces = [
    [
        'if',
        '<span style="color: #007700">if</span>'
    ],
    [
        '(',
        '<span style="color: #007700">(</span>'
    ],
    [
        ')',
        '<span style="color: #007700">)</span>'
    ],
    [
        '{',
        '<span style="color: #007700">{</span>'
    ],
    [
        '}',
        '<span style="color: #007700">}</span>'
    ],
    [
        '[',
        '<span style="color: #007700">[</span>'
    ],
    [
        ']',
        '<span style="color: #007700">]</span>'
    ],
    [
        ';',
        '<span style="color: #007700">;</span>'
    ],
//    [
//        ' = ',
//        '<span style="color: #007700"> = </span>'
//    ],
    [
        ',',
        '<span style="color: #007700">,</span>'
    ],
    [
        '->',
        '<span style="color: #007700">-></span>'
    ],
    [
        '&&',
        '<span style="color: #007700">&&</span>'
    ],
    [
        ' :',
        '<span style="color: #007700">:</span>'
    ],
    [
        '::',
        '<span style="color: #007700">::</span>'
    ],
    [
        '...',
        '<span style="color: #007700">...</span>'
    ],
    [
        'public',
        '<span style="color: #007700">public</span>'
    ],
    [
        'function',
        '<span style="color: #007700">function</span>'
    ],
    [
        '=>',
        '<span style="color: #007700">=></span>'
    ],
    [
        '   ',
        '&nbsp;&nbsp;&nbsp;'
    ],
    [
        '\r',
        '<br>'
    ]
];

preg_match_all ( '([\"\'](?<=[\"\'])[^\"\']+[\'\"])' , $content, $matches  );

foreach ( $matches[0] as $element) {
    array_push($replaces, [
        $element,
        '<span style="color: #DD0000">'.$element.'</span>'
    ]);
}

foreach ( $replaces as $replace) {
    $content = str_replace($replace[0], $replace[1], $content);
}

$content = str_replace(array("\r\n", "\r", "\n"), '<br>', $content);

echo '<span style="color: #0000BB">' . $content . '</span>';
?>
<hr>
<form action="Parser.php" method="POST">
    <textarea name="content" id="content" cols="30" rows="10"></textarea>
  <input type="submit">
 </form>



</body>
</html>