<?php defined('IN_IA') or exit('Access Denied');?><!-- <form action="<?php  echo mobileUrl('goods')?>" method="post">
	<div class="fui-searchbar bar">
		<div class="searchbar center">
			<input type="submit" class="searchbar-cancel searchbtn" value="搜索" />
			<div class="search-input">
				<i class="icon icon-search"></i>
				<input type="search" placeholder="输入关键字..." class="search" name="keywords">
			</div>
		</div>
	</div>
</form>
<script>
	$(function () {
		$("input[name='keywords']").focusin(function () {
			$(this).removeAttr('placeholder');
		});
		$("input[name='keywords']").focusout(function () {
			$(this).attr('placeholder','输入关键字...');
		});
		$("form").submit(function () {
			$(this).find("input[name='keywords']").blur();
		});
	});
</script> -->

<?php  if(!empty($hot_goods)) { ?>
    <div class="fui-line" style="background: #f4f4f4;">
				<div class="text">达人推荐</div>
        <div class="text text-riw"><i class="title_left"></i> 達人推薦 <i class="title_right"></i></div>
			</div>
			<div class="fui-goods-group block border">
        <?php  if(is_array($hot_goods)) { foreach($hot_goods as $item) { ?>
          <div class="fui-goods-item" data-goodsid="<?php  echo $item['id'];?>" data-type="<?php  echo $item['type'];?>">
					<a href="<?php  echo mobileUrl('goods/detail')?>&id=<?php  echo $item['id'];?>">
						<div class="image" data-lazy-background="../attachment/<?php  echo $item['thumb'];?>">
							
						</div>
					</a>
					<div class="detail">
						<a href="<?php  echo mobileUrl('goods/detail')?>&id=<?php  echo $item['id'];?>>
							<div class="name">
								<?php  echo $item['title'];?>
							</div>
              <div style="font-size: 0.5rem;" class="name">
                <?php  echo $item['subtitle'];?>
							</div>
						</a>
						
				</div>
          
        <?php  } } ?>
      </div>
<?php  } ?>