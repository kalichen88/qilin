<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="keywords"
      content="antd,umi,umijs,ant design,脚手架,布局, Ant Design,项目,Pro,admin,控制台,主页,开箱即用,中后台,解决方案,组件库"
    />
    <meta
      name="description"
      content="
    An out-of-box UI solution for enterprise applications as a React boilerplate."
    />
    <meta
      name="description"
      content="
      开箱即用的中台前端/设计解决方案。"
    />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
    />
    <title>Ant Design Pro</title>
    <link rel="icon" href="/manager/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/manager/umi.css" />
    <script>
      window.routerBase = "/";
    </script>
    <script>
      //! umi version: 3.4.11
    </script>
  </head>
  <body>
    <noscript>Out-of-the-box mid-stage front/design solution!</noscript>
    <div id="root">
      <style>
        html,
        body,
        #root {
          height: 100%;
          margin: 0;
          padding: 0;
        }
        #root {
          background-image: url("/manager/home_bg.png");
          background-repeat: no-repeat;
          background-size: 100% auto;
        }
        .page-loading-warp {
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 98px;
        }
        .ant-spin {
          position: absolute;
          display: none;
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
          margin: 0;
          padding: 0;
          color: rgba(0, 0, 0, 0.65);
          color: #1890ff;
          font-size: 14px;
          font-variant: tabular-nums;
          line-height: 1.5;
          text-align: center;
          list-style: none;
          opacity: 0;
          -webkit-transition: -webkit-transform 0.3s
            cubic-bezier(0.78, 0.14, 0.15, 0.86);
          transition: -webkit-transform 0.3s
            cubic-bezier(0.78, 0.14, 0.15, 0.86);
          transition: transform 0.3s cubic-bezier(0.78, 0.14, 0.15, 0.86);
          transition: transform 0.3s cubic-bezier(0.78, 0.14, 0.15, 0.86),
            -webkit-transform 0.3s cubic-bezier(0.78, 0.14, 0.15, 0.86);
          -webkit-font-feature-settings: "tnum";
          font-feature-settings: "tnum";
        }

        .ant-spin-spinning {
          position: static;
          display: inline-block;
          opacity: 1;
        }

        .ant-spin-dot {
          position: relative;
          display: inline-block;
          width: 20px;
          height: 20px;
          font-size: 20px;
        }

        .ant-spin-dot-item {
          position: absolute;
          display: block;
          width: 9px;
          height: 9px;
          background-color: #1890ff;
          border-radius: 100%;
          -webkit-transform: scale(0.75);
          -ms-transform: scale(0.75);
          transform: scale(0.75);
          -webkit-transform-origin: 50% 50%;
          -ms-transform-origin: 50% 50%;
          transform-origin: 50% 50%;
          opacity: 0.3;
          -webkit-animation: antspinmove 1s infinite linear alternate;
          animation: antSpinMove 1s infinite linear alternate;
        }

        .ant-spin-dot-item:nth-child(1) {
          top: 0;
          left: 0;
        }

        .ant-spin-dot-item:nth-child(2) {
          top: 0;
          right: 0;
          -webkit-animation-delay: 0.4s;
          animation-delay: 0.4s;
        }

        .ant-spin-dot-item:nth-child(3) {
          right: 0;
          bottom: 0;
          -webkit-animation-delay: 0.8s;
          animation-delay: 0.8s;
        }

        .ant-spin-dot-item:nth-child(4) {
          bottom: 0;
          left: 0;
          -webkit-animation-delay: 1.2s;
          animation-delay: 1.2s;
        }

        .ant-spin-dot-spin {
          -webkit-transform: rotate(45deg);
          -ms-transform: rotate(45deg);
          transform: rotate(45deg);
          -webkit-animation: antrotate 1.2s infinite linear;
          animation: antRotate 1.2s infinite linear;
        }

        .ant-spin-lg .ant-spin-dot {
          width: 32px;
          height: 32px;
          font-size: 32px;
        }

        .ant-spin-lg .ant-spin-dot i {
          width: 14px;
          height: 14px;
        }

        @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
          .ant-spin-blur {
            background: #fff;
            opacity: 0.5;
          }
        }

        @-webkit-keyframes antSpinMove {
          to {
            opacity: 1;
          }
        }

        @keyframes antSpinMove {
          to {
            opacity: 1;
          }
        }

        @-webkit-keyframes antRotate {
          to {
            -webkit-transform: rotate(405deg);
            transform: rotate(405deg);
          }
        }

        @keyframes antRotate {
          to {
            -webkit-transform: rotate(405deg);
            transform: rotate(405deg);
          }
        }
      </style>
      <div
        style="
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          height: 100%;
          min-height: 420px;
        "
      >
        <div class="page-loading-warp">
          <div class="ant-spin ant-spin-lg ant-spin-spinning">
            <span class="ant-spin-dot ant-spin-dot-spin"
              ><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i
              ><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i
            ></span>
          </div>
        </div>
        <div
          style="display: flex; align-items: center; justify-content: center"
        ></div>
      </div>
    </div>

    <script src="/manager/umi.js"></script>
  </body>
</html>

<code><script>
    console.info('来自长安开发团队的留言。据今1697年前晋元帝第一次问明帝“长安和太阳哪个更远” ，明帝回答：“太阳远，因为从来没有人从太阳来。”当元帝第二次当着臣子们的面问的时候，晋明帝改口说：“长安远。”元帝问为什么，明帝回答：“抬头就可以看见太阳，却看不到长安。“举目见日，不见长安”！山河破碎，苍生流离。王公大臣拿着国家的俸禄，却碌碌无为胆小如鼠，只知逃避战乱，割城弃地。长安明明就在那里，可是却不能回去，如同相隔千里。相比起来，太阳倒是就在头顶，岂不是更近？/为何这套系统要命名长安？长安二字取自晋元帝的一段话：“举目见日，不见长安。”上面是这段话的来源历史，也许这段历史会是关于这套源码的最好回答吧！。不见长安不见日，举目四望无相识。与太阳间隔的是距离，与“长安”间隔的是时间，距离可长可短，光阴一逝难回。珍重吧使用该源码的诸位！')
         function getMultiLine(f) {
var lines =f.toString(); 
return lines.substring(lines.indexOf("/*") + 3, lines.lastIndexOf("*/"));   
}
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
console.log(getMultiLine(console_text),'color:#337ab7;font-size:18px;font-style:italic')
</script>
</code>