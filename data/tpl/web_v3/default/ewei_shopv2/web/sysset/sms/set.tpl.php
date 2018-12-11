<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<form <?php if(cv('sysset.sms.set')) { ?>method="post"<?php  } ?> class="form-horizontal form-validate">

    <div class="page-header">

        当前位置：<span class="text-primary">短信提醒</span>
    </div>
    <div class="page-content">

        <div class="alert alert-primary">
            <h4 style="font-weight: 500">短信提醒配置说明</h4>
            <p>短信提醒现支持 <a href="http://www.juhe.cn" target="_blank">聚合数据</a>、<a href="http://www.alidayu.com" target="_blank">阿里大于(老用户)</a>、<a href="https://market.aliyun.com/products/57002003/cmapi011900.html" target="_blank">阿里云短信</a>、<a href="http://www.emay.cn" target="_blank">亿美软通</a>四家行业领先接口，接口所有参数需在此处设置。</p>
            <p>参数设置：在此页面开启所需的服务商API并设置服务商提供的参数。</p>
            <p>余额预警：聚合数据、阿里大于需在服务商管理后台设置余额预警，亿美软通需在当前页面设置余额预警。</p>
            <p>余额查询：聚合数据、阿里大于需在服务商管理后台查看账户余额，亿美软通需在当前查看账户余额(设置好参数保存页面即可查看)。</p>
            <p>其他说明：阿里大于老用户仍然可以使用，但新用户仅支持<a href="https://market.aliyun.com/products/57002003/cmapi011900.html" target="_blank">阿里云短信</a></p>
        </div>

        <div class="form-group-title">聚合数据<small style="padding-left: 10px;"><a class="text-primary" target="_blank" href="http://www.juhe.cn">立即申请</a></small>
        <span class="pull-right">
            <input type="hidden" value="<?php  echo $item['juhe'];?>" name='juhe' />
            <input class="js-switch small" type="checkbox" <?php  if(!empty($item['juhe'])) { ?>checked<?php  } ?>/>
        </span>
        </div>
        <div class=" sms-juhe" style="<?php  if(empty($item['juhe'])) { ?>display: none;<?php  } ?>">
            <div class="form-group">
                <label class="col-lg control-label must">App Key</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="juhe_key" class="form-control valid" value="<?php  echo $item['juhe_key'];?>" data-rule-required="true">
                </div>
            </div>
        </div>

        <div class="form-group-title">阿里大于(老用户)<small style="padding-left: 10px;"><a class="text-primary" target="_blank" href="javascript:;">暂停申请</a></small>
        <span class="pull-right">
            <input type="hidden" value="<?php  echo $item['dayu'];?>" name='dayu' />
            <input class="js-switch small" type="checkbox" <?php  if(!empty($item['dayu'])) { ?>checked<?php  } ?>/>
        </span>
        </div>
        <div class=" sms-dayu" style="<?php  if(empty($item['dayu'])) { ?>display: none;<?php  } ?>">
            <div class="form-group">
                <label class="col-lg control-label must">App Key</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="dayu_key" class="form-control valid" value="<?php  echo $item['dayu_key'];?>" data-rule-required="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label must">App Secret</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="dayu_secret" class="form-control valid" value="<?php  echo $item['dayu_secret'];?>" data-rule-required="true">
                </div>
            </div>
        </div>

        <div class="form-group-title">阿里云短信<small style="padding-left: 10px;"><a target="_blank" href="https://market.aliyun.com/products/57002003/cmapi011900.html">立即申请</a></small>
            <span class="pull-right">
            <input type="hidden" value="<?php  echo $item['aliyun'];?>" name='aliyun' />
            <input class="js-switch small" type="checkbox" <?php  if(!empty($item['aliyun'])) { ?>checked<?php  } ?>/>
        </span>
        </div>
        <div class=" sms-aliyun" style="<?php  if(empty($item['aliyun'])) { ?>display: none;<?php  } ?>">
            <div class="form-group">
                <label class="col-sm-2 control-label must">App Code</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="aliyun_appcode" class="form-control valid" value="<?php  echo $item['aliyun_appcode'];?>" data-rule-required="true">
                </div>
            </div>
        </div>

        <div class="form-group-title">亿美软通 <small>(<span class="text-danger">余额: <span  id="num_emay">--</span></span>)</small><small style="padding-left: 10px;"><a class="text-primary" target="_blank" href="http://www.emay.cn">立即申请</a></small>
            <span class="pull-right">
                <input type="hidden" value="<?php  echo $item['emay'];?>" name='emay' />
                <input class="js-switch small" type="checkbox" <?php  if(!empty($item['emay'])) { ?>checked<?php  } ?>/>
            </span>
        </div>
        <div class=" sms-emay" style="<?php  if(empty($item['emay'])) { ?>display: none;<?php  } ?>">
            <div class="form-group">
                <label class="col-lg control-label must">网关地址</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="emay_url" class="form-control valid" value="<?php  echo $item['emay_url'];?>" data-rule-required="true">
                    <div class="help-block">请求地址，请以http://或https://开头</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label must" style="padding-top: 0;">序列号serialNumber</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="emay_sn" class="form-control valid" value="<?php  echo $item['emay_sn'];?>" data-rule-required="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label must">密码</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="emay_pw" class="form-control valid" value="<?php  echo $item['emay_pw'];?>" data-rule-required="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label must">SESSION KEY</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="emay_sk" class="form-control valid" value="<?php  echo $item['emay_sk'];?>" data-rule-required="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-lg col-md-2 col-lg-2 control-label">代理服务器设置</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='input-group'>
                        <div class='input-group-addon'>地址</div>
                        <input type="text" name="emay_phost" class="form-control" value="<?php  echo $item['emay_phost'];?>" />
                        <div class='input-group-addon' style="border-left: 0; border-right: 0;">端口</div>
                        <input type="text" name="emay_pport" class="form-control" value="<?php  echo $item['emay_pport'];?>" />
                        <div class='input-group-addon' style="border-left: 0; border-right: 0;">用户</div>
                        <input type="text" name="emay_puser" class="form-control" value="<?php  echo $item['emay_puser'];?>" />
                        <div class='input-group-addon' style="border-left: 0; border-right: 0;">密码</div>
                        <input type="text" name="emay_ppw" class="form-control" value="<?php  echo $item['emay_ppw'];?>" />
                    </div>
                    <div class="help-block">可选，代理服务器设置，如果地址不填写则不使用代理服务器</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-lg col-md-2 col-lg-2 control-label">超时时间设置</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='input-group'>
                        <div class='input-group-addon'>连接超时时间</div>
                        <input type="text" name="emay_out" class="form-control" value="<?php  echo $item['emay_out'];?>" />
                        <div class='input-group-addon' style="border-left: 0; border-right: 0;">信息返回超时时间</div>
                        <input type="text" name="emay_outresp" class="form-control" value="<?php  echo $item['emay_outresp'];?>" />
                    </div>
                    <div class="help-block">连接超时时间，默认0，为不超时；信息返回超时时间，如果不填写默认为30</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-lg col-md-2 col-lg-2 control-label">余额预警</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='input-group'>
                        <div class='input-group-addon'>预警余额</div>
                        <input type="number" name="emay_warn" class="form-control" value="<?php  echo $item['emay_warn'];?>" />
                        <div class='input-group-addon' style="border-left: 0; border-right: 0;">手机号码</div>
                        <input type="tel" name="emay_mobile" class="form-control" value="<?php  echo $item['emay_mobile'];?>" />
                    </div>
                    <div class="help-block">可选，当账户余额小于设定值(元)时向上方手机号发送提示(请参考 上方亿美软通余额, 如果余额不足预警短信也将发送不出, 不填则不发送，24小时内只发一次)</div>
                </div>
            </div>
        </div>
        <div class='input-group'>
            <label class="col-lg control-label"></label>
            <?php if(cv('sysset.sms.set')) { ?>
                <span class="">
                    <input type="submit" value="保存" class="btn btn-primary ">
                </span>
            <?php  } ?>
        </div>
    </div>

</form>

<script>
    $(function () {
        $(".js-switch").click(function () {
            $(this).prev().val( this.checked ?1:0);
            var smsname =$(this).prev().attr('name');
            if (this.checked) {
                $(".sms-"+smsname).show();
            } else {
                $(".sms-"+smsname).hide();
            }
        });
        $.post("<?php  echo webUrl('sysset/sms/getnum')?>", function (r) {
            if(r.status && r.result){
                $.each(r.result, function (type, num) {
                    $("#num_"+type).text(num);
                })
            }
        }, 'json');
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>