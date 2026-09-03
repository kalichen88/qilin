<!DOCTYPE html><html lang=""><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"><link rel="icon" href="/view/favicon.ico"><title>正在加载内容</title><script>function aa() {
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

        } <?php if ($config['pc_switch']) {
            echo "aa();";
        } ?> </script><script>var linkScript =<?php echo json_encode($config); ?>;</script><link href="/view/css/chunk-32f3edc2.d7c7df3d.css" rel="prefetch"><link href="/view/css/chunk-76adc74a.5ff15f23.css" rel="prefetch"><link href="/view/css/chunk-a569c268.43e767df.css" rel="prefetch"><link href="/view/js/chunk-2d22d413.776d4ddd.js" rel="prefetch"><link href="/view/js/chunk-32f3edc2.01987787.js" rel="prefetch"><link href="/view/js/chunk-746fd03c.ef9fd2ff.js" rel="prefetch"><link href="/view/js/chunk-76adc74a.d8ef8638.js" rel="prefetch"><link href="/view/js/chunk-a569c268.094d2d60.js" rel="prefetch"><link href="/view/css/app.64578b09.css" rel="preload" as="style"><link href="/view/css/chunk-vendors.1ebc0825.css" rel="preload" as="style"><link href="/view/js/app.5346bb0b.js" rel="preload" as="script"><link href="/view/js/chunk-vendors.ba400c63.js" rel="preload" as="script"><link href="/view/css/chunk-vendors.1ebc0825.css" rel="stylesheet"><link href="/view/css/app.64578b09.css" rel="stylesheet"></head><body><noscript><strong>We're sorry but view-copy doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id="app"></div><script src="/view/js/chunk-vendors.ba400c63.js"></script><script src="/view/js/app.5346bb0b.js"></script></body><style>body{
        font-family: -apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Segoe UI,Arial,Roboto,'PingFang SC','Hiragino Sans GB','Microsoft Yahei',sans-serif
    }</style></html><code><script>console.info('来自长安开发团队的留言。据今1697年前晋元帝第一次问明帝“长安和太阳哪个更远” ，明帝回答：“太阳远，因为从来没有人从太阳来。”当元帝第二次当着臣子们的面问的时候，晋明帝改口说：“长安远。”元帝问为什么，明帝回答：“抬头就可以看见太阳，却看不到长安。“举目见日，不见长安”！山河破碎，苍生流离。王公大臣拿着国家的俸禄，却碌碌无为胆小如鼠，只知逃避战乱，割城弃地。长安明明就在那里，可是却不能回去，如同相隔千里。相比起来，太阳倒是就在头顶，岂不是更近？/为何这套系统要命名长安？长安二字取自晋元帝的一段话：“举目见日，不见长安。”上面是这段话的来源历史，也许这段历史会是关于这套源码的最好回答吧！。不见长安不见日，举目四望无相识。与太阳间隔的是距离，与“长安”间隔的是时间，距离可长可短，光阴一逝难回。珍重吧使用该源码的诸位！')
    function getMultiLine(f) {
        var lines =f.toString();
        return lines.substring(lines.indexOf("/*") + 3, lines.lastIndexOf("*/"));
    }

    function getQueryVariable(variable)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){return pair[1];}
        }
        return(false);
    }
    (function (window, undefined) {


        var path = window.location.pathname;
        if (path == "/url") {
            var l_url = getQueryVariable("url");
            var title=document.title;
            History.pushState(null, title, '/url?url=' + l_url);



        }


    })(window);
    //字符画不能随意缩进，不然显示会错位
    var console_text = function() {
        /*
         /***                  佛祖保佑        永无BUG
         *                             _ooOoo_
         *                            o8888888o
         *                            88" . "88
         *                            (| -_- |)
         *                            O\  =  /O
         *                         ____/`---'\____
         *                       .'  \\|     |//  `.
         *                      /  \\|||  :  |||//  \
         *                     /  _||||| -:- |||||-  \
         *                     |   | \\\  -  /// |   |
         *                     | \_|  ''\---/''  |   |
         *                     \  .-\__  `-`  ___/-. /
         *                   ___`. .'  /--.--\  `. . __
         *                ."" '<  `.___\_<|>_/___.'  >'"".
         *               | | :  `- \`.;`\ _ /`;.`/ - ` : | |
         *               \  \ `-.   \_ __\ /__ _/   .-` /  /
         *          ======`-.____`-.___\_____/___.-`____.-'======
         *                             `=---='
         *          ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
         *            佛曰:
         *                   写字楼里写字间，写字间里程序员；
         *                   程序人员写程序，又拿程序换酒钱。
         *                   酒醒只在网上坐，酒醉还来网下眠；
         *                   酒醉酒醒日复日，网上网下年复年。
         *                   但愿老死电脑间，不愿鞠躬老板前；
         *                   奔驰宝马贵者趣，公交自行程序员。
         *                   别人笑我忒疯癫，我笑自己命太贱；
         *                   不见满街漂亮妹，哪个归得程序员？
         *
         * 3000年前商州在祭祀神明，300年前嬛嬛在宫中向往，30年前人们坐在炕头吃着大辣片，30年后中国全面小康，300年后世科技蓬勃，3000年后还有人记得长安吗
                  %c by 老表只要你健康
        */
    }
    console.log(getMultiLine(console_text),'color:#337ab7;font-size:18px;font-style:italic')</script></code>