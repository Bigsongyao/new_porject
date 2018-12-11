<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left =true;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript" src="../addons/ewei_shopv2/static/js/dist/area/cascade.js"></script>
<style type='text/css'>
    .tabs-container .form-group {overflow: hidden;}
    .tabs-container .tabs-left > .nav-tabs {}
    .tab-goods .nav li {float:left;}
    .spec_item_thumb {position: relative; width: 30px; height: 20px; padding: 0; border-left: none;}
    .spec_item_thumb i {position: absolute; top: -5px; right: -5px;}
    .multi-img-details, .multi-audio-details {margin-top:.5em;max-width: 700px; padding:0; }
    .multi-audio-details .multi-audio-item {width:155px; height: 40px; position:relative; float: left; margin-right: 5px;}
	.region-goods-details {
		background: #f8f8f8;
		margin-bottom: 10px;
		padding: 0 10px;
	}
	.region-goods-left{
		text-align: center;
		font-weight: bold;
		color: #333;
		font-size: 14px;
		padding: 20px 0;
	}
	.region-goods-right{
		border-left: 3px solid #fff;
		padding: 10px 10px;
	}
</style>
<div class="page-header">
    当前位置：
    <span class="text-primary">
    <?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>商品 <small><?php  if(!empty($item['id'])) { ?>修改【<span class="text-info"><?php  echo $item['title'];?></span>】<?php  } ?><?php  if(!empty($merch_user['merchname'])) { ?>商户名称:【<span class="text-info"><?php  echo $merch_user['merchname'];?></span>】<?php  } ?></small>
    </span>
</div>
<div class="page-content">
<div class="page-sub-toolbar">
	<span class=''>
		<?php if(cv('goods.add')) { ?>
        <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('goods/add')?>" >添加商品</a>
		<?php  } ?>
		<?php if(cv('goods.add')) { ?>
        <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('goods/create')?>" >快速添加商品</a>
		<?php  } ?>
    </span>
</div>
<form <?php if( ce('goods' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
    <input type="hidden" id="tab" name="tab" value="#tab_basic" />
    <div class="tabs-container tab-goods">
        <div class="tabs-left">
            <ul class="nav nav-tabs" id="myTab">
                <li  <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本</a></li>
                <li  <?php  if($_GPC['tab']=='option') { ?>class="active"<?php  } ?> ><a href="#tab_option">库存/规格</a></li>
                <li <?php  if($_GPC['tab']=='param') { ?>class="active"<?php  } ?> ><a href="#tab_param">参数</a></li>
                <li <?php  if($_GPC['tab']=='des') { ?>class="active"<?php  } ?> ><a href="#tab_des">详情</a></li>
                <li <?php  if($_GPC['tab']=='buy') { ?>class="active"<?php  } ?> ><a href="#tab_buy">购买权限</a></li>
                <li <?php  if($_GPC['tab']=='sale') { ?>class="active"<?php  } ?> ><a href="#tab_sale">营销</a></li>
                <li <?php  if($_GPC['tab']=='discount') { ?>class="active"<?php  } ?> ><a href="#tab_discount">会员折扣</a></li>
                <li <?php  if($_GPC['tab']=='share') { ?>class="active"<?php  } ?> ><a href="#tab_share">分享关注</a></li>
                <li <?php  if($_GPC['tab']=='notice') { ?>class="active"<?php  } ?> ><a href="#tab_notice">卖家通知</a></li>

                <?php  if(!empty($com_set['level'])) { ?>
                <li <?php  if($_GPC['tab']=='sell') { ?>class="active"<?php  } ?>><a href="#tab_sell" id="a_sell"><?php  if(p('ccard') && $item['type'] == 20) { ?>返佣<?php  } else { ?>分销<?php  } ?></a></li>
                <?php  } ?>

				<?php  if($merchid == 0 ) { ?>
				<li <?php  if($_GPC['tab']=='verify') { ?>class="active"<?php  } ?> id="tab_nav_verify" <?php  if($item['type']==3||$item['type']==5||($item['type']==2&&!empty($item['virtualsend']))) { ?>style="display:none;"<?php  } ?>><a href="#tab_verify">线下核销</a></li>

				<?php  } ?>

                <?php  if(p('diyform')) { ?>
                <li <?php  if($_GPC['tab']=='diyform') { ?>class="active"<?php  } ?>><a href="#tab_diyform">自定义表单</a></li>
                <?php  } ?>

                <?php  if($merchid == 0) { ?>
                <li <?php  if($_GPC['tab']=='detaildiy') { ?>class="active"<?php  } ?>><a href="#tab_detaildiy">店铺信息</a></li>
                <?php  } ?>

                <?php  if(p('diypage')) { ?>
                <li <?php  if($_GPC['tab']=='diypage') { ?>class="active"<?php  } ?>><a href="#tab_diypage">自定义模板</a></li>
                <?php  } ?>
                <?php  if(p('ccard')) { ?>
                <li class="ccard-group <?php  if($_GPC['tab']=='ccard') { ?>active<?php  } ?>" <?php  if($item['type'] != 20) { ?>style="display:none;"<?php  } ?>><a href="#tab_ccard">充值说明</a></li>
                <?php  } ?>

				<li <?php  if($item['type'] != 5) { ?>style="display:none;"<?php  } ?>   class="showverifygoods" <?php  if($_GPC['tab']=='verifygoods') { ?>class="active"<?php  } ?> ><a href="#tab_verifygoods">核销设置</a></li>
				<?php  if(com('wxcard')) { ?>
				<li <?php  if($item['type'] != 5) { ?>style="display:none;"<?php  } ?>   class="showverifygoodscard"  <?php  if($_GPC['tab']=='verifygoodscard') { ?>class="active"<?php  } ?> ><a href="#tab_verifygoodscard">微信会员卡设置</a></li>
				<?php  } ?>
            </ul>

            <div class="tab-content  ">
                <div class="tab-pane   <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>active<?php  } ?>" id="tab_basic"><div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/basic', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/basic', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane  <?php  if($_GPC['tab']=='option') { ?>active<?php  } ?>" id="tab_option"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/option', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/option', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane <?php  if($_GPC['tab']=='param') { ?>active<?php  } ?>" id="tab_param"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/param', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/param', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane <?php  if($_GPC['tab']=='des') { ?>active<?php  } ?>" id="tab_des"> <div class="panel-body" style='padding:0;'><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/des', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/des', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane <?php  if($_GPC['tab']=='buy') { ?>active<?php  } ?>" id="tab_buy"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/buy', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/buy', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane <?php  if($_GPC['tab']=='sale') { ?>active<?php  } ?>" id="tab_sale" > <div class="panel-body" ><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/sale', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/sale', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane <?php  if($_GPC['tab']=='discount') { ?>active<?php  } ?>" id="tab_discount"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/discount', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/discount', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane <?php  if($_GPC['tab']=='share') { ?>active<?php  } ?>" id="tab_share"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/share', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/share', TEMPLATE_INCLUDEPATH));?></div></div>
                <div class="tab-pane  <?php  if($_GPC['tab']=='notice') { ?>active<?php  } ?>" id="tab_notice"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/notice', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/notice', TEMPLATE_INCLUDEPATH));?></div></div>
				<div class="tab-pane  <?php  if($_GPC['tab']=='verifygoods') { ?>active<?php  } ?>" id="tab_verifygoods"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/verifygoods', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/verifygoods', TEMPLATE_INCLUDEPATH));?></div></div>
				<?php  if(com('wxcard')) { ?>
				<div class="tab-pane  <?php  if($_GPC['tab']=='verifygoodscard') { ?>active<?php  } ?>" id="tab_verifygoodscard"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/verifygoodscard', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/verifygoodscard', TEMPLATE_INCLUDEPATH));?></div></div>
				<?php  } ?>
                <?php  if(p('commission') && !empty($com_set['level'])) { ?>
                <div class="tab-pane <?php  if($_GPC['tab']=='sell') { ?>active<?php  } ?>" id="tab_sell"> <div class="panel-body">
                    <?php  if(p('ccard')) { ?>
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('ccard/goods', TEMPLATE_INCLUDEPATH)) : (include template('ccard/goods', TEMPLATE_INCLUDEPATH));?>
                    <?php  } else { ?>
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('commission/goods', TEMPLATE_INCLUDEPATH)) : (include template('commission/goods', TEMPLATE_INCLUDEPATH));?>
                    <?php  } ?>
                </div></div>
                <?php  } ?>

                <?php  if($merchid == 0) { ?>
                <div class="tab-pane <?php  if($_GPC['tab']=='verify') { ?>active<?php  } ?>" id="tab_verify"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/verify', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/verify', TEMPLATE_INCLUDEPATH));?></div></div>
                <?php  } ?>

                <?php  if(p('diyform')) { ?>
                <div class="tab-pane <?php  if($_GPC['tab']=='diyform') { ?>active<?php  } ?>" id="tab_diyform"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/goods', TEMPLATE_INCLUDEPATH)) : (include template('diyform/goods', TEMPLATE_INCLUDEPATH));?></div></div>
                <?php  } ?>

                <?php  if($merchid == 0) { ?>
                <div class="tab-pane <?php  if($_GPC['tab']=='detaildiy') { ?>active<?php  } ?>" id="tab_detaildiy"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tab/detaildiy', TEMPLATE_INCLUDEPATH)) : (include template('goods/tab/detaildiy', TEMPLATE_INCLUDEPATH));?></div></div>
                <?php  } ?>

                <?php  if(p('diypage')) { ?>
                <div class="tab-pane <?php  if($_GPC['tab']=='diypage') { ?>active<?php  } ?>" id="tab_diypage"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diypage/invoke/goods', TEMPLATE_INCLUDEPATH)) : (include template('diypage/invoke/goods', TEMPLATE_INCLUDEPATH));?></div></div>
                <?php  } ?>

                <?php  if(p('ccard')) { ?>
                <div class="tab-pane <?php  if($_GPC['tab']=='ccard') { ?>active<?php  } ?>" id="tab_ccard"> <div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('ccard/explain', TEMPLATE_INCLUDEPATH)) : (include template('ccard/explain', TEMPLATE_INCLUDEPATH));?></div></div>
                <?php  } ?>


            </div>
        </div>
    </div>
    <?php if( ce('goods' ,$item) ) { ?>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-9 subtitle">
            <input type="submit" value="保存商品" class="btn btn-primary"/>
			<a class="btn btn-default" href="<?php  echo webUrl('goods',array('goodsfrom'=>$_GPC['goodsfrom'], 'page'=>$_GPC['page']))?>">返回列表</a>
        </div>
    </div>
    <?php  } ?>
</form>
</div>

<script type="text/javascript">
	window.type = "<?php  echo $item['type'];?>";
	window.virtual = "<?php  echo $item['virtual'];?>";
	require(['bootstrap'], function () {
		$('#myTab a').click(function (e) {
			$('#tab').val( $(this).attr('href'));
			e.preventDefault();
			$(this).tab('show');
		})
	});
	$(function () {

		$(':radio[name=isverify]').click(function () {
			window.type = $("input[name='isverify']:checked").val();

			if (window.type == '2') {
				$(':checkbox[name=cash]').attr("checked",false);
				$(':checkbox[name=cash]').parent().hide();
			} else {
				$(':checkbox[name=cash]').parent().show();
			}
		});
		$(':radio[name=ispresell]').click(function () {
			window.ispresell = $("input[name='ispresell']:checked").val();
			if(window.ispresell==0){
				$(".presell_info").hide();
			}else{
				$(".presell_info").show();
			}
		});

		$(':radio[name=type]').click(function () {
			window.type = $("input[name='type']:checked").val();
			window.virtual = $("#virtual").val();
			if(window.type=='1'||window.type=='4'){
				$('.dispatch_info').show();
			} else {
				$('.dispatch_info').hide();
			}
			if (window.type == '2') {
				$('.send-group').show();
			} else {
				$('.send-group').hide();
			}
			if (window.type == '3') {
				if ($('#virtual').val() == '0') {
					$('.choosetemp').show();
				}
			}
			if (window.type == '2' || window.type == '3'|| window.type == '5') {
				$(':checkbox[name=cash]').attr("checked",false);
				$(':checkbox[name=cash]').parent().hide();
			} else {
				$(':checkbox[name=cash]').parent().show();

			}
		})

		$(":checkbox[name='buyshow']").click(function () {
			if ($(this).prop('checked')) {
				$(".bcontent").show();
			}
			else {
				$(".bcontent").hide();
			}
		})

		$(':radio[name=buyshow]').click(function () {
			window.buyshow = $("input[name='buyshow']:checked").val();

			if(window.buyshow=='1'){
				$('.bcontent').show();
			} else {
				$('.bcontent').hide();
			}
		})
	})

	window.optionchanged = false;

	$('form').submit(function(){
		var check = true;

		$(".tp_title,.tp_name").each(function(){
			var val = $(this).val();
			if(!val){
				$('#myTab a[href="#tab_diyform"]').tab('show');
				$(this).focus(),$('form').attr('stop',1),tip.msgbox.err('自定义表单字段名称不能为空!');
				check =false;
				return false;
			}
		});

		var diyformtype = $(':radio[name=diyformtype]:checked').val();

		if (diyformtype == 2) {
			if(kw == 0) {
				$('#myTab a[href="#tab_diyform"]').tab('show');
				$(this).focus(),$('form').attr('stop',1),tip.msgbox.err('请先添加自定义表单字段再提交!');
				check =false;
				return false;
			}
		}

		if(!check){return false;}

		window.type = $("input[name='type']:checked").val();
		window.virtual = $("#virtual").val();
		if ($("#goodsname").isEmpty()) {
			$('#myTab a[href="#tab_basic"]').tab('show');
			$('form').attr('stop',1);
			$(this).focus(),$('form').attr('stop',1),tip.msgbox.err('请填写商品名称!');
			return false;
		}

		var inum = 0;
		$('.gimgs').find('.img-thumbnail').each(function(){
			inum++;
		});
		if(inum == 0){
			$('#myTab a[href="#tab_basic"]').tab('show');
			$('form').attr('stop',1),tip.msgbox.err('请上传商品图片!');
			return false;
		}


		var full = true;
		if (window.type == '3') {
			if (window.virtual != '0') {  //如果单规格，不能有规格
				if ($('#hasoption').get(0).checked) {
					$('form').attr('stop',1),tip.msgbox.err('您的商品类型为：虚拟物品(卡密)的单规格形式，需要关闭商品规格！');
					return false;
				}
			}
			else {

				var has = false;
				$('.spec_item_virtual').each(function () {
					has = true;
					if ($(this).val() == '' || $(this).val() == '0') {
						$('#myTab a[href="#tab_option"]').tab('show');
						$(this).next().focus();
						$('form').attr('stop',1),tip.msgbox.err('请选择虚拟物品模板!');
						full = false;
						return false;
					}
				});
				if (!has) {
					$('#myTab a[href="#tab_option"]').tab('show');
					$('form').attr('stop',1),tip.msgbox.err('您的商品类型为：虚拟物品(卡密)的多规格形式，请添加规格！');
					return false;
				}
			}
		}
		else if (window.type == '5') {
			if ($('#hasoption').get(0).checked) {
				$('form').attr('stop',1),tip.msgbox.err('您的商品类型为：核销产品，无法设置多商品规格！');
				return false;
			}
		}
		else if(window.type=='10'){
			var spec_itemlen = $(".spec_item").length;
			if (!$('#hasoption').get(0).checked || spec_itemlen<1) {
				$('#myTab a[href="#tab_option"]').tab('show');
				$('form').attr('stop',1),tip.msgbox.err('您的商品类型为：话费流量充值，需要开启并设置商品规格！');
				return false;
			}
			if(spec_itemlen>1){
				$('#myTab a[href="#tab_option"]').tab('show');
				$('form').attr('stop',1),tip.msgbox.err('您的商品类型为：话费流量充值，只可添加一个规格！');
				return false;
			}
		}
		if (!full) {
			return false;
		}

		full = checkoption();
		if (!full) {
			$('form').attr('stop',1),tip.msgbox.err('请输入规格名称!');
			return false;
		}
		if (optionchanged) {
			$('#myTab a[href="#tab_option"]').tab('show');
			$('form').attr('stop',1),tip.msgbox.err('规格数据有变动，请重新点击 [刷新规格项目表] 按钮!');
			return false;
		}
		var spec_item_title = 1;
		$(".spec_item").each(function (i) {
			var _this = this;
			if($(_this).find(".spec_item_title").length == 0){
				spec_item_title = 0;
			}
		});
		if(spec_item_title == 0){
			$('form').attr('stop',1),tip.msgbox.err('详细规格没有填写,请填写详细规格!');
			return false;
		}
		$('form').attr('stop',1);
		//处理规格
		optionArray();
		isdiscountDiscountsArray();
		discountArray();
		commissionArray();
		$('form').removeAttr('stop');
		return true;
	});

	function optionArray()
	{
		var option_stock = new Array();
		$('.option_stock').each(function (index,item) {
			option_stock.push($(item).val());
		});

		var option_id = new Array();
		$('.option_id').each(function (index,item) {
			option_id.push($(item).val());
		});

		var option_ids = new Array();
		$('.option_ids').each(function (index,item) {
			option_ids.push($(item).val());
		});

		var option_title = new Array();
		$('.option_title').each(function (index,item) {
			option_title.push($(item).val());
		});

		var option_virtual = new Array();
		$('.option_virtual').each(function (index,item) {
			option_virtual.push($(item).val());
		});

		var option_marketprice = new Array();
		$('.option_marketprice').each(function (index,item) {
			option_marketprice.push($(item).val());
		});
		var option_presellprice = new Array();
		$('.option_presell').each(function (index,item) {
			option_presellprice.push($(item).val());
		});

		var option_productprice = new Array();
		$('.option_productprice').each(function (index,item) {
			option_productprice.push($(item).val());
		});

		var option_costprice = new Array();
		$('.option_costprice').each(function (index,item) {
			option_costprice.push($(item).val());
		});

		var option_goodssn = new Array();
		$('.option_goodssn').each(function (index,item) {
			option_goodssn.push($(item).val());
		});

		var option_productsn = new Array();
		$('.option_productsn').each(function (index,item) {
			option_productsn.push($(item).val());
		});

		var option_weight = new Array();
		$('.option_weight').each(function (index,item) {
			option_weight.push($(item).val());
		});

		var options = {
			option_stock : option_stock,
			option_id : option_id,
			option_ids : option_ids,
			option_title : option_title,
			option_presellprice : option_presellprice,
			option_marketprice : option_marketprice,
			option_productprice : option_productprice,
			option_costprice : option_costprice,
			option_goodssn : option_goodssn,
			option_productsn : option_productsn,
			option_weight : option_weight,
			option_virtual : option_virtual
		};
		$("input[name='optionArray']").val(JSON.stringify(options));
	}

	function isdiscountDiscountsArray()
	{

		<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
		var isdiscount_discounts_<?php  echo $level['key'];?> = new Array();
		$(".isdiscount_discounts_<?php  echo $level['key'];?>").each(function (index,item) {
			isdiscount_discounts_<?php  echo $level['key'];?>.push($(item).val());
		});
		<?php  } } ?>

		var isdiscount_discounts_id = new Array();
		$('.isdiscount_discounts_id').each(function (index,item) {
			isdiscount_discounts_id.push($(item).val());
		});

		var isdiscount_discounts_ids = new Array();
		$('.isdiscount_discounts_ids').each(function (index,item) {
			isdiscount_discounts_ids.push($(item).val());
		});

		var isdiscount_discounts_title = new Array();
		$('.isdiscount_discounts_title').each(function (index,item) {
			isdiscount_discounts_title.push($(item).val());
		});

		var isdiscount_discounts_virtual = new Array();
		$('.isdiscount_discounts_virtual').each(function (index,item) {
			isdiscount_discounts_virtual.push($(item).val());
		});

		var options = {
		<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
		isdiscount_discounts_<?php  echo $level['key'];?> : isdiscount_discounts_<?php  echo $level['key'];?>,
		<?php  } } ?>
		isdiscount_discounts_id : isdiscount_discounts_id,
				isdiscount_discounts_ids : isdiscount_discounts_ids,
			isdiscount_discounts_title : isdiscount_discounts_title,
			isdiscount_discounts_virtual : isdiscount_discounts_virtual
	};
		$("input[name='isdiscountDiscountsArray']").val(JSON.stringify(options));
	}

	function discountArray()
	{

		<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
		var discount_<?php  echo $level['key'];?> = new Array();
		$(".discount_<?php  echo $level['key'];?>").each(function (index,item) {
			discount_<?php  echo $level['key'];?>.push($(item).val());
		});
		<?php  } } ?>

		var discount_id = new Array();
		$('.discount_id').each(function (index,item) {
			discount_id.push($(item).val());
		});

		var discount_ids = new Array();
		$('.discount_ids').each(function (index,item) {
			discount_ids.push($(item).val());
		});

		var discount_title = new Array();
		$('.discount_title').each(function (index,item) {
			discount_title.push($(item).val());
		});

		var discount_virtual = new Array();
		$('.discount_virtual').each(function (index,item) {
			discount_virtual.push($(item).val());
		});

		var options = {
		<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
		discount_<?php  echo $level['key'];?> : discount_<?php  echo $level['key'];?>,
		<?php  } } ?>
		discount_id : discount_id,
				discount_ids : discount_ids,
			discount_title : discount_title,
			discount_virtual : discount_virtual
	};
		$("input[name='discountArray']").val(JSON.stringify(options));
	}

	function commissionArray()
	{
		var specs = [];
		$(".spec_item").each(function (i) {
			var _this = $(this);

			var spec = {
				id: _this.find(".spec_id").val(),
				title: _this.find(".spec_title").val()
			};

			var items = [];
			_this.find(".spec_item_item").each(function () {
				var __this = $(this);
				var item = {
					id: __this.find(".spec_item_id").val(),
					title: __this.find(".spec_item_title").val(),
					virtual: __this.find(".spec_item_virtual").val(),
					show: __this.find(".spec_item_show").get(0).checked ? "1" : "0"
				}
				items.push(item);
			});
			spec.items = items;
			specs.push(spec);
		});
		specs.sort(function (x, y) {
			if (x.items.length > y.items.length) {
				return 1;
			}
			if (x.items.length < y.items.length) {
				return -1;
			}
		});

		var len = specs.length;
		var newlen = 1;
		var h = new Array(len);
		var rowspans = new Array(len);
		for (var i = 0; i < len; i++) {
			var itemlen = specs[i].items.length;
			if (itemlen <= 0) {
				itemlen = 1
			}
			newlen *= itemlen;
			h[i] = new Array(newlen);
			for (var j = 0; j < newlen; j++) {
				h[i][j] = new Array();
			}
			var l = specs[i].items.length;
			rowspans[i] = 1;
			for (j = i + 1; j < len; j++) {
				rowspans[i] *= specs[j].items.length;
			}
		}

		for (var m = 0; m < len; m++) {
			var k = 0, kid = 0, n = 0;
			for (var j = 0; j < newlen; j++) {
				var rowspan = rowspans[m];
				if (j % rowspan == 0) {
					h[m][j] = {
						title: specs[m].items[kid].title,
						virtual: specs[m].items[kid].virtual,
						id: specs[m].items[kid].id
					};
				}
				else {
					h[m][j] = {
						title: specs[m].items[kid].title,
						virtual: specs[m].items[kid].virtual,
						id: specs[m].items[kid].id
					};
				}
				n++;
				if (n == rowspan) {
					kid++;
					if (kid > specs[m].items.length - 1) {
						kid = 0;
					}
					n = 0;
				}
			}
		}

		var commission = {};
		var commission_level = <?php  echo json_encode($commission_level)?>;
		for (var i = 0; i < newlen; i++) {
			var ids = [];
			for (var j = 0; j < len; j++) {
				ids.push(h[j][i].id);
			}
			ids = ids.join('_');
			$.each(commission_level,function (key,val) {
				if(val.key == 'default')
				{
					var kkk = "commission_level_"+val.key+"_"+ids;
					commission[kkk] = {};
					$("input[data-name=commission_level_"+val.key+"_"+ids+"]").each(function (k,v) {
						commission[kkk][k] = $(v).val();
					});
				}
				else
				{
					var kkk = "commission_level_"+val.id+"_"+ids;
					commission[kkk] = {};
					$("input[data-name=commission_level_"+val.id+"_"+ids+"]").each(function (k,v) {
						commission[kkk][k] = $(v).val();
					});
					var kkk = "commission_level_"+val.id+"_"+ids;
					commission[kkk] = {};
					$("input[data-name=commission_level_"+val.id+"_"+ids+"]").each(function (k,v) {
						commission[kkk][k] = $(v).val();
					});
				}
			})
		}

		var commission_id = new Array();
		$('.commission_id').each(function (index,item) {
			commission_id.push($(item).val());
		});

		var commission_ids = new Array();
		$('.commission_ids').each(function (index,item) {
			commission_ids.push($(item).val());
		});

		var commission_title = new Array();
		$('.commission_title').each(function (index,item) {
			commission_title.push($(item).val());
		});

		var commission_virtual = new Array();
		$('.commission_virtual').each(function (index,item) {
			commission_virtual.push($(item).val());
		});



		var options = {
			commission : commission,
			commission_id : commission_id,
			commission_ids : commission_ids,
			commission_title : commission_title,
			commission_virtual : commission_virtual
		};
		$("input[name='commissionArray']").val(JSON.stringify(options));
	}

	function checkoption() {

		var full = true;
		var $spec_title = $(".spec_title");
		var $spec_item_title = $(".spec_item_title");
		if ($("#hasoption").get(0).checked) {
			if($spec_title.length==0){
				$('#myTab a[href="#tab_option"]').tab('show');
				full = false;
			}
			if($spec_item_title.length==0){
				$('#myTab a[href="#tab_option"]').tab('show');
				full = false;
			}
		}
		if (!full) {
			return false;
		}
		return full;
	}

	function type_change(type) {
		if(type == 4) {
			$(".interval").show();
			$(".price").hide();
			$(".minbuy").hide();
			$(".wholesalewarning").show();
		}else{
			$(".interval").hide();
			$(".price").show();
			$(".minbuy").show();
			$(".wholesalewarning").hide();
		}

		if(type == 5) {
			$(".showverifygoods").show();
			$(".showverifygoodscard").show();
			$('#product').hide();
			$('#type_virtual').hide();
			$("#tab_nav_verify").hide();

		}else
		{
			$(".showverifygoods").hide();
			$(".showverifygoodscard").hide();
		}

		if(type == 1||type == 4) {
			$('#product').show();
			$('#type_virtual').hide();
			$('.entity').show();
			$("#tab_nav_verify").show();
		} else if(type == 2) {
			$('#product').hide();
			$('#type_virtual').hide();
			$('.entity').hide();
			if($("input[name='virtualsend']:checked").val()==1) {
				$("#tab_nav_verify").hide();
			}else{
				$("#tab_nav_verify").show();
			}
		} else if(type == 3) {
			$('#type_virtual').show();
			$('.entity').hide();
			$("#tab_nav_verify").hide();
		}else if(type == 10) {
			$('#type_virtual').hide();
			$('#product').hide();
			$('.entity').hide();
			$("#tab_nav_verify").hide();
		}
	}

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

