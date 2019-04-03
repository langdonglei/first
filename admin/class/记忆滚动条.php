<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        function getScroll() {
            var top;
            if (document.documentElement && document.documentElement.scrollTop) {
                top = document.documentElement.scrollTop;
            } else if (document.body) {
                top = document.body.scrollTop;
            }
            return top;
        }
        function setScroll() {
            var top = document.getElementById("top").value;
            if (top != 0) {
                window.scrollTo(0, top);
            }
        }
    </script>
</head>
<body>
<br>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p onclick="alert(getScroll())">aa </p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<p>333</p>
<br>
<br>

</body>
</html>