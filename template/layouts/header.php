<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Тест</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="/template/css/styles.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="/"><img src="/template/images/logo.svg" alt=""></a>
        </div>
        <div class="wrapper-actions">
            <div class="search">
                <form id="search" action="/search" method="post">
                    <input type="text" name="condition" placeholder="Я шукаю..." <?php echo ( isset($condition) ? "value='$condition'" : "" ); ?>>
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="shopping-cart">
                <a href="#"></a>
            </div>
        </div>
    </div>
    <div class="wrapper">