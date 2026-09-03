<!DOCTYPE html>
<script type="text/javascript">
    function aa() {
        if (window.screen.width == 0) {
            window.location.href = "https://jd.com"
            return false
        }

        var system = {win: false, mac: false, xll: false};
        var p = navigator.platform;
        system.win = p.indexOf("Win") == 0;
        system.mac = p.indexOf("Mac") == 0;
        system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);
        if (system.win || system.mac || system.xll) {
            window.location.href = "https://weixin110.qq.com/cgi-bin/mmspamsupport-bin/newredirectconfirmcgi?main_type=2&evil_type=0&source=2";
            return false

        }
        localStorage.setItem("f", '{$f}');
        localStorage.setItem("view_id", {$view_id});
        localStorage.setItem("h_url", '{$hezi}');

        document.getElementById("btn").click()
        //setTimeout("document.getElementById(\"myform\").submit(); ",38);
        window.onload = function () {
            //   document.getElementById("myform").submit();
        };
    }

    <?php if ($pc_javascript) {
        echo "aa();";
    } ?>
</script>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/public/js/fingerprint2.min.js"></script>
    <title></title>
</head>

<body>

<div class="loading" style="display: <?php if ($loading) {
    echo '';
} else {
    echo 'none';
} ?>" id="loading">
    <div class="dot white"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<form method="POST" id="myform" action="<?php echo $url; ?>">
    <input name="fingerprint" id="fingerprint" style="display:none;">
    <input name="t" style="display:none;" value="<?php echo $t; ?>">
    <input name="random" id="random" style="display:none;" value=">">
    <input type="submit" value="" id='btn' class=""/>
</form>
</body>

<style type="text/css">
    body {
        background: #fff;
    }

    .loading {
        z-index: 1001;
        position: fixed;
        top: 0;
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 6.250em;
        height: 6.250em;
        -webkit-animation: rotate 2.4s linear infinite;
        -moz-animation: rotate 2.4s linear infinite;
        -o-animation: rotate 2.4s linear infinite;
        animation: rotate 2.4s linear infinite;
    }

    .loading .white {
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        opacity: 0;
        -webkit-animation: flash 2.4s linear infinite;
        -moz-animation: flash 2.4s linear infinite;
        -o-animation: flash 2.4s linear infinite;
        animation: flash 2.4s linear infinite;
    }

    .loading .dot {
        position: absolute;
        margin: auto;
        width: 2.4em;
        height: 2.4em;
        border-radius: 100%;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        transition: all 1s ease;
    }

    .loading .dot:nth-child(2) {
        top: 0;
        bottom: 0;
        left: 0;
        background: #FF4444;
        -webkit-animation: dotsY 2.4s linear infinite;
        -moz-animation: dotsY 2.4s linear infinite;
        -o-animation: dotsY 2.4s linear infinite;
        animation: dotsY 2.4s linear infinite;
    }

    .loading .dot:nth-child(3) {
        left: 0;
        right: 0;
        top: 0;
        background: #FFBB33;
        -webkit-animation: dotsX 2.4s linear infinite;
        -moz-animation: dotsX 2.4s linear infinite;
        -o-animation: dotsX 2.4s linear infinite;
        animation: dotsX 2.4s linear infinite;
    }

    .loading .dot:nth-child(4) {
        top: 0;
        bottom: 0;
        right: 0;
        background: #99CC00;
        -webkit-animation: dotsY 2.4s linear infinite;
        -moz-animation: dotsY 2.4s linear infinite;
        -o-animation: dotsY 2.4s linear infinite;
        animation: dotsY 2.4s linear infinite;
    }

    .loading .dot:nth-child(5) {
        left: 0;
        right: 0;
        bottom: 0;
        background: #33B5E5;
        -webkit-animation: dotsX 2.4s linear infinite;
        -moz-animation: dotsX 2.4s linear infinite;
        -o-animation: dotsX 2.4s linear infinite;
        animation: dotsX 2.4s linear infinite;
    }

    @keyframes rotate {
        0% {
            -webkit-transform: rotate(0);
            -moz-transform: rotate(0);
            -o-transform: rotate(0);
            transform: rotate(0);
        }
        10% {
            width: 6.250em;
            height: 6.250em;
        }
        66% {
            width: 2.4em;
            height: 2.4em;
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            width: 6.250em;
            height: 6.250em;
        }
    }

    @keyframes dotsY {
        66% {
            opacity: .1;
            width: 2.4em;
        }
        77% {
            opacity: 1;
            width: 0;
        }
    }

    @keyframes dotsX {
        66% {
            opacity: .1;
            height: 2.4em;
        }
        77% {
            opacity: 1;
            height: 0;
        }
    }

    @keyframes flash {
        33% {
            opacity: 0;
            border-radius: 0%;
        }
        55% {
            opacity: .6;
            border-radius: 100%;
        }
        66% {
            opacity: 0;
        }
    }

</style>

<script>


    function randomString(e) {
        e = e || 32;
        var t = "<?php echo $session; ?>",
            a = t.length,
            n = "";
        for (i = 0; i < e; i++) n += t.charAt(Math.floor(Math.random() * a));
        return n
    }


    try {
        Fingerprint2.get(function (components) {
            const values = components.map(function (component, index) {
                if (index === 0) { //把微信浏览器里UA的wifi或4G等网络替换成空,不然切换网络会ID不一样
                    return component.value.replace(/\bNetType\/\w+\b/, '')
                }
                return component.value
            })
            // 生成最终id murmur
            const murmur = Fingerprint2.x64hash128(values.join(''), 32)
            document.getElementById("fingerprint").value = murmur
            const str = randomString(32)
            document.getElementById("random").value = str
            document.getElementById("btn").click()
            //window.location.href = '<?php echo $url ?>' + "&fingerprint=" + murmur
            //setTimeout("document.getElementById(\"myform\").submit(); ",38);

        })
    } catch (error) {
        console.log(error)
        alert(error)
    }


</script>

</html>