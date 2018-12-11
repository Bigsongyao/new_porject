<?php defined('IN_IA') or exit('Access Denied');?><script type="text/html" id="show_temp_0">
    <style type="text/css">
        .diy-quick .quick-menu {background: <%style.catebg%>;}
        .diy-quick .quick-menu nav {background: <%style.catebg%>; color: <%style.catecolor%>;}
        .diy-quick .quick-menu nav.active {background: <%style.cateactivebg%>; color: <%style.cateactivecolor%>; border-color: <%style.cateactivecolor%>;}
        .diy-quick .quick-container .quick-title {background: <%style.righttitlebg%>; color: <%style.righttitle%>; border-color: <%style.righttitleborder%>;}
        .diy-quick .quick-container .quick-list {background: <%style.goodsbg%>;}
        .diy-quick .quick-container .quick-list .quick-item .info .title {color: <%style.goodstitle%>;}
        .diy-quick .quick-container .quick-list .quick-item .info .sales  {color: <%style.goodssales%>;}
        .diy-quick .quick-container .quick-list .quick-item .info .buyline .price  {color: <%style.goodsprice%>;}
        .diy-quick .quick-container .quick-list .quick-item .info .buyline .buy  {color: <%style.goodscart%>;}
        .diy-quick-footer {background: <%style.footerbg%>;}
        .diy-quick-footer .quick-cart .inner {background: <%style.footercart%>; border-color: <%style.footerbg%>; color: <%style.footercarticon%>;}
        .diy-quick-footer .quick-submit {background: <%style.footerbtn%>; color: <%style.footerbtntext%>;}
        .diy-quick-footer .quick-info {color: <%style.footertext%>;}
    </style>
    <%style%>
    <div class="diy-quick">
        <div class="quick-menu">
            <div id="list">
                <%each datas as item index%>
                    <nav class="nav <%dataIndex==index?'active':''%>" data-index="<%index%>"><%if item.icon%><i class="icon <%item.icon%>"></i><%/if%><%item.title||'未设置'%></nav>
                <%/each%>
            </div>
            <nav class="btn-add" style="margin-bottom: 20px;"><b>+添加分组</b></nav>
        </div>
        <div class="quick-container" id="goods">
            <div class="quick-adv">
                <img src="../addons/ewei_shopv2/plugin/diypage/static/images/default/banner-1.jpg" />
            </div>
            <div class="quick-title"><%datas[dataIndex].title%><p class="subtitle"><%datas[dataIndex].desc%></p></div>
            <div class="quick-list">
                <div class="quick-item">
                    <div class="thumb">
                        <img src="../addons/ewei_shopv2/plugin/diypage/static/images/default/goods-1.jpg">
                    </div>
                    <div class="info">
                        <div class="title">演示商品001</div>
                        <div class="subtitle"></div>
                        <div class="sales">销量: 1000 库存: 123</div>
                        <div class="buyline">
                            <div class="price">￥0.01</div>
                            <div class="buy"><i class="icon icon-roundaddfill"></i></div>
                        </div>
                    </div>
                </div>
                <div class="quick-item">
                    <div class="thumb">
                        <img src="../addons/ewei_shopv2/plugin/diypage/static/images/default/goods-2.jpg">
                    </div>
                    <div class="info">
                        <div class="title">演示商品002</div>
                        <div class="subtitle"></div>
                        <div class="sales">销量: 1000 库存: 123</div>
                        <div class="buyline">
                            <div class="price">￥139.00</div>
                            <div class="buy"><i class="icon icon-roundaddfill"></i></div>
                        </div>
                    </div>
                </div>
                <div class="quick-item">
                    <div class="thumb">
                        <img src="../addons/ewei_shopv2/plugin/diypage/static/images/default/goods-3.jpg">
                    </div>
                    <div class="info">
                        <div class="title">演示商品003</div>
                        <div class="subtitle"></div>
                        <div class="sales">销量: 1000 库存: 123</div>
                        <div class="buyline">
                            <div class="price">￥0.00</div>
                            <div class="buy"><i class="icon icon-roundaddfill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="diy-quick-footer">
        <div class="quick-cart">
            <div class="dot">8</div>
            <div class="inner">
                <i class="icon icon-cartfill"></i>
            </div>
        </div>
        <div class="quick-info">
            <p class="price">￥10.00</p>
            <p>运费:￥0.00</p>
        </div>
        <div class="quick-submit">去结算</div>
    </div>
</script>


<script type="text/html" id="show_temp_1">
    <style type="text/css">
        .fui-shop .shop-info .inner .name {color: <%style.namecolor%>;}
        .fui-shop .shop-info .inner .notice {color: <%style.noticecolor%>;}
        .fui-shop.style2 .shop-info .inner .notice .icon,
        .fui-shop.style3 .shop-info .inner .notice .icon {color: <%style.noticeicon%>;}
        .fui-shop .shop-menu .item .icon {color: <%style.menuicon%>;}
        .fui-shop .shop-menu .item .text {color: <%style.menutext%>;}
        .fui-goods-tab .menu {background: <%style.catebg%>;}
        .fui-goods-tab .menu .nav {background: <%style.catebg%>; color: <%style.catecolor%>;}
        .fui-goods-tab .menu .nav.active {background: <%style.cateactivebg%>; color: <%style.cateactivecolor%>;}
        .fui-goods-tab .main .item-title {color: <%style.righttitle%>;}
        .fui-goods-tab .main {background: <%style.goodsbg%>;}
        .fui-goods-tab .main .item .inner .title {color: <%style.goodstitle%>;}
        .fui-goods-tab .main .item .inner .subtitle {color: <%style.goodssubtitle%>;}
        .fui-goods-tab .main .item .inner .buyline .price {color: <%style.goodsprice%>;}
        .fui-goods-tab .main .item .inner .buyline .sales {color: <%style.goodssales%>;}
        .fui-goods-tab .main .item .inner .buyline .buybtn  {background: <%style.goodscart%>;}
        .cart-dot:before {background: <%style.footercart%>;}
        .cart-dot .icon {color: <%style.footercarticon%>;}
        <%if count(shopmenu)<1%>
        .fui-shop.style2 {padding-bottom: 0;}
        <%/if%>
    </style>
    <div class="fui-shop style<%style.shopstyle%>">
        <div class="shop-info">
            <img class="background" src="<%imgsrc style.shopbg%>" />
            <div class="inner">
                <div class="logo <%style.logostyle%>">
                    <img src="<?php  echo tomedia($_W['shopset']['shop']['logo'])?>">
                </div>
                <div class="right">
                    <div class="name"><?php  echo $_W['shopset']['shop']['name'];?></div>
                    <%if style.notice>0%>
                        <div class="notice"><i class="icon icon-notification"></i> 商城公告商城公告</div>
                    <%/if%>
                </div>
            </div>
        </div>
        <%if count(shopmenu)>0%>
            <div class="shop-menu" style="background: <%style.menubg%>;">
                <%each shopmenu as menu index%>
                    <div class="item">
                        <div class="icon <%menu.icon%>"></div>
                        <div class="text"><%menu.text%></div>
                    </div>
                <%/each%>
            </div>
        <%/if%>
    </div>

    <div class="fui-goods-tab style<%style.shopstyle%>">
        <div class="menu">
            <div id="list">
                <%each datas as item index%>
                    <div class="nav <%dataIndex==index?'active':''%>" data-index="<%index%>"><%if item.icon%><i class="icon <%item.icon%>"></i><%/if%><%item.title||'未设置'%></div>
                <%/each%>
            </div>
            <div class="nav btn-add"><b>+添加分组</b></div>
        </div>
        <div class="main">
            <%each datas as item index%>
                <div class="item-title"><%item.title||'未设置'%></div>

                <%if item.datatype=='0'%>
                    <%if count(item.data)<1%>
                        <div class="empty-data">该分组数据为空</div>
                    <%else%>
                        <%each item.data as g%>
                            <div class="item">
                                <div class="thumb">
                                    <img src="<%imgsrc(g.thumb)%>" />
                                </div>
                                <div class="inner">
                                    <div class="title"><%g.title%></div>
                                    <div class="subtitle"><%g.subtitle%></div>
                                    <div class="buyline">
                                        <div class="price">￥<%g.price%></div>
                                        <div class="sales">销量<%g.sales%></div>
                                        <div class="buybtn"><i class="icon icon-add"></i></div>
                                    </div>
                                </div>
                            </div>
                        <%/each%>
                    <%/if%>
                <%/if%>

                <%if item.datatype=='1'%>
                    <div class="item">
                        <div class="thumb">
                            <img src="../addons/ewei_shopv2/plugin/diypage/static/images/default/goods-1.jpg">
                        </div>
                        <div class="inner">
                            <div class="title">商品标题(分类<%item.catename%>中商品)</div>
                            <div class="subtitle">商品副标题</div>
                            <div class="buyline">
                                <div class="price">￥9.99</div>
                                <div class="sales">销量1</div>
                                <div class="buybtn"><i class="icon icon-add"></i></div>
                            </div>
                        </div>
                    </div>
                <%/if%>

                <%if item.datatype=='2'%>
                    <div class="item">
                        <div class="thumb">
                            <img src="../addons/ewei_shopv2/plugin/diypage/static/images/default/goods-1.jpg">
                        </div>
                        <div class="inner">
                            <div class="title">商品标题(分组<%item.groupname%>中商品)</div>
                            <div class="subtitle">商品副标题</div>
                            <div class="buyline">
                                <div class="price">￥9.99</div>
                                <div class="sales">销量1</div>
                                <div class="buybtn"><i class="icon icon-add"></i></div>
                            </div>
                        </div>
                    </div>
                <%/if%>

            <%/each%>
        </div>
    </div>
    <div class="cart-dot">
        <i class="icon icon-cartfill"></i>
    </div>
</script>

<script type="text/html" id="show_editor">

    <div class="diy-editor form-horizontal <%if selected=='0'%>active<%/if%>" data-id="0">
        <div class="title">1. 模板选择 <span class="pull-right"><i class="fa fa-caret-left"></i></span></div>
        <div class="editor-body">
            <div class="cut-line"></div>
            <div class="form-group">
                <div class="col-sm-2 control-label">模板选择</div>
                <div class="col-sm-10">
                    <label class="radio-inline"><input class="bind" data-bind="template" data-bind-init="true" type="radio" name="template" value="0" <%if template=='0'||!template%>checked<%/if%>> 模板一(外卖模式)</label>
                    <label class="radio-inline"><input class="bind" data-bind="template" data-bind-init="true" type="radio" name="template" value="1" <%if template=='1'%>checked<%/if%>> 模板二(商城模式)</label>
                    <div class="help-block text-danger" style="margin-bottom: 0;">注意：如果商品数据量过多不建议使用模板二</div>
                </div>
            </div>
            <%if template=='1'%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">模板样式</div>
                    <div class="col-sm-10">
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="shopstyle" data-bind-init="true" type="radio" name="shopstyle" value="1" <%if style.shopstyle=='1'%>checked<%/if%>> 样式一</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="shopstyle" data-bind-init="true" type="radio" name="shopstyle" value="2" <%if style.shopstyle=='2'%>checked<%/if%>> 样式二</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="shopstyle" data-bind-init="true" type="radio" name="shopstyle" value="3" <%if style.shopstyle=='3'%>checked<%/if%>> 样式三</label>
                    </div>
                </div>
            <%else%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">购物车数据</div>
                    <div class="col-sm-10">
                        <label class="radio-inline"><input class="bind" data-bind="cartdata" type="radio" name="cartdata" value="0" <%if cartdata=='0'%>checked<%/if%>> 商城购物车</label>
                        <label class="radio-inline"><input class="bind" data-bind="cartdata" type="radio" name="cartdata" value="1" <%if cartdata=='1'%>checked<%/if%>> 单独购物车</label>
                        <div class="helper-block text-danger">提示: 选择商城购物车则与商城购物车商品互通，否则使用单页面购物车</div>
                    </div>
                </div>
            <%/if%>
        </div>
    </div>

    <%if template=='0'%>
        <div class="diy-editor form-horizontal <%if selected=='1'%>active<%/if%>" data-id="1">
            <div class="title">2. 幻灯片设置 <span class="pull-right"><i class="fa fa-caret-left"></i></span></div>
            <div class="editor-body">
                <div class="cut-line"></div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">幻灯片设置</div>
                    <div class="col-sm-10">
                        <label class="radio-inline"><input class="bind" data-bind="showadv" data-bind-init="true" type="radio" name="showadv" value="0" <%if showadv=='0'%>checked<%/if%>> 不显示</label>
                        <label class="radio-inline"><input class="bind" data-bind="showadv" data-bind-init="true" type="radio" name="showadv" value="1" <%if showadv=='1'%>checked<%/if%>> 读取公用设置</label>
                        <label class="radio-inline"><input class="bind" data-bind="showadv" data-bind-init="true" type="radio" name="showadv" value="2" <%if showadv=='2'%>checked<%/if%>> 单独设置</label>
                        <%if showadv=='2'%>
                            <div class="help-block">图片建议尺寸750*450</div>
                        <%/if%>
                    </div>
                </div>
                <%if showadv=='2'%>
                    <div class="form-items" data-min="1" data-max="5" data-type="advs">
                        <div class="inner" id="form-items-advs">
                            <%each advs as adv index%>
                                <div class="item" data-index="<%index%>">
                                    <span class="btn-del-child" title="删除"></span>
                                    <div class="item-image">
                                        <img src="<%imgsrc adv.imgurl%>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.jpg';" id="adv-show-<%index%>">
                                    </div>
                                    <div class="item-form">
                                        <div class="input-group" style="margin-bottom:0px; ">
                                            <input type="text" class="form-control input-sm bind" data-bind-parent="advs" data-bind="imgurl" placeholder="请选择图片或输入图片地址" value="<%adv.imgurl%>"  id="adv-input-<%index%>" />
                                            <span class="input-group-addon btn btn-default bind" data-toggle="selectImg" data-input="#adv-input-<%index%>" data-img="#adv-show-<%index%>">选择图片</span>
                                        </div>
                                        <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                                            <input type="text" class="form-control input-sm bind" data-bind-parent="advs" data-bind="linkurl" placeholder="请选择链接或输入链接地址" value="<%adv.linkurl%>" id="adv-link-<%index%>" />
                                            <span class="input-group-addon btn btn-default" data-toggle="selectUrl" data-input="#adv-link-<%index%>">选择链接</span>
                                        </div>
                                    </div>
                                </div>
                            <%/each%>
                        </div>
                        <div class="btn btn-w-m btn-block btn-default btn-add" data-type="advs"><i class="fa fa-plus"></i> 添加一个广告</div>
                    </div>
                <%/if%>
            </div>
        </div>
    <%/if%>

    <%if template=='1'%>
        <div class="diy-editor form-horizontal <%if selected=='2'%>active<%/if%>" data-id="2">
            <div class="title">2. 店招设置 <span class="pull-right"><i class="fa fa-caret-left"></i></span></div>
            <div class="editor-body">
                <div class="cut-line"></div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">店招背景</div>
                    <div class="col-sm-10">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="shopbg" value="<%style.shopbg%>" id="shopbg" />
                            <span class="input-group-addon btn btn-default" data-toggle="selectImg" data-input="#shopbg">选择图片</span>
                            <%if style.shopstyle=='1'%>
                                <span class="input-group-addon btn btn-default" onclick="$(this).prev().prev().val('../addons/ewei_shopv2/plugin/quick/static/images/shop-1.jpg').trigger('propertychange')">恢复默认</span>
                            <%/if%>
                            <%if style.shopstyle=='2'%>
                                <span class="input-group-addon btn btn-default" onclick="$(this).prev().prev().val('../addons/ewei_shopv2/plugin/quick/static/images/shop-2.jpg').trigger('propertychange')">恢复默认</span>
                            <%/if%>
                            <%if style.shopstyle=='3'%>
                                <span class="input-group-addon btn btn-default" onclick="$(this).prev().prev().val('../addons/ewei_shopv2/plugin/quick/static/images/shop-3.jpg').trigger('propertychange')">恢复默认</span>
                            <%/if%>
                        </div>
                        <div class="help-block">店招背景推荐尺寸750*330</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">logo样式</div>
                    <div class="col-sm-10">
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="logostyle" type="radio" name="logostyle" value="" <%if style.logostyle==''||!style.logostyle%>checked<%/if%>> 方形</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="logostyle" type="radio" name="logostyle" value="round" <%if style.logostyle=='round'%>checked<%/if%>> 圆角</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="logostyle" type="radio" name="logostyle" value="circle" <%if style.logostyle=='circle'%>checked<%/if%>> 圆形</label>
                    </div>
                </div>

                <div class="line"></div>

                <div class="form-items" data-max="4" data-type="shopmenu">
                    <div class="inner" id="form-items-shopmenu">
                        <%each shopmenu as nav index%>
                            <div class="item" data-index="<%index%>">
                                <span class="btn-del-child" title="删除"></span>
                                <div class="item-image square shopicon">
                                    <p style="color: <%style.menuicon%>;"><i class="icon <%nav.icon%>" id="shopmenu-show-<%index%>"></i></p>
                                    <p style="color: <%style.menutext%>;" class="text2"><%nav.text%></p>
                                </div>
                                <div class="item-form">
                                    <div class="input-group" style="margin-bottom:0px; ">
                                        <span class="input-group-addon">按钮文字</span>
                                        <input type="text" class="form-control input-sm bind" data-bind-parent="shopmenu" data-bind="text" value="<%nav.text%>" />
                                        <input type="hidden" class="bind" data-bind-parent="shopmenu" data-bind="icon" id="shopmenu-<%index%>" value="<%nav.icon%>" />
                                        <span class="input-group-addon btn btn-default" data-toggle="selectIcon" data-input="#shopmenu-<%index%>" data-element="#shopmenu-show-<%index%>">选择图标</span>
                                    </div>
                                    <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                                        <input type="text" class="form-control input-sm bind" data-bind-parent="shopmenu" data-bind="linkurl" placeholder="请选择链接或输入链接地址(http://开头)" value="<%nav.linkurl%>" id="shopmenu-link-<%index%>" />
                                        <span class="input-group-addon btn btn-default" data-toggle="selectUrl" data-input="#shopmenu-link-<%index%>">选择链接</span>
                                    </div>
                                </div>
                            </div>
                        <%/each%>
                    </div>
                    <div class="btn btn-w-m btn-block btn-default btn-add" data-type="shopmenu"><i class="fa fa-plus"></i> 添加一个菜单按钮</div>
                </div>

                <div class="line"></div>
                <div class="form-group">
                    <div class="col-sm-2 control-label" style="font-size: 14px;">公告设置</div>
                    <div class="col-sm-10">
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="notice" data-bind-init="true" type="radio" name="notice" value="0" <%if style.notice=='0'||!style.notice%>checked<%/if%>> 隐藏</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="notice" data-bind-init="true" type="radio" name="notice" value="1" <%if style.notice=='1'%>checked<%/if%>> 读取商城</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="notice" data-bind-init="true" type="radio" name="notice" value="2" <%if style.notice=='2'%>checked<%/if%>> 手动填写</label>
                    </div>
                </div>
                <%if style.notice=='1'%>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">公告数量</div>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="noticenum" type="radio" name="noticenum" value="5" <%if style.noticenum=='5'%>checked<%/if%>> 5条</label>
                            <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="noticenum" type="radio" name="noticenum" value="10" <%if style.noticenum=='10'%>checked<%/if%>> 10条</label>
                            <label class="radio-inline"><input class="bind" data-bind-parent="style" data-bind="noticenum" type="radio" name="noticenum" value="15" <%if style.noticenum=='15'%>checked<%/if%>> 15条</label>
                        </div>
                    </div>
                <%/if%>
                <%if style.notice=='2'%>
                    <div class="form-items" data-min="1" data-max="5" style="margin-bottom: 5px;" data-type="notices">
                        <div class="inner" id="form-items-notices">
                            <%each notices as notice index%>
                                <div class="item" data-index="<%index%>">
                                    <span class="btn-del-child" title="删除"></span>
                                    <div class="item-image drag-btn square">拖动排序</div>
                                    <div class="item-form">
                                        <div class="input-group" style="margin-bottom:0px; ">
                                            <span class="input-group-addon">公告标题</span>
                                            <input type="text" class="form-control input-sm bind" data-bind-parent="notices" data-bind="title" value="<%notice.title%>">
                                        </div>
                                        <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                                            <input type="text" class="form-control input-sm bind" data-bind-parent="notices" data-bind="linkurl" id="notice-indput-<%index%>" placeholder="请选择链接或输入链接地址(http://开头)" value="<%notice.linkurl%>">
                                            <span class="input-group-addon btn btn-default" data-toggle="selectUrl" data-input="#notice-indput-<%index%>">选择链接</span>
                                        </div>
                                    </div>
                                </div>
                            <%/each%>
                        </div>
                        <div class="btn btn-w-m btn-block btn-default btn-add" data-type="notices"><i class="fa fa-plus"></i> 添加一个公告</div>
                    </div>
                <%/if%>

            </div>
        </div>
    <%/if%>

    <div class="diy-editor form-horizontal <%if selected=='3'%>active<%/if%>" data-id="3">
        <div class="title">3. 样式设置(非必选) <span class="pull-right"><i class="fa fa-caret-left"></i></span></div>
        <div class="editor-body">
            <div class="cut-line"></div>
            <%if template=='1'%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">商城名称</div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="namecolor" value="<%style.namecolor%>" type="color" />
                            <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#000000').trigger('propertychange')">重置</span>
                        </div>
                    </div>
                    <div class="col-sm-2 control-label">菜单背景</div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="menubg" value="<%style.menubg%>" type="color" />
                            <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">重置</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">菜单图标</div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="menuicon" data-bind-init="true" value="<%style.menuicon%>" type="color" />
                            <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ff5555').trigger('propertychange')">重置</span>
                        </div>
                    </div>
                    <div class="col-sm-2 control-label">菜单文字</div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="menutext" data-bind-init="true" value="<%style.menutext%>" type="color" />
                            <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#141414').trigger('propertychange')">重置</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">公告图标</div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="noticeicon" value="<%style.noticeicon%>" type="color" />
                            <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#f19b59').trigger('propertychange')">重置</span>
                        </div>
                    </div>
                    <div class="col-sm-2 control-label">公告文字</div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="noticecolor" value="<%style.noticecolor%>" type="color" />
                            <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#676a6c').trigger('propertychange')">重置</span>
                        </div>
                    </div>
                </div>
            <%/if%>

            <div class="form-group">
                <div class="col-sm-2 control-label">分类背景</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="catebg" value="<%style.catebg%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="<%if template=='1'%>$(this).prev().val('#e6e6e6').trigger('propertychange');<%else%>$(this).prev().val('#f8f8f8').trigger('propertychange');<%/if%>">重置</span>
                    </div>
                </div>
                <div class="col-sm-2 control-label">分类文字</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="catecolor" value="<%style.catecolor%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="<%if template=='1'%>$(this).prev().val('#676a6c').trigger('propertychange');<%else%>$(this).prev().val('#666666').trigger('propertychange');<%/if%>">重置</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 control-label">选中背景</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="cateactivebg" value="<%style.cateactivebg%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">重置</span>
                    </div>
                </div>
                <div class="col-sm-2 control-label">选中文字</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="cateactivecolor" value="<%style.cateactivecolor%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ff5555').trigger('propertychange')">重置</span>
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <div class="form-group">
                <div class="col-sm-2 control-label">商品背景</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="goodsbg" value="<%style.goodsbg%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">重置</span>
                    </div>
                </div>
                <div class="col-sm-2 control-label">商品标题</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="goodstitle" value="<%style.goodstitie%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#333333').trigger('propertychange')">重置</span>
                    </div>
                </div>
            </div>
            <%if template==1%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">商品副标题</div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input class="form-control input-sm bind" data-bind-parent="style" data-bind="goodssubtitle" value="<%style.goodssubtitle%>" type="color" />
                            <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#9f9f9f').trigger('propertychange')">重置</span>
                        </div>
                    </div>
                </div>
            <%/if%>
            <div class="form-group">
                <div class="col-sm-2 control-label">商品价格</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="goodsprice" value="<%style.goodsprice%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="<%if template=='1'%>$(this).prev().val('#ff5555').trigger('propertychange');<%else%>$(this).prev().val('#ff6500').trigger('propertychange')<%/if%>">重置</span>
                    </div>
                </div>
                <div class="col-sm-2 control-label">商品销量</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="goodssales" value="<%style.goodssales%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="<%if template=='1'%>$(this).prev().val('#cbcbcb').trigger('propertychange');<%else%>$(this).prev().val('#888888').trigger('propertychange')<%/if%>">重置</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 control-label">购物车按钮</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="goodscart" value="<%style.goodscart%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ff5555').trigger('propertychange')">重置</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 control-label">右分类标题</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="righttitle" value="<%style.righttitle%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#666666').trigger('propertychange')">重置</span>
                    </div>
                </div>
                <%if template=='0'%>
                <div class="col-sm-2 control-label">右标题背景</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="righttitlebg" value="<%style.righttitlebg%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#f8f8f8').trigger('propertychange')">重置</span>
                    </div>
                </div>
                <%/if%>
            </div>
            <%if template=='0'%>
            <div class="form-group">
                <div class="col-sm-2 control-label">右标题边框</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="righttitleborder" value="<%style.righttitleborder%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#efefef').trigger('propertychange')">重置</span>
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <div class="form-group">
                <div class="col-sm-2 control-label">底部背景</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="footerbg" value="<%style.footerbg%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#474749').trigger('propertychange')">重置</span>
                    </div>
                </div>
                <div class="col-sm-2 control-label">底部文字</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="footertext" value="<%style.footertext%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">重置</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 control-label">结算按钮</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="footerbtn" value="<%style.footerbtn%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ff9d55').trigger('propertychange')">重置</span>
                    </div>
                </div>
                <div class="col-sm-2 control-label">按钮文字</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="footerbtntext" value="<%style.footerbtntext%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">重置</span>
                    </div>
                </div>
            </div>
            <%/if%>
            <div class="line"></div>
            <div class="form-group">
                <div class="col-sm-2 control-label">底部购物车</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="footercart" value="<%style.footercart%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ff5555').trigger('propertychange')">重置</span>
                    </div>
                </div>
                <div class="col-sm-2 control-label">购物车图标</div>
                <div class="col-sm-4">
                    <div class="input-group input-group-sm">
                        <input class="form-control input-sm bind" data-bind-parent="style" data-bind="footercarticon" value="<%style.footercarticon%>" type="color" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">重置</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="diy-editor form-horizontal <%if selected=='4'%>active<%/if%>" data-id="4">
        <div class="title">4. 数据选择 (当前编辑: <%datas[dataIndex].title%>) <span class="pull-right"><i class="fa fa-caret-left"></i></span></div>
        <div class="editor-body">
            <div class="cut-line"></div>
            <div class="form-group">
                <div class="col-sm-2 control-label">分组名称</div>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input class="form-control input-sm bind" data-bind-parent="datas" data-bind="title" placeholder="例如: 推荐商品(最大五字)" value="<%datas[dataIndex].title%>" data-bind="title" maxlength="5" />
                        <%if datas[dataIndex].icon!=''%>
                            <span class="input-group-addon" style="border-left: 0;"><i class="icon <%datas[dataIndex].icon%>" id="show-icon"></i></span>
                        <%/if%>
                        <input type="hidden" class="bind icon-class" data-bind-parent="datas" data-bind="icon" data-bind-init="true" value="<%datas[dataIndex].icon%>" />
                        <%if datas[dataIndex].icon!=''%>
                            <span class="input-group-addon btn" style="border-left: 0;" onclick="$('.icon-class').val('').trigger('propertychange')">清空</span>
                        <%/if%>
                        <span class="input-group-addon btn" data-toggle="selectIcon" data-input=".icon-class" data-element="#show-icon">选择图标</span>
                    </div>
                </div>
            </div>
            <%if template=='0'%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">分组简介</div>
                    <div class="col-sm-10">
                        <input class="form-control input-sm bind" data-bind-parent="datas" data-bind="desc" placeholder="请填写一句话简介(20字内)" maxlength="20" value="<%datas[dataIndex].desc%>" data-bind="desc" />
                    </div>
                </div>
            <%/if%>
            <div class="form-group">
                <div class="col-sm-2 control-label">选择商品</div>
                <div class="col-sm-10">
                    <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="datatype" data-bind-init="true" type="radio" name="datatype" value="0" <%datas[dataIndex].datatype==0&&'checked'%>> 手动选择</label>
                    <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="datatype" data-bind-init="true" type="radio" name="datatype" value="1" <%datas[dataIndex].datatype==1&&'checked'%>> 选择分类</label>
                    <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="datatype" data-bind-init="true" type="radio" name="datatype" value="2" <%datas[dataIndex].datatype==2&&'checked'%>> 选择分组</label>
                </div>
            </div>
            <%if datas[dataIndex].datatype==0%>
                <div class="form-items" data-type="datas">
                    <div class="inner" id="form-items">
                        <%each datas[dataIndex].data as g index%>
                        <div class="item" data-index="<%index%>">
                            <span class="btn-del-child" title="删除"></span>
                            <div class="item-image square">
                                <div class="text goods-selector">重新选择</div>
                                <img src="<%imgsrc g.thumb%>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.jpg';" />
                                <input type="hidden" />
                            </div>
                            <div class="item-form">
                                <div class="input-group" style="margin-bottom:0px; ">
                                    <span class="input-group-addon">名称</span>
                                    <input class="form-control input-sm" value="<%g.title%>" readonly="readonly">
                                </div>
                                <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                                    <span class="input-group-addon">价格</span>
                                    <input class="form-control input-sm" value="￥<%g.price%>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <%/each%>
                    </div>
                    <div class="btn btn-w-m btn-block btn-default btn-outline btn-add" data-type="datas"><i class="fa fa-plus"></i> 添加一个商品</div>
                </div>
            <%/if%>
            <%if datas[dataIndex].datatype==1%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">选择分类</div>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" placeholder="请点击选择分类" value="<%datas[dataIndex].catename%>" readonly="readonly">
                            <span class="input-group-addon btn btn-default category-selector">选择分类</span>
                        </div>
                    </div>
                </div>
            <%/if%>
            <%if datas[dataIndex].datatype==2%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">选择分组</div>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" placeholder="请点击选择分类" value="<%datas[dataIndex].groupname%>" readonly="readonly">
                            <span class="input-group-addon btn btn-default group-selector">选择分组</span>
                        </div>
                    </div>
                </div>
            <%/if%>
            <%if datas[dataIndex].datatype>0%>
                <div class="form-group">
                    <div class="col-sm-2 control-label">排序方式</div>
                    <div class="col-sm-10">
                        <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodssort" type="radio" name="goodssort" value="0" <%datas[dataIndex].goodssort==0&&'checked'%>> 综合</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodssort" type="radio" name="goodssort" value="1" <%datas[dataIndex].goodssort==1&&'checked'%>> 按销量</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodssort" type="radio" name="goodssort" value="2" <%datas[dataIndex].goodssort==2&&'checked'%>> 价格降序</label>
                        <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodssort" type="radio" name="goodssort" value="3" <%datas[dataIndex].goodssort==3&&'checked'%>> 价格升序</label>
                    </div>
                </div>
                <%if template==1%>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">显示数量</div>
                        <div class="col-sm-10">
                            <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodsnum" type="radio" name="goodsnum" value="5" <%datas[dataIndex].goodsnum==5&&'checked'%>> 5个</label>
                            <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodsnum" type="radio" name="goodsnum" value="10" <%datas[dataIndex].goodsnum==10&&'checked'%>> 10个</label>
                            <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodsnum" type="radio" name="goodsnum" value="15" <%datas[dataIndex].goodsnum==15&&'checked'%>> 15个</label>
                            <label class="radio-inline"><input class="bind" data-bind-parent="datas" data-bind="goodsnum" type="radio" name="goodsnum" value="20" <%datas[dataIndex].goodsnum==20&&'checked'%>> 20个</label>
                        </div>
                    </div>
                <%/if%>
            <%/if%>
            <div class="" style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #ddd">
                <div class="btn btn-w-m btn-block btn-success btn-add"><i class="fa fa-plus"></i> 添加一个分组</div>
                <div class="btn btn-w-m btn-block btn-danger btn-del-item"><i class="fa fa-remove"></i> 删除当前分组</div>
            </div>
        </div>
    </div>

</script>
