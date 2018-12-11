<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($cubes)) { ?>
	<div class="fui-cube">

			<div class="fui-cube-left">
				<img data-lazy="<?php  echo tomedia($cubes[0]['img'])?>" <?php  if(!empty($cubes[0]['url'])) { ?>onclick="location.href='<?php  echo $cubes[0]['url'];?>'"<?php  } ?> />
			</div>
			<div class="fui-cube-right">
          <img data-lazy="<?php  echo tomedia($cubes[1]['img'])?>" <?php  if(!empty($cubes[1]['url'])) { ?>onclick="location.href='<?php  echo $cubes[1]['url'];?>'"<?php  } ?> />
			</div>
      <div style="width: 100%;height: 49%;position: absolute;top: 51%;left: 0;" >
      <img data-lazy="<?php  echo tomedia($cubes[2]['img'])?>" <?php  if(!empty($cubes[2]['url'])) { ?>onclick="location.href='<?php  echo $cubes[2]['url'];?>'"<?php  } ?> />
    </div>
	</div>
<?php  } ?>

