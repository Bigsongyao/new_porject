<?php defined('IN_IA') or exit('Access Denied');?><!-- PublicTopLayout Begin -->
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div id="vToolbar" class="nc-appbar">
  <div class="nc-appbar-tabs" id="appBarTabs">
    <div class="user TA_delay" nctype="a-barUserInfo">
      <div class="avatar"><img src="/addons/ewei_shopv2/plugin/pc/template/web/static/images/default_user_portrait.gif"/>
      </div>
      <p>我</p>
    </div>
    <div class="user-info" nctype="barUserInfo" style="display:none;"><i class="arrow"></i>
      <div class="avatar"><img src="/addons/ewei_shopv2/plugin/pc/template/web/static/images/default_user_portrait.gif"/>
        <div class="frame"></div>
      </div>
      <dl>
        <?php  if($user=check_login()) { ?>
        <dt>Hi, <?php  echo $user['nickname'];?></dt>
        <dd>真实姓名：<strong nctype="barMemberGrade"><?php  echo $user['realname'];?></strong>
        </dd>
        <dd>手机号码：<strong nctype="barMemberExp"><?php  echo $user['mobile'];?></strong>
        </dd>
        <?php  } else { ?>
        <a href="<?php  echo mobileUrl('pc.account.login')?>"><dt>立即登录</dt></a>
        <?php  } ?>
      </dl>
    </div>
    <ul class="tools">
      <li><a href="<?php  echo mobileUrl('pc.member.cart')?>" id="rtoolbar_cart" class="cart TA_delay">
          <div class="tools_img TA"></div>
          <span class="TA">购物车</span><i id="rtoobar_cart_count" class="new_msg" style="display:none;"></i></a></li>
      <li><a href="javascript:void(0);" id="gotop" class="gotop TA_delay">
          <div class="tools_img TA"></div>
          <span class="TA">顶部</span></a></li>
    </ul>
    <div class="content-box" id="content-compare">
      <div class="top">
        <h3>商品对比</h3>
        <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
      <div id="comparelist"></div>
    </div>
    <div class="content-box" id="content-cart">
      <div class="top">
        <h3>我的购物车</h3>
        <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
      <div id="rtoolbar_cartlist"></div>
    </div>
    <a id="activator" href="javascript:void(0);" class="nc-appbar-hide TA"></a></div>
  <div class="nc-hidebar" id="ncHideBar">
    <div class="nc-hidebar-bg">
      <div class="user-avatar"><img src="/addons/ewei_shopv2/plugin/pc/template/web/static/images/default_user_portrait.gif"/></div>
      <div class="frame"></div>
      <div class="show"></div>
    </div>
  </div>
</div>
<div class="public-top-layout w">
  <div class="topbar wrapper">
    <div class="user-entry">
      <?php  if($user=check_login()) { ?>
        您好
        <span><a href="<?php  echo mobileUrl('pc.member')?>"><?php  echo $user['nickname'];?></a></span>
        欢迎回来，
        <a href="<?php  echo mobileUrl('pc')?>" title="首页" alt="首页">
          <span></span>
        </a>
        <span>[<a href="<?php  echo mobileUrl('pc.account.logout')?>">退出</a>]</span>
      <?php  } else { ?>
        Hi，欢迎光临
        <a href="<?php  echo mobileUrl('pc')?>" title="首页" alt="首页">商城</a>
        <a href="<?php  echo mobileUrl('pc.account.login')?>">请登录</a></span>
        <span><a href="<?php  echo mobileUrl('pc.account.register')?>">免费注册</a></span>
      <?php  } ?>
    </div>

    <div class="quick-menu">

      <dl>
        <dt><em class="ico_order"></em><a href="<?php  echo mobileUrl('pc.order')?>">我的订单</a><i></i>
        </dt>
        <dd>
          <ul>
            <li>
              <a href="<?php  echo mobileUrl('pc.order',array('status'=>-2))?>">待付款订单</a>
            </li>
            <li>
              <a href="<?php  echo mobileUrl('pc.order',array('status'=>2))?>">待确认收货</a>
            </li>
            <li>
              <a href="<?php  echo mobileUrl('pc.order',array('status'=>3))?>">已完成交易</a>
            </li>
          </ul>
        </dd>
      </dl>
      <a href="<?php  echo mobileUrl('pc.member.favorite')?>" style="color:#777">
      <dl>
        <dt><em class="ico_store"></em>我的收藏<i></i>
        </dt>
      </dl>
      </a>
      <dl>
        <dt><em class="ico_service"></em>客户服务<i></i></dt>
        <dd>
          <ul>
            <?php  echo get_menus(2)?>

          </ul>
        </dd>
      </dl>

    </div>
  </div>
</div>
<script type="text/javascript">
  //返回顶部
  backTop = function (btnId) {
    var btn = document.getElementById(btnId);
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    window.onscroll = set;
    btn.onclick = function () {
      //btn.style.opacity="0.5";
      window.onscroll = null;
      this.timer = setInterval(function () {
        scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        scrollTop -= Math.ceil(scrollTop * 0.1);
        if (scrollTop == 0) clearInterval(btn.timer, window.onscroll = set);
        if (document.documentElement.scrollTop > 0) document.documentElement.scrollTop = scrollTop;
        if (document.body.scrollTop > 0) document.body.scrollTop = scrollTop;
      }, 10);
    };
    function set() {
      scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
      //btn.style.opacity=scrollTop?'1':"0.5";
    }
  };
  backTop('gotop');
  //动画显示边条内容区域
  $(function () {
    $(function () {
      $('#activator').click(function () {
        $('#content-cart').animate({'right': '-250px'});
        $('#content-compare').animate({'right': '-250px'});
        $('#vToolbar').animate({'right': '-60px'}, 300,
                function () {
                  $('#ncHideBar').animate({'right': '59px'}, 300);
                });
        $('div[nctype^="bar"]').hide();
      });
      $('#ncHideBar').click(function () {
        $('#ncHideBar').animate({
                  'right': '-86px'
                },
                300,
                function () {
                  $('#content-cart').animate({'right': '-250px'});
                  $('#content-compare').animate({'right': '-250px'});
                  $('#vToolbar').animate({'right': '6px'}, 300);
                });
      });
    });
    $("#compare").click(function () {
      if ($("#content-compare").css('right') == '-250px') {
        loadCompare(false);
        $('#content-cart').animate({'right': '-250px'});
        $("#content-compare").animate({right: '0px'});
      } else {
        $(".close").click();
        $(".chat-list").css("display", 'none');
      }
    });
    $(".close").click(function () {
      $(".content-box").animate({right: '-250px'});
    });

    $(".quick-menu dl").hover(function () {
              $(this).addClass("hover");
            },
            function () {
              $(this).removeClass("hover");
            });

    // 右侧bar用户信息
    $('div[nctype="a-barUserInfo"]').click(function () {
      $('div[nctype="barUserInfo"]').toggle();
    });

  });
</script>
<!-- PublicHeadLayout Begin -->