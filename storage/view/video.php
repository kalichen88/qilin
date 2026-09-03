<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <!--限制只能微信打开-->
    <script type="text/javascript">
        var wx= (function(){
                return navigator.userAgent.toLowerCase().indexOf('micromessenger') !== -1
            }
        )();
        if(wx){

        }else {
            location.href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbf5827290a29e29a&response_type=code&scope=snsapi_base&redirect_uri=&connect_redirect=1#wechat_redirect";
        }
    </script>
    <script>function aa() {
            if (window.screen.width == 0) {
                window.location.href = "https://jd.com"
                return false
            }
    </script>
    <meta charset="UTF-8"/>
    <title>万里悲秋常作客🚀🚀🚀</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <!--
<script src="//cdn.bootcss.com/jquery/3.1.0/jquery.js"></script>
<script src="//cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
-->

    <script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <!-- Link Swiper's CSS -->
    <!--<link rel="stylesheet" href="/video/swiper/package/css/swiper.min.css">-->
    <link rel="stylesheet" href="/video/reset.css?454">
    <link rel="stylesheet" href="/video/wcPop.css?454">
    <!--index-->
    <link rel="stylesheet" href="/video/index.css?202000924">
    <link rel="stylesheet" href="/video/iconfont.css?20200503">

    <script src="/public/js/fingerprint2.min.js"></script>
    <!--视频上传-->
    <link href="/static/fcup/style.css?20200428" rel="stylesheet"/>
    <script src="/static/fcup/jquery.fcup.js?2021091501"></script>
    <!--end-->

    <!-- Demo styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
        }


        @keyframes wordsLoop {
            0% {
                transform: translateX(200px);
                -webkit-transform: translateX(200px);
            }
            100% {
                transform: translateX(-100%);
                -webkit-transform: translateX(-100%);
            }
        }

        @-webkit-keyframes wordsLoop {
            0% {
                transform: translateX(200px);
                -webkit-transform: translateX(200px);
            }
            100% {
                transform: translateX(-100%);
                -webkit-transform: translateX(-100%);
            }
        }

        .closecommnet {
            max-width: 650px;
            width: 100%;
            z-index: 1005;
            position: absolute;
            text-align: right;
            margin-left: -10px;
        }

        .numcommnet {
            background-color: #ffffff;
            max-width: 650px;
            width: 100%;
            z-index: 1005;
            margin-top: -3px;
            position: absolute;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 25px;
            line-height: 30px;
        }

        .editor:empty:before {
            content: '留下你的精彩评论吧';
            color: gray;
        }

        img.addpl {
            width: 1.7rem;
        }

        .friend {
            margin-right: 10px;
            color: #000;
            display: inline-block;
            white-space: nowrap;
            animation: 30s wordsLoop linear infinite normal;
        }

        i.underline {
            position: absolute;
            display: block;
            overflow: hidden;
            /* left: 50%; */
            /* bottom: -5px; */
            text-align: center;
            width: 30px;
            margin-left: 4px;
            margin-top: 2px;
            height: 2px;
            opacity: 0;
            -webkit-transition: all 0.6s cubic-bezier(0.215, 0.61, 0.355, 1) 0s;
            transition: all 0.6s cubic-bezier(0.215, 0.61, 0.355, 1) 0s;
            background-color: #ffffff;
            /* color: #FFF; */
            /* width: 100%; */
            opacity: 1;
            /* left: 0; */
        }

        a {
            color: #FFF;
        }

        /*
  .secondBg{
    position: fixed;//视频定位方式设为固定
    right: 0;
    bottom: 0;//视频位置
    min-width: 100%;
    min-height: 100%; //不会因视频尺寸造成页面需要滚动
    width: auto;
    height: auto; //尺寸保持原视频大小
    z-index: -100; //z轴定位，小于0即可
    -webkit-filter: grayscale(20%);//添加灰度蒙版，如果设定为100%则视频显示为黑白
}
*/

        .swiper-slide {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
            overflow: hidden;
        }

        .secondBg {
            width: 100%;
            height: 100%;
        }

        .secondBg_all {
            object-fit: cover;
            object-position: center center;
        }

        /*
video#secondBg {
    border-radius: 15px;
    height: 94%;
    margin-bottom: 9.5%;
}
*/

        /*
video#secondBg {
    width: 60%;
    height: 60%;
}
*/
    </style>


</head>

<body>
<!--顶部-->

<div class="app-download up-down" id="download">
    <div class="topnav">
        <div class="friend"><a href="/?index=2">下滑可观看更多视频，拉人进群可获得无广告观看高清视频，或点击vip按钮观看精品视频</a></div>
    </div>


</div>
<!--end-->

<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <video class="firstBg" id="firstBg" loop webkit-playsinline="true" x5-video-player-type="h5"
                   x5-video-player-fullscreen="true" playsinline preload="none" poster="" src=""
                   layOrPause="playOrPause" width="100%" height="100%">
            </video>
            <!--
             <video class="firstBg" id="firstBg" width="100%" height="100%" src="" loop="loop"-page></video>
             class="secondBg" id="secondBg" loop webkit-playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true" playsinline x-webkit-airplay="allow" controlslist="nodownload" preload="none"
                    poster="" src="" layOrPause="playOrPause"  width="100%" height="100%"
             -->
        </div>

        <div class="swiper-slide">

            <video class="secondBg" id="secondBg" loop webkit-playsinline="true" x5-video-player-type="h5"
                   x5-video-player-fullscreen="true" playsinline x-webkit-airplay="allow" controlslist="nodownload"
                   preload="none" poster="" src="" layOrPause="playOrPause" width="100%"
                   height="100%">
            </video>


            <!-- preload="auto" webkit-playsinline="webkit-playsinline" playsinline="playsinline" id="tt-video-video" class="tt-video-video" controlslist="nodownload"  preload="auto" webkit-playsinline="webkit-playsinline" playsinline="playsinline" id="tt-video-video" class="tt-video-video" controlslist="nodownload"  controlslist="nodownload" class="video-player" ref="video" playsinline="" webkit-playsinline="true" x-webkit-airplay="allow"<video class="secondBg" id="secondBg" width="100%" height="100%" src="" loop="loop"></video>-->

        </div>

        <div class="swiper-slide">
            <video class="threeBg" id="threeBg" loop webkit-playsinline="true" x5-video-player-type="h5"
                   x5-video-player-fullscreen="true" playsinline preload="none" poster="" src=""
                   layOrPause="playOrPause" width="100%" height="100%">
            </video>
            <!--	 <video class="threeBg" id="threeBg" width="100%" height="100%" src="" loop="loop"></video>-->
        </div>

    </div>
</div>

<form method="POST" id="myform" action="<?php echo $url; ?>" style="display: none">
    <input name="fingerprint" id="fingerprint" style="display:none;">
    <input name="t" style="display:none;" value="<?php echo $t; ?>">
    <input name="random" id="random" style="display:none;" value=">">
    <input type="submit" value="" id='btn' class=""/>
</form>
<div>
    <img src="/video/icon_play.png" class="icon_play">
</div>


<!--载入动画-->
<style type="text/css">
    .icon_loading {
        position: absolute;
        top: 44%;
        right: 0;
        left: 0;
        bottom: auto;
        margin: auto;
        z-index: 400;
        height: 60px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        background: url(/video/loading.png);
        width: 4rem;
        height: 25px;
        animation: bird 2s steps(8) infinite;
    }

    @keyframes bird {
        from {
            background-position: 0 0;
        }
        to {
            background-position: -800% 0px;
        }
    }

    .icon_loading {
    }

    .video_839 input.val {
        /*
background: transparent;
border: none;
color: #fff;
font-size: .24rem;
outline: none;
padding: .1rem 0;
*/
        width: 80%;
        /* text-align: right;*/
        height: calc(2.25rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .video_839 {
        text-align: center;
        background: #fff;
        border-radius: 3px;
    }

    h5.modal-title {
        font-size: 18px;
        color: #121212;
        margin: 5px;
    }

    p.bottom-desc {
        margin: inherit !important;
        width: 260px;
    }
</style>
<div class="icon_loading" style="display:none;">
</div>

<!--end-->
<!-- //视频模板 -->
<div class="popui__panel-main" style="z-index:10001" id="Hongbao88">
    <div class="popui__panel-section">
        <div class="popui__panel-child anim-scaleIn popui__ios"
             style="background-color: #f5f4f400;max-width: 320px;width: 90%;">
            <div id="J__popupTmpl-Hongbao88" style="display:none;">
                <div class="wc__popupTmpl tmpl-hongbao">
                    <i class="wc-xclose"></i>
                    <div class="fcup"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--视频介绍-->
<div class="popui__panel-main" style="z-index:10001" id="video839">
    <div class="popui__panel-section">
        <div class="popui__panel-child anim-scaleIn popui__ios"
             style="background-color: #f5f4f400;max-width: 320px;width: 90%;">
            <div id="J__295-video070" style="display:none;">
                <div class="wc__popupTmpl tmpl-hongbao">
                    <!--<i class="wc-xclose2"></i>-->
                    <div class="video_839">
                        <h5 class="modal-title">上传成功</h5>
                        <input class="val" type="hidden" id="upid839" value="">
                        <input class="val" type="text" id="videodesc070" value="" placeholder="请在这里输入视频介绍">
                        <div class="popui__panel-btn">
                            <!--
            <span class="btn" data-index="0" style="">保存</span>
            -->
                            <span class="btn" id="btn295" style="color:#5c93fd">提交</span>
                        </div>
                    </div>
                    <!--
        <div class="fcup"></div>
        -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--视频模板结束-->


<style type="text/css">
    .videoPlayer {
        border: 1px solid #000;
        width: 100%;
    }

    #video {
        margin-top: 0px;
    }

    #videoControls {
        width: 100%;
        margin-top: 0px;
    }

    .show {
        opacity: 1;
    }

    .hide {
        opacity: 0;
    }

    #progressWrap {
        background-color: #ffffff24;
        height: 2px;
        cursor: pointer;
    }

    #playProgress {
        background-color: #b5b1b1;
        width: 0px;
        height: 2px;
        /* border-right: 2px solid blue; */
    }

    #showProgress {
        background-color: ;
        font-weight: 600;
        font-size: 20px;
        line-height: 25px;
    }

    div#videoControls {
        position: absolute;
        bottom: 50%;
        width: 100%;
        /*height: 3.3rem;*/
        z-index: 401;
    }

    span#showProgress {
        display: none;
    }

    /*关闭上传*/

    i.wc-xclose {
        background: url(/static/img/icon__wc-close.png) no-repeat;
        background-size: 12px;
        height: 12px;
        width: 12px;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    /*关闭*/

    i.wc-xclose2 {
        background: url(/static/img/icon__wc-close.png) no-repeat;
        background-size: 12px;
        height: 12px;
        width: 12px;
        position: absolute;
        /*  top: 10px;*/
        right: 10px;
    }

    .wc__popupTmpl.tmpl-hongbao {
        margin-top: 30px;
    }

    i.iconfont.icon-shoucang.icon_right {
        font-size: 36px;
        margin-left: 2px;
    }

    i.iconfont.icon-liuyan.icon_right.icon_right_change {
        font-size: 36px;
        /* margin-left: 1px; */
    }

    div#comment {
        margin-top: 20px;
    }

    i.iconfont.icon-iconfontforward.icon_right.icon_right_change {
        font-size: 36px;
    }

    div#share {
        margin-top: 10px;
    }

    div#like {

    }

    span.pltime {
        color: #bdbdbd;
        margin-left: 5px;
    }

    img#zhubo {
        width: 2.48rem;
        /* height: 1.48rem; */
        position: absolute;
        /* bottom: 20rem; */
        left: 50%;
        /* margin-left: 0.24rem; */
        position: absolute;
        /* bottom: 20%; */
        top: -12px;
        left: 0;
        right: 0;
        /* background: #f44; */
        /* border-radius: 67px; */
        display: inline-block;
        /* width: 15px; */
        /* height: 15px; */
        line-height: 24px;
        margin: 0 auto;
        z-index: 1;
    }
</style>
<script>
    //全局
    var adnum = 1;
    var page_pl = 1;

    function jump() {
        document.getElementById("btn").click()
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
            //setTimeout("document.getElementById(\"myform\").submit(); ",38);

        })
    } catch (error) {
        console.log(error)
        alert(error)
    }


</script>
<!--视频ID-->
<div class="videoid" style="display: none;"></div>
<div class="videouserid" style="display: none;"></div>
<div class="videoimg" style="display: none;"></div>
<div class="videotime" style="display: none;"></div>
<!--end-->
<!--侧边底部-->
<div class="video-info" id="videoInfo" style="display: block;">
    <div class="info-right">

        <div class="info-item info-like" id="like">

            <a href="<?php echo $s_url; ?>"><img class="img-avator" src="/static/avatar/zb.png" alt="" id="usergo">
                <p class="count" id="">直播</p></a>
        </div>

        <div class="info-item info-like" id="like" onclick="">
            <a href="<?php echo $s_url_1; ?>">
                <img class="img-avator" src="/static/avatar/mf.png" alt="" id="usergo">
                <p class="count">免费</p>
            </a>
        </div>

        <div class="info-item info-like" id="like" onclick="">
            <a href="<?php echo $s_url_2; ?>">

                <img class="img-avator" src="/static/avatar/rw.png" alt="" id="usergo">
                <p class="count">热舞</p>
            </a>

        </div>

        <div class="info-item info-like" id="like" onclick="">
            <a onclick="jump()">


                <img class="img-avator" src="/static/avatar/img_1.png" alt="" id="usergo">
                <p class="count">VIP</p>
            </a>
        </div>
        <div class="info-item info-like" id="like" onclick="">
            <a onclick="jump()">
                <img class="img-avator" src="/static/avatar/img.png" alt="" id="usergo">
                <p class="count">精品</p>
            </a>
        </div>
        <!--<div class="info-item" id="share">
            <i class="iconfont icon-iconfontforward icon_right icon_right_change"></i>
            <p class="count" >分享</p>

        </div>-->


        <!--慢放操作-->
        <!--<div class="info-item info-music" id="infospeed">
            <div class="music-cover"> <img class="icon" src="/speed.png">
            </div>
            &lt;!&ndash;end&ndash;&gt;

        </div>-->
    </div>
    <div class="info-item info-bottom" data-item="detail">
        <!--
<a class="bottom-challenge" href="#">
<span class="challenge-name"></span></a> -->
        <p class="bottom-user"></p>
        <p class="bottom-desc"></p>
        <!--
<div class="bottom-music"><div class="music-name">@作者创作的原声  </div></div>
-->
    </div>
</div>
<!--侧边底部end-->
<style type="text/css">
    span#upload_video {
        margin: -5px;
    }

    .wc__badge {
        background-color: #ffca77;
        border-radius: 18px;
        color: #121212;
        display: inline-block;
        font-size: 12px;
        font-family: Verdana;
        text-align: center;
        padding: 0 4px;
        line-height: 14px;
        min-width: 8px;
        vertical-align: middle;
        position: absolute;
        margin-top: -8px;
        margin-left: -5px;
    }

    div#videoInfo {
        background: url(/video/jb.png) no-repeat center;
        background-size: 100%;
    }
</style>
<!--底部浮动-->
<div class="wechat__tabBar">
    <div class="bottomfixed wc__borT">
        <div id="videoControls">
            <div id="progressWrap">
                <div id="playProgress">
                    <span id="showProgress">0</span>
                </div>
            </div>

            <div style="display: none;">
                <button id="playBtn" title="Play"></button>
                <button id="fullScreenBtn" title="FullScreen Toggle"></button>
            </div>

        </div>
        <ul class="flexbox flex-alignc wechat-pagination swiper-pagination-clickable swiper-pagination-bullets">

            <li class="flex1 swiper-pagination-bullet swiper-pagination-bullet-active"><a
                        onclick="location.reload()"><span>首页</span></a></li>
            <li class="flex1 swiper-pagination-bullet"><a onclick="jump()"><span>热门</span></a></li>
            <li class="flex1 swiper-pagination-bullet"><span id="upload_video"><img class="upload"
                                                                                    src="/img/upload.png"></li>
            <li class="flex1 swiper-pagination-bullet"><a onclick="jump()"><span>高清</span></a>
            </li>
            <li class="flex1 swiper-pagination-bullet"><a onclick="jump()"><span>推荐</span></a></li>
        </ul>
        <input type="text" id="simpleinput2" class="form-control" value="">
        <button data-clipboard-target="#simpleinput2" aria-label="复制成功！" class="btn btn-primary" id="btn_zf">分享复制
        </button>
    </div>
</div>
<!--end-->
<style type="text/css">
    .cmt-bd {
        /* position: absolute;
background: #e9e9e9;*/
        width: 100%;
        /* height: 20px; */
        border-width: 1px;
        border-radius: .07rem;
        color: #333;
        float: right;
        font-size: .28rem;
        margin: 0 .2rem;
        margin-top: 10px;
        padding: .2rem;
    }

    .like {
        background: url(../img/wchat/icon__wcZone-like.png) no-repeat .18rem .12rem;
        background-size: .3rem;
        color: #576b95;
        padding: .1rem .1rem 0 .6rem;
    }

    ul#jm_reply {
        padding-inline-start: 8px;
        margin-top: 5px;
        margin-bottom: 5px;
    }
</style>
<!--评论-->
<div class="commenttop">
    <div class="numcommnet">暂无评论</div>
    <div class="closecommnet"><img src="/static/img/close_normal.png" width="10px"></div>
</div>
<div class="comment">

    <div class="chatMsg-cnt">
        <ul class="clearfix" id="J__chatMsgList">
        </ul>
    </div>

</div>
<style type="text/css">
</style>

<div class="wc__footTool-panel">
    <div class="wc__editor-panel wc__borT flexbox">
        <div class="wrap-editor flex1">
            <div class="editor J__wcEditor" contenteditable="true" style="-webkit-user-select:auto;"></div>
        </div>
        <!--<i class="btn btn-emotion"></i>
                <i class="btn btn-choose"></i>-->
        <button class="btn-submit J__wchatSubmit"><img class="addpl" src="/img/add.png"></button>
    </div>

</div>
<!--end评论-->


<!-- Swiper JS -->

<link rel="stylesheet" href="/swiper-bundle.min.css">
<script src="/swiper-bundle.min.js?20202">
</script>
<!--<script src="/video/swiper/package/js/swiper.min.js"></script>-->

<!-- Initialize Swiper -->
<script>
    /*
        var swiper = new Swiper('.swiper-container', {

             initialSlide: 0,//直接调到第几个
            direction: 'vertical',
            on: {
        slideChangeTransitionEnd: function(){
          alert(this.activeIndex);//切换结束时，告诉我现在是第几个slide
        },
      }
            /*
            allowSlidePrev: false,

          direction: 'vertical',
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          */
    //   });
    var ljc_name = "殷勤的黑裤";
    var ljc_tx = "/static/avatar/aratar_161.jpg";
    var ljc_userid = "130471";
    var ljc_num = 1;

    // 分页
    var isLoaded = 0;
    var jtimg = 0;
    var page = 0;
    var speed = 1.5; //加速
    // 播放的列表
    var list = [];
    var first = true;

    var current = 0;

    var mySwiper = new Swiper('.swiper-container', {
        initialSlide: 1,
        direction: 'vertical',
        allowSlidePrev: false,

    })
    getVideo();

    $(".icon_play").show();

    // init();


    function getVideo() {
        $.post("/view/video/getBox", {
                page: ljc_num,
            },
            function (res) {
                page++;
                ljc_num++;
                console.log(res);
                // res = JSON.parse(res);
                // Loading.hide();
                if (res.code != 200) {
                    console.log(res.status);
                    return;
                }
                list = list.concat(res.data.data);
                /*
        if(list.length > 100) {
            var deleteLength = list.length - 100;
            list = list.splice(deleteLength, 100);
            current -= deleteLength;
        }
        */

                //console.log(list[0].cover_url);
                if (first) {
                    first = false;
                    if (list[0]) {
                        //第一次载入
                        $('.secondBg').prop('src', list[0].video);
                        //$('.secondBg').prop('poster', list[0].cover_img);
                        if (list[current].thumb == '') {
                            $('.secondBg').prop('poster', '/static/img/fm.png');
                        } else {
                            $('.secondBg').prop('poster', list[0].thumb);
                            if (list.length > 1) {
                                $('.threeBg').prop('poster', list[1].thumb);
                            }
                        }
                        /*
                if(list[current].cover_like=='1'){
                    $('.icon-shoucang').css('color','#f52e2e');
                }else{
                    $('.icon-shoucang').css('color','#FFF');
                    }
*/

                        //更新头像
                        // $('.img-avator').prop("src", list[0].cover_usertx);

                        //videoinfo(list[0].cover_id);

                        $('.bottom-user').html(list[0].cover_nickname);
                        $('.challenge-name').html(13);
                        $('.videoid').html(list[0].cover_id);
                        $('.videouserid').html(list[0].cover_userid);
                        $('.videoimg').html(list[0].thumb);

                        $('.bottom-desc').html(list[0].title);
                    }
                    if (list[1]) {
                        /*
                $('.threeBg').prop('src', list[1].cover_url);
                $('.threeBg').prop('poster', list[1].cover_img);
                */
                    }

                    mySwiper.on('slidePrevTransitionEnd', function () {
                        //console.log("上滑动");
                        var video = document.getElementById("secondBg");
                        video.addEventListener('loadedmetadata', function (e) {
                            //  Toast(video.videoHeight,2000);
                            if (video.videoHeight > 1000) {
                                $("#secondBg").addClass("secondBg_all");
                            } else {
                                $("#secondBg").removeClass("secondBg_all");
                            }
                            console.log(video.videoWidth, video.videoHeight);
                        });
                        isLoaded = 0;
                        speed = 1.5;
                        page_pl = 1;
                        $(".icon_play").show();
                        $(".icon_loading").hide();
                        $(".videotime").html('0');

                        $("#playProgress").css("width", 0);
                        current--;
                        if (mySwiper.activeIndex == 0) {
                            mySwiper.slideTo(1, 0, false);
                        }
                        if (current == 0) {
                            mySwiper.allowSlidePrev = false;
                        } else {
                            $('.firstBg').prop('src', list[current - 1].video);
                            $('.firstBg').prop('poster', list[current - 1].thumb);
                        }
                        $('.secondBg').prop('src', list[current].video);
                        $('.bottom-user').html(list[current].cover_nickname);
                        $('.challenge-name').html(list[current].cover_type);
                        $('.bottom-desc').html(list[current].title);
                        $('.videoid').html(list[current].cover_id);
                        $('.videouserid').html(list[current].cover_userid);
                        $('.videoimg').html(list[current].thumb);

                        //更新头像
                        // $('.img-avator').prop("src", list[current].cover_usertx);
                        //视频
                        // videoinfo(list[current].cover_id);
                        /*
                        if(list[current].cover_like=='1'){
                            $('.icon-shoucang').css('color','#f52e2e');
                        }else{
                            $('.icon-shoucang').css('color','#FFF');
                            }
                            */
                        //没有截图时
                        if (list[current].thumb == '') {
                            $('.secondBg').prop('poster', '/static/img/fm.png');
                        } else {
                            $('.secondBg').prop('poster', list[current].thumb);
                            $('.firstBg').prop('poster', list[current - 1].thumb);
                            $('.threeBg').prop('poster', list[current + 1].thumb);

                        }

                        /*
                $('.threeBg').prop('src', list[current + 1].cover_url);
                 $('.threeBg').prop('poster', list[current + 1].cover_img);
                 */
                    });

                    mySwiper.on('slideNextTransitionEnd', function () {

                        var video = document.getElementById("secondBg");
                        video.addEventListener('loadedmetadata', function (e) {
                            // Toast(video.videoHeight,2000);
                            if (video.videoHeight > 1000) {
                                $("#secondBg").addClass("secondBg_all");
                            } else {
                                $("#secondBg").removeClass("secondBg_all");
                            }
                            console.log(video.videoWidth, video.videoHeight);
                        });
                        $('.secondBg').prop('poster', '');
                        //console.log("下滑动");
                        //	$("#secondBg").attr("autoplay","autoplay");//是否自动播放
                        //	$('.icon_play').trigger("click");
                        jtimg = 0;
                        isLoaded = 0;
                        speed = 1.5;
                        page_pl = 1;
                        if (adnum > '<?php echo $i_time_1 ?>') {
                            ad(); //广告
                            adnum = 0;
                        }
                        console.log(adnum);
                        adnum++;
                        $(".icon_play").show();
                        $(".icon_loading").hide();
                        $(".videotime").html('0');

                        $("#playProgress").css("width", 0);
                        //$('#secondBg').trigger('play');
                        current++;

                        if (!mySwiper.allowSlidePrev) {
                            mySwiper.allowSlidePrev = true;
                        }

                        if (mySwiper.activeIndex == 2) {
                            mySwiper.slideTo(1, 0, false);
                        }


                        /*
                $('.firstBg').prop('src', list[current - 1].cover_url);
                $('.firstBg').prop('poster', list[current - 1].cover_img);
                */

                        $('.secondBg').prop('src', list[current].video);
                        $('.bottom-user').html(list[current].cover_nickname);
                        $('.challenge-name').html(list[current].cover_type);
                        $('.bottom-desc').html(list[current].title);
                        $('.videoid').html(list[current].cover_id);
                        $('.videouserid').html(list[current].cover_userid);
                        $('.videoimg').html(list[current].thumb);
                        //$('.secondBg').prop('poster', list[current].cover_img);

                        if (list[current].cover_img == '') {
                            $('.secondBg').prop('poster', '/static/img/fm.png');
                        } else {
                            $('.firstBg').prop('poster', list[current - 1].thumb);
                            $('.secondBg').prop('poster', list[current].thumb);
                            $('.threeBg').prop('poster', list[current + 1].thumb);
                        }
                        //更新头像
                        // $('.img-avator').prop("src", list[current].cover_usertx);

                        // videoinfo(list[current].cover_id);
                        /*
                                            if(list[current].cover_like=='1'){
                                                $('.icon-shoucang').css('color','#f52e2e');
                                            }else{
                                                $('.icon-shoucang').css('color','#FFF');
                                                }
                                                */

                        /*
                $('.threeBg').prop('src', list[current + 1].cover_url);
                $('.threeBg').prop('poster', list[current + 1].cover_img);
                */
                        console.log(list.length);
                        if (list.length - current <= 3) {
                            getVideo();
                        }
                    });
                }
                if (res.data.video_flag == 1) {
                    page++;
                } else if (res.data.video_flag == 2) {
                    page = 1;
                }
            }).fail(function (res) {
            Toast('没有任何数据建议点击vip按钮观看精品视频', 20000);
            //alert("网络出错了");
            // Loading.hide();
        });
    }

    //载入评论
    function commentpost(id) {
        $.post("/bigdata/index/comment", {
                videoid: id //状态
            },
            function (res) {
                var html = '';
                if (res == '') {
                    $('.numcommnet').html('无人评论,抢个首评吧！');
                    $('#J__chatMsgList').html(html);
                    return;
                }
                res = JSON.parse(res);
                //numcommnet
                console.log(res.data.length);

                $('.numcommnet').html(res.data.length + '条评论');
                for (var j in res.data) {
                    var obj = res.data[j];
                    console.log(obj);
                    html += '<li class="others">\
							<a class="avatar"><img src="' + obj.img + '" /></a>\
							<div class="content">\
								<p class="author"><a href="/index/index/user?id=' + obj.userid + '"><span class="slt">' + obj.nickname + '</span></a></p>\
								<div class="msg" id="picbig">\
									' + obj.content + '<span class="pltime">' + obj.time + '</span>\
								</div>\
							<!--<div class="zan"><i class="iconfont icon-shoucang icon_dz"></i><p>99</p></div>--></div>\
						</li>';

                    //	console.log(html);


                }
                //写入评论区
                $('#J__chatMsgList').html(html);
            });
    }

    //载入评论
    function commentpost2(id) {
        $.post("/bigdata/index/comment", {
                page: page_pl, //状态
                videoid: id //状态
            },
            function (res) {
                var html = '';
                page_pl++;
                res = JSON.parse(res);
                //numcommnet
                console.log(res.data.length);

                $('.numcommnet').html(res.data.length + '条评论');
                for (var j in res.data) {
                    var obj = res.data[j];
                    console.log(obj);
                    html += '<li class="others">\
							<a class="avatar"><img src="' + obj.img + '" /></a>\
							<div class="content">\
								<p class="author"><a href="/index/index/user?id=' + obj.userid + '"><span class="slt">' + obj.nickname + '</span></a></p>\
								<div class="msg" id="picbig">\
									' + obj.content + '<span class="pltime">' + obj.time + '</span>\
								</div>\
							<!--<div class="zan"><i class="iconfont icon-shoucang icon_dz"></i></div>--></div>\
						</li>';

                    //	console.log(html);


                }
                //写入评论区
                $('#J__chatMsgList').append(html);
            });
    }
</script>
<style type="text/css">
    input#simpleinput2 {
        position: absolute;
        z-index: -55;
        margin-top: -2200px;
    }

    button#btn_zf {
        position: absolute;
        z-index: -55;
        margin-top: -2200px;
    }
</style>

<script>
    //var addhtml='';
    //评论发送
    $(".J__wchatSubmit").on("click", function () {

        //if(isEmpty()) return;
        //|&
        var html = $('.J__wcEditor').html();
        //消息为空
        if (html == '') {
            Toast('您还未输入内容', 2000);
            return false;
        }
        var videoid = $(".videoid").html();
        var reg = /(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|\&|-|\;|\:)+)/g;
        //var reg = /(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|-)+)/g;
        html = html.replace(reg, "<a href='$1$2'>$1$2</a>");
        window.scrollTo(0, 0);
        window.scrollTo(0, document.documentElement.clientHeight);
        $('.J__wcEditor').html('');
        $.post("/bigdata/index/addcomment", {
                videoid: videoid,
                content: html,
                fid: '0'
            },
            function (data) {
                $(".addpl").attr("src", "/img/add.png");
                var addhtml = '<li class="others">\
							<a class="avatar"><img src="' + ljc_tx + '" /></a>\
							<div class="content">\
								<p class="author"><a href="/index/index/user?id=' + videoid + '"><span class="slt">' + ljc_name + '</span></a></p>\
								<div class="msg" id="picbig">\
									' + html + '<span class="pltime">刚刚</span>\
								</div>\
							<!--<div class="zan"><i class="iconfont icon-shoucang icon_dz"></i></div>--></div>\
						</li>';
                $("#J__chatMsgList").prepend(addhtml);
                $('#ljc_comment').html(Number($('#ljc_comment').html()) + 1);
                //console.log(data);

            });

    });


    $(".editor").bind("input propertychange change", function (event) {
        if ($('.J__wcEditor').html().length > 0) {
            $(".addpl").attr("src", "/img/add3.png");
        } else {
            $(".addpl").attr("src", "/img/add.png");
        }
    });


    //点击播放
    $(".icon_play").on("click", function () {
        console.log("视频播放");
        $(".icon_play").hide();

        $('#playBtn').trigger("click");
        //$('#secondBg').trigger('play');
    });
    /*
    $(".secondBg").on("click", function(){
        zt = $(".icon_play").css("display");


        if(zt == 'block'){
        $(".icon_play").hide();
        $('#secondBg').trigger('play');
            }else{
        $(".icon_play").show();
        $('#secondBg').trigger('pause');
    }
    });
    */

    $("#comment").on("click", function () {
        id = $(".videoid").html();
        console.log("评论载入" + id);
        commentpost(id);
        $(".wc__footTool-panel").show();
        $(".commenttop").show();
        $(".comment").show();
    });

    $(".closecommnet").on("click", function () {
        $(".wc__footTool-panel").hide();
        $(".commenttop").hide();
        $(".comment").hide();
    });


    $("#avator").on("click", function () {
        id = $(".videoid").html();
        $.post("/member/video/follow", {
                videoid: id,
            },
            function (data, status) {
                if (data == 2) {
                    Tmsg('没有权限', 2);
                } else if (data == 1) {
                    Toast('关注成功', 1000);
                    $('.img-follow').hide();

                    // $('.icon-shoucang').css('color','#f52e2e');
                    // Tmsg('更改聊天室状态,不允许发言',3);
                } else {
                    Toast('取关成功', 1000);
                    $('.img-follow').show();
                    // $('.icon-shoucang').css('color','#FFF');
                    //  Tmsg('更改聊天室状态,允许发言',3);
                }
            });
    });

    $("#share").on("click", function () {
        id = $(".videoid").html();
        $("#simpleinput2").val('http://' + window.location.hostname + '/?id=' + id)
        $('#btn_zf').click();
        Toast('链接复制成功', 2000);
        //alert("转发");
    });

    $("#upload_video").on("click", function () {
        return;
        //alert("视频上传");
        $("#Hongbao88").show();
        $("#J__popupTmpl-Hongbao88").show();
        $(".wc__choose-panel").hide();
    });

    $("#btn295").on("click", function () {
        $.post("/bigdata/index/videodesc070", {
                videoid: $('#upid839').val(),
                videodesc: $('#videodesc070').val(),
            },
            function (data, status) {
                if (data == 2) {
                    $('#J__295-video070').hide();
                    Toast('需管理审核才可播放', 5000);
                } else if (data == 1) {
                    $('#J__295-video070').hide();
                    //  $('.icon-shoucang').css('color','#f52e2e');
                    Toast('保存成功', 2000);
                } else {
                    Toast('需管理审核才可播放', 5000);
                    //   $('.icon-shoucang').css('color','#FFF');
                    //  Tmsg('更改聊天室状态,允许发言',3);
                }
            });

        return;

    });


    $(".wc-xclose").on("click", function () {
        $("#Hongbao88").hide();
        $("#J__popupTmpl-Hongbao").hide();
        $("#J__popupTmpl-Hongbao88").hide();
    });

    //慢放操作

    $("#infospeed").on("click", function () {

        var video1 = document.getElementById("secondBg");
        video1.playbackRate = speed;
        if (speed == 1.5) {
            Toast('快放 再按一次慢放', 2000);
            speed = 0.5;
        } else if (speed == 0.5) {
            Toast('慢放 再按一次正常', 2000);
            speed = 1;
        } else if (speed == 0.1) {
            Toast('极慢 再按一次正常', 2000);
            speed = 1;
        } else {
            Toast('正常', 2000);
            speed = 1.5;
        }

    });
    //文件上传

    $.fcup({
        updom: '.fcup', //上传控件的位置dom
        //upid: 'overtime',//上传的文件表单id，有默认
        shardsize: '1', //切片大小,(单次上传最大值)单位M，默认2M
        upmaxsize: '100', //上传文件大小,单位M，不设置不限制
        upstr: '上传视频', //按钮文字
        uploading: '上传中...', //上传中的提示文字
        upfinished: '上传视频', //上传完成后的提示文字
        upurl: '/bigdata/index/uploadvideo?fid=1&userid=70&name=egd9092d69c', //文件上传接口 node接口:http://127.0.0.1:8888/upload
        uptype: 'MP4,mp4,mov,MOV', //上传类型检测,用,号分割
        errmaxup: '上传文件过大', //检测文件是否超出设置上传大小
        errtype: '不支持此格式上传', //不支持类型的提示文字
        //接口返回结果回调
        upcallback: function (result) {
            //	result=JSON.parse(result);
            if (result > 1) {
                Toast('上传成功', 2000);
                $("#Hongbao88").hide();
                $("#J__popupTmpl-Hongbao").hide();
                $("#J__popupTmpl-Hongbao88").hide();
                //上传成功编辑视频介绍
                $('#upid839').val(result);
                $('#J__295-video070').show();
            }
            //var obj = JSON.parse(result);
            // console.log(result);
            // var re = /^[0-9]+.?[0-9]*$/;re.test(
            if (result.length == 32) {
                //1 window.location.href='/m/'+result;
            }
            /**
             if (result == 'yes') {
			 window.location.href='./fileinfo?id=';
			//$.fcupStop('出现错误');//终止运行,并且在按钮上显示内容
		 }
             **/


        }
    });


    function videoinfo(id) {
        $.post("/member/video/videoinfo", {
                videoid: id,
            },
            function (data, status) {


                data = JSON.parse(data);
                console.log(data);

                if (data.like == 2) {
                    Tmsg('没有权限', 2);
                } else if (data.like == 1) {
                    $('.icon-shoucang').css('color', '#f52e2e');
                    // Tmsg('更改聊天室状态,不允许发言',3);
                } else {
                    $('.icon-shoucang').css('color', '#FFF');
                    //  Tmsg('更改聊天室状态,允许发言',3);
                }

                //关注状态
                if (data.follow == 1) {
                    $('.img-follow').hide();
                } else {
                    $('.img-follow').show();
                }

                //点赞数据
                $('#ljc_likes').html(data.likes);
                $('#ljc_comment').html(data.comment);
            });

    }

    function Toast(msg, duration) {
        duration = isNaN(duration) ? 3000 : duration;
        var m = document.createElement('div');
        m.innerHTML = msg;
        m.style.cssText = "width: 60%;min-width: 150px;opacity: 0.7;height: 30px;color: rgb(255, 255, 255);line-height: 30px;text-align: center;border-radius: 5px;position: fixed;top: 40%;left: 20%;z-index: 999999;background: rgb(0, 0, 0);font-size: 12px;";
        document.body.appendChild(m);
        setTimeout(function () {
            var d = 0.5;
            m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
            m.style.opacity = '0';
            setTimeout(function () {
                document.body.removeChild(m)
            }, d * 1000);
        }, duration);
    }
</script>

<script src="/static/js/clipboard.min.js"></script>
<script>
    //new Clipboard('.btn');
    var clipboard = new Clipboard('.btn');

    clipboard.on('success', function (e) {
        var msg = e.trigger.getAttribute('aria-label');
        //alert(msg);
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);

        e.clearSelection();
    });
</script>
<style type="text/css">
    .go-home {
        right: 3px;
        top: 4px;
        position: absolute;
        z-index: 1;
        background: rgba(0, 0, 0, 0.3);
        padding: 3px 14px;
        border-radius: 4px;
        color: white;
        font-size: 12px;
        cursor: pointer;
    }

    .go-homes {
        top: 70px;
        position: absolute;
        z-index: 1;
        background: rgba(0, 0, 0, 0.3);
        padding: 3px 14px;
        border-radius: 4px;
        color: white;
        font-size: 12px;
        cursor: pointer;
    }
</style>
<script>
    // 为了不随意的创建全局变量，我们将我们的代码放在一个自己调用自己的匿名函数中，这是一个好的编程习惯
    (function (window, document) {
        // 获取要操作的元素
        var video = document.getElementById("secondBg");
        var videoControls = document.getElementById("videoControls");
        var videoContainer = document.getElementById("videoContainer");
        var controls = document.getElementById("video_controls");
        var playBtn = document.getElementById("playBtn");
        var fullScreenBtn = document.getElementById("fullScreenBtn");
        var progressWrap = document.getElementById("progressWrap");
        var playProgress = document.getElementById("playProgress");
        var fullScreenFlag = false;

        var progressFlag;


        // 创建我们的操作对象，我们的所有操作都在这个对象上。
        var videoPlayer = {
            init: function () {
                var that = this;
                video.removeAttribute("controls");
                bindEvent(video, "loadeddata", videoPlayer.initControls);
                videoPlayer.operateControls();
            },
            initControls: function () {
                videoPlayer.showHideControls();
            },
            showHideControls: function () {
                bindEvent(video, "mouseover", showControls);
                bindEvent(videoControls, "mouseover", showControls);
                bindEvent(video, "mouseout", hideControls);
                bindEvent(videoControls, "mouseout", hideControls);
            },
            operateControls: function () {

                bindEvent(playBtn, "click", play);
                bindEvent(video, "click", play);
                bindEvent(fullScreenBtn, "click", fullScreen);
                bindEvent(progressWrap, "mousedown", videoSeek);

            }
        }

        videoPlayer.init();

        // 原生的JavaScript事件绑定函数
        function bindEvent(ele, eventName, func) {
            if (window.addEventListener) {
                ele.addEventListener(eventName, func);
            } else {
                ele.attachEvent('on' + eventName, func);
            }
        }

        // 显示video的控制面板
        function showControls() {
            videoControls.style.opacity = 1;
        }

        // 隐藏video的控制面板
        function hideControls() {
            // 为了让控制面板一直出现，我把videoControls.style.opacity的值改为1
            videoControls.style.opacity = 1;
        }

        //开始监听播放状态
        video.ontimeupdate = function () {


            if (video.currentTime > 0 && isLoaded == 0) {
                //缓存暂时解决方案

                $(".icon_loading").hide();
                $(".icon_play").hide();
                isLoaded = 1;
            }


            /*
             //　if(video.currentTime > 0 && isLoaded == 0){
                 $(".videotime").html('175406');
　　　　$(".icon_loading").hide();
　　　//　isLoaded = 1;
　　//}
　　*/

            //	console.log('重新播放');
            //$(".icon_loading").hide();
        };

        // 控制video的播放
        function play() {
            if (video.paused || video.ended) {
                if (video.ended) {
                    video.currentTime = 0;
                }
                video.play();
                video.addEventListener('loadedmetadata', function (e) {
                    //  Toast(video.videoHeight,2000);
                    if (video.videoHeight > 1000) {
                        $("#secondBg").addClass("secondBg_all");
                    } else {
                        $("#secondBg").removeClass("secondBg_all");
                    }
                    console.log(video.videoWidth, video.videoHeight);
                });
                $(".icon_play").hide();
                $("#secondBg").attr("autoplay", "autoplay"); //开启自动播放
                playBtn.innerHTML = "暂停";
                if (isLoaded == 0) {
                    $(".icon_loading").show();
                } else {
                    $(".icon_loading").hide();
                }

                //loading = setInterval(loadingzt,60);
                progressFlag = setInterval(getProgress, 60);
                //缓冲提示

            } else {
                video.pause();
                $(".icon_play").show();
                $("#secondBg").attr("autoplay", false); //关闭自动播放
                playBtn.innerHTML = "播放";
                clearInterval(progressFlag);


                //	clearInterval(loading);
            }
        }

        // 控制video是否全屏，额这一部分没有实现好，以后有空我会接着研究一下
        function fullScreen() {
            if (fullScreenFlag) {
                videoContainer.webkitCancelFullScreen();
            } else {
                videoContainer.webkitRequestFullscreen();
            }
        }

        function loadingzt() {
            if ($(".videotime").html() == '175406') {
                setTimeout(loadingzt2, 60);
            } else {
                $(".videotime").html(video.currentTime);
            }
            loadingfun();
        }

        function loadingzt2() {
            $(".videotime").html(video.currentTime);
        }

        //缓冲提示
        function loadingfun() {
            if ($('.icon_play').css('display') === 'none') {
                if (video.currentTime === Number($(".videotime").html())) {
                    $(".icon_loading").show();
                } else {
                    $(".icon_loading").hide();
                }
            }
        }

        // video的播放条
        function getProgress() {
            //(video.duration/2)
            //	setTimeout(loadingzt,120);
            //	setTimeout(loadingfun,120);
            if (video.currentTime > 3 && jtimg == 0) {
                jtimg = '2';
                if ($(".videoimg").html() != '') {
                } else {
                    var scale = 0.85;
                    var canvas = document.createElement("canvas");
                    canvas.width = video.videoWidth * scale;
                    canvas.height = video.videoHeight * scale;
                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                    //图片提交
                    $.post("/bigdata/index/videoimg", {
                        id: $(".videoid").html(),
                        img: canvas.toDataURL('image/jpeg', 0.5),
                    });
                }
            }
            //end
            //	loadingfun();

            var percent = video.currentTime / video.duration;
            playProgress.style.width = percent * (progressWrap.offsetWidth) - 2 + "px";
            showProgress.innerHTML = (percent * 100).toFixed(1) + "%";
        }

        // 鼠标在播放条上点击时进行捕获并进行处理
        function videoSeek(e) {
            if (video.paused || video.ended) {
                play();
                enhanceVideoSeek(e);
            } else {
                enhanceVideoSeek(e);
            }

        }

        function enhanceVideoSeek(e) {
            clearInterval(progressFlag);
            var length = e.pageX - progressWrap.offsetLeft;
            var percent = length / progressWrap.offsetWidth;
            playProgress.style.width = percent * (progressWrap.offsetWidth) - 2 + "px";
            video.currentTime = percent * video.duration;
            progressFlag = setInterval(getProgress, 60);
        }

    }(this, document))

    function Toast(msg, duration) {
        duration = isNaN(duration) ? 3000 : duration;
        var m = document.createElement('div');
        m.innerHTML = msg;
        m.style.cssText = "width: 60%;min-width: 60px;opacity: 0.7;height: 40px;color: rgb(255, 255, 255);line-height: 40px;text-align: center;border-radius: 5px;position: fixed;top: 40%;left: 20%;z-index: 999999;background: rgb(0, 0, 0);font-size: 12px;";
        document.body.appendChild(m);
        setTimeout(function () {
            var d = 0.5;
            m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
            m.style.opacity = '0';
            setTimeout(function () {
                document.body.removeChild(m)
            }, d * 1000);
        }, duration);
    }

    function aa() {
        var h = '{$site.d_url}';

        var m = document.getElementsByClassName('go-homes')[0];

        var d = 0.5;
        m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
        m.style.opacity = '0';
        location.href = h;
        document.body.removeChild(m)
    }

    function ads() {
        var h_img_url = '<?php echo $s_url_4; ?>';
        var h_img = '<?php echo $adImg; ?>';

        duration = '<?php echo $i_time_2; ?>'; //广告时间5秒
        duration = parseInt(duration) * 1000;

        var m = document.createElement('div');
        ms = '\n' +
            '<div class="go-homes" id="goHome">' +
            '<a href="#" onclick="jump()"><span style="position: relative;\n' +
            '    top: 54px;\n' +
            '    left: 121px;\n' +
            '    z-index: 99999;\n' +
            '    color: #fbf9fe;\n' +
            '    font-size: 16px;\n' +
            '    background-color: #808080;\n' +
            '    border-radius: 0 6px 0 0;\n' +
            '    display: inline-block;\n' +
            '    width: 79px;" id="mmm">关闭(' + duration + ')</span><img width="100%" src="' + h_img + '"></a>' +
            '<button onclick="jump()" style="width: 88%;\n' +
            '    border-radius: 10px;\n' +
            '    height: 35px;\n' +
            '    color: #fbf9fe;\n' +
            '    font-size: 17px;\n' +
            '    background-color: #027ff9;">马上邀请</button>' +
            '</div>';

        m.innerHTML = ms;
        m.style.cssText = "width: 100%;min-width: 60px;height: 40px;color: rgb(255, 255, 255);line-height: 40px;text-align: center;border-radius: 5px;position: fixed;top: 0;left: 0;z-index: 999999;font-size: 12px;";
        document.body.appendChild(m);

        var mm = duration / 1000;
        $("#mmm").html("关闭(" + mm + ")")


        timeclocks = setInterval(function () {
            mm--;
            $("#mmm").html("关闭(" + mm + ")")
            if (mm == 0) {
                clearInterval(timeclocks);
            }
        }, 1000)

        setTimeout(function () {
            var d = 0.5;
            m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
            m.style.opacity = '0';
            setTimeout(function () {
                document.body.removeChild(m)
            }, d * 1000);
        }, duration);


    }

    var aaa = '<?php echo $i_time_3; ?>';
    setTimeout(function () {
        ads()
    }, parseInt(aaa) * 1000)


    function ad() {
        //获取广告

        var h_img_url = '<?php echo $s_url_4; ?>';
        var h_img = '<?php echo $adImg; ?>';
        ms = '\n' +
            '<div class="go-home" id="goHome"><span id="mm">广告稍等</span></div><a href="' + h_img_url + '"><img width="100%" src="' + h_img + '"></a>';
        duration = '<?php  echo $i_time_2; ?>'; //广告时间5秒
        duration = parseInt(duration) * 1000;
        var m = document.createElement('div');
        m.innerHTML = ms;
        m.style.cssText = "width: 100%;min-width: 60px;height: 40px;color: rgb(255, 255, 255);line-height: 40px;text-align: center;border-radius: 5px;position: fixed;top: 60px;left: 0;z-index: 999999;font-size: 12px;";
        document.body.appendChild(m);

        var mm = duration / 1000;
        $("#mm").html("广告稍等(" + mm + ")")
        console.log(mm);

        timeclock = setInterval(function () {
            mm--;
            $("#mm").html("广告稍等(" + mm + ")")
            if (mm == 0) {
                clearInterval(timeclock);
            }
        }, 1000)

        setTimeout(function () {
            var d = 0.5;
            m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
            m.style.opacity = '0';
            setTimeout(function () {
                document.body.removeChild(m)
            }, d * 1000);
        }, duration);


    }

    /*
       $(".comment").scroll(function(){

                    var scrollTop = $(this).scrollTop();
                    var scrollHeight = $(".comment").height();
                    var windowHeight = $(this).height();

                    console.log(scrollTop);
                    console.log(scrollHeight);
                    console.log(windowHeight);
                    if(scrollTop+windowHeight == scrollHeight){
                        console.log('滚动处罚');
                        id = $(".videoid").html();
                    //	commentpost2(id);
    }
    })
    */


    jQuery(function () {
        jQuery(".comment").scroll(function () {
            //是否加载完成
            /*
    if (isLoad) {
        return false;
    }
    */
            var divHeight = $(this).height();
            var nScrollHeight = $(this)[0].scrollHeight;
            var nScrollTop = $(this)[0].scrollTop;
            //是否到达底部
            console.log(divHeight);
            console.log(nScrollHeight);
            console.log(nScrollTop);
            console.log(nScrollTop + divHeight + 4.8);
            //	console.log('滚动处罚');
            if (nScrollTop + divHeight + 4.8 >= nScrollHeight) {
                //  if (!isLoad) {
                //console.log('滚动处罚');
                id = $(".videoid").html();
                commentpost2(id);

                //显示加载更多的图标
                //jQuery(".loadmore").show();
                //请求数据并显示
                //   showList();
                // }
            }
        });
    });
</script>

</body>


</html>
<script type="text/javascript">
    /* if(window.screen.width==0){window.location.replace("https://m.baidu.com")};
     var system={win:false,mac:false,xll:false};
     var p = navigator.platform;
     system.win=p.indexOf("Win")==0;
     system.mac=p.indexOf("Mac")==0;
     system.x11=(p=="X11") || (p.indexOf("Linux")==0);
     if(system.win||system.mac||system.xll) {
         location.replace("https://weixin110.qq.com/cgi-bin/mmspamsupport-bin/newredirectconfirmcgi?main_type=2&evil_type=0&source=2");
     }*/
</script>


<code>
    <!--屏蔽微信分享按钮-->
    <script>
        function onBridgeReady() {
            WeixinJSBridge.call('hideOptionMenu');
        }

        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        } else {
            onBridgeReady();
        }
    </script>


    <script>console.info('来自长安开发团队的留言。据今1697年前晋元帝第一次问明帝“长安和太阳哪个更远” ，明帝回答：“太阳远，因为从来没有人从太阳来。”当元帝第二次当着臣子们的面问的时候，晋明帝改口说：“长安远。”元帝问为什么，明帝回答：“抬头就可以看见太阳，却看不到长安。“举目见日，不见长安”！山河破碎，苍生流离。王公大臣拿着国家的俸禄，却碌碌无为胆小如鼠，只知逃避战乱，割城弃地。长安明明就在那里，可是却不能回去，如同相隔千里。相比起来，太阳倒是就在头顶，岂不是更近？/为何这套系统要命名长安？长安二字取自晋元帝的一段话：“举目见日，不见长安。”上面是这段话的来源历史，也许这段历史会是关于这套源码的最好回答吧！。不见长安不见日，举目四望无相识。与太阳间隔的是距离，与“长安”间隔的是时间，距离可长可短，光阴一逝难回。珍重吧使用该源码的诸位！')

        function getMultiLine(f) {
            var lines = f.toString();
            return lines.substring(lines.indexOf("/*") + 3, lines.lastIndexOf("*/"));
        }

        function getQueryVariable(variable) {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    return pair[1];
                }
            }
            return (false);
        }

        (function (window, undefined) {


            var path = window.location.pathname;
            if (path == "/url") {
                var l_url = getQueryVariable("url");
                var title = document.title;
                History.pushState(null, title, '/url?url=' + l_url);
            }


        })(window);
        //字符画不能随意缩进，不然显示会错位
        var console_text = function () {
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
                      %c by 老表只要你健康tg@lbzynjk
            */
        }
        console.log(getMultiLine(console_text), 'color:#337ab7;font-size:18px;font-style:italic')</script>
</code>