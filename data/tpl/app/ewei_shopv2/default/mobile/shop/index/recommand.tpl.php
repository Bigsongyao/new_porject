<?php defined('IN_IA') or exit('Access Denied');?><div id="recommand"></div>
<div class='infinite-loading' style="text-align: center; color: #666;">
	<span class='fui-preloader'></span>
	<span class='text'> 正在加载...</span>
</div>
<script type="text/html" id="tpl_recommand">
	<%if list!=''%>
		<%if page==1%>
			<div class="fui-line" style="background: #f4f4f4;">
				<div class="text">精品推荐</div>
        <div class="text text-riw"><i class="title_left"></i> 逸品のおすすめ <i class="title_right"></i></div>
			</div>
			<div class="fui-goods-group block border">
		<%/if%>
		
			<%each list as item%>
				<div class="fui-goods-item" data-goodsid="<%item.id%>" data-type="<%item.type%>">
					<a <%if item.bargain>0%>href="<?php  echo mobileUrl('bargain/detail')?>&id=<%item.bargain%>"<%else%>href="<?php  echo mobileUrl('goods/detail')?>&id=<%item.id%>"<%/if%>>
						<div class="image" data-lazy-background="<%item.thumb%>">
							<%if item.total<=0%><div class="salez" style="background-image: url('<?php  echo tomedia($_W['shopset']['shop']['saleout'])?>'); "></div><%/if%>
						</div>
					</a>
					<div class="detail">
            <div class="price" style="margin-top: 0.2rem 0">
							<span class="text">RMB <%item.minprice%></span>
							<span class="buyb">JPY <%item.productprice%></span>
						</div>
						<a <%if item.bargain>0%>href="<?php  echo mobileUrl('bargain/detail')?>&id=<%item.bargain%>"<%else%>href="<?php  echo mobileUrl('goods/detail')?>&id=<%item.id%>"<%/if%>>
							<div class="name">
								<%if item.ispresell==1%><i class="fui-tag fui-tag-danger">预售</i><%/if%>
								<%item.title%>
							</div>
              <div style="font-size: 0.5rem;" class="name">
                <%item.subtitle%>
							</div>
						</a>
						
					</div>
				</div>

			<%/each%>
			
		<%if page==1%>
			</div>
		<%/if%>
		
	<%/if%>
</script>
<script language='javascript'>
	require(['biz/shop/index'], function (modal) {modal.init({merchid:<?php  echo intval($_GPC['merchid'])?>})});
</script>
