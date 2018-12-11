<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary">购买页面 </span>
</div>
<div class="page-content">
<form action="/index.php">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="quick.pages" />

    <div class="page-toolbar m-b-sm m-t-sm">
        <div class="col-sm-4">
            <?php if(cv('quick.pages.add')) { ?>
            <div class="">
                <a href="<?php  echo webUrl('quick/pages/add')?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 新建页面</a>
            </div>
            <?php  } ?>
        </div>
        <div class="col-sm-6 pull-right">
            <div class="input-group">
                <div class="input-group-select">
                    <select name="status" class='form-control'>
                        <option value="" <?php  if($_GPC['status'] == '') { ?> selected<?php  } ?>>状态</option>
                        <option value="1" <?php  if($_GPC['status']== '1') { ?> selected<?php  } ?>>开启</option>
                        <option value="0" <?php  if($_GPC['status'] == '0') { ?> selected<?php  } ?>>关闭</option>
                    </select>
                </div>
                <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入页面标题关键字进行搜索">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit"> 搜索</button>
                </span>
            </div>
        </div>
    </div>
</form>

<?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body" style="text-align: center;padding:30px;">
            未查询到<?php  if(!empty($_GPC['keyword'])) { ?>"<?php  echo $_GPC['keyword'];?>"<?php  } ?>相关页面!
        </div>
    </div>
<?php  } else { ?>
    <div class="page-table-header">
        <input type="checkbox">
        <div class="btn-group">
            <?php if(cv('quick.pages.delete')) { ?>
            <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除?" data-href="<?php  echo webUrl('quick/pages/delete')?>" disabled="disabled">
                <i class="icow icow-shanchu1"></i> 删除</button>
            <?php  } ?>
        </div>
    </div>
    <table class="table table-hover table-responsive">
        <thead>
        <tr>
            <th style="width:25px;"></th>
            <th>页面标题</th>
            <th >关键字</th>
            <th>创建时间</th>
            <th>最后修改时间</th>
            <th class="text-center">状态</th>
            <th style="width: 110px">操作</th>
        </tr>
        </thead>
        <tbody>
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><input type="checkbox" value="<?php  echo $item['id'];?>"></td>
                    <td><?php  echo $item['title'];?></td>
                    <td><?php  if(!empty($item['keyword'])) { ?><?php  echo $item['keyword'];?><?php  } else { ?>未设置<?php  } ?></td>
                    <td><?php  echo date("Y-m-d", $item['createtime'])?><br><?php  echo date("H:i:s", $item['createtime'])?></td>
                    <td><?php  echo date("Y-m-d", $item['lasttime'])?><br><?php  echo date("H:i:s", $item['lasttime'])?></td>
                    <td style="text-align: center;">
                        <span class='label <?php  if($item['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
                        <?php if(cv('quick.pages.edit')) { ?>
                            style="cursor: pointer"
                            data-toggle="ajaxSwitch"
                            data-confirm = "确认<?php  if($item['status']==1) { ?>关闭<?php  } else { ?>开启<?php  } ?>吗？"
                            data-switch-value="<?php  echo $item['status'];?>"
                            data-switch-value0="0|关闭|label label-default|<?php  echo webUrl('quick/pages/status',array('status'=>1,'id'=>$item['id']))?>"
                            data-switch-value1="1|开启|label label-primary|<?php  echo webUrl('quick/pages/status',array('status'=>0,'id'=>$item['id']))?>"
                        <?php  } ?>>
                        <?php  if($item['status']==1) { ?>开启<?php  } else { ?>关闭<?php  } ?>
                        </span>
                    </td>
                    <td>
                        <?php if(cv('quick.pages.view|quick.pages.edit')) { ?>
                            <a class="btn btn-default btn-sm btn-op btn-operation" href="<?php  echo webUrl('quick/pages/edit', array('id'=>$item['id']))?>">
                                 <span data-toggle="tooltip" data-placement="top" title="" data-original-title=" <?php if(cv('quick.pages.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                                     <?php if(cv('quick.pages.edit')) { ?>
                                    <i class="icow icow-bianji2"></i>
                                     <?php  } else { ?>
                                     <i class="icow icow-chakan-copy"></i>
                                     <?php  } ?>
                                 </span>
                            </a>
                        <?php  } ?>
                        <?php if(cv('quick.pages.delete')) { ?>
                            <a class="btn btn-default btn-sm btn-op btn-operation" href="<?php  echo webUrl('quick/pages/delete', array('id'=>$item['id']))?>" data-toggle='ajaxRemove' data-confirm="删除后不可恢复！确认删除吗？">
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                        <i class='icow icow-shanchu1'></i>
                                   </span>
                            </a>
                        <?php  } ?>
                        <a class="btn btn-default btn-sm js-clip btn-op btn-operation" title="复制链接" data-href="<?php  echo mobileUrl('quick', array('id'=>$item['id']), true)?>">
                            <span data-toggle="tooltip" data-placement="top"  data-original-title="复制链接">
                                       <i class='icow icow-lianjie2'></i>
                                   </span>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-op btn-operation" data-toggle="popover" data-trigger="hover" data-html="true"
                           data-content="<img src='<?php  echo $item['qrcode'];?>' width='130' alt='链接二维码'>" data-placement="auto right">
                            <i class="icow icow-erweima3"></i>
                        </a>
                    </td>
                </tr>
            <?php  } } ?>
        </tbody>
        <tfoot>
            <tr>
                <td><input type="checkbox"></td>
                <td colspan="2">
                    <div class="btn-group">
                        <?php if(cv('quick.pages.delete')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除?" data-href="<?php  echo webUrl('quick/pages/delete')?>" disabled="disabled">
                            <i class="icow icow-shanchu1"></i> 删除</button>
                        <?php  } ?>
                    </div>
                </td>
                <td colspan="4" class="text-right"><?php  echo $pager;?></td>
            </tr>
        </tfoot>
    </table>
<?php  } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
