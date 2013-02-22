<div class="t">
    <div class="topmeber">
      <span style=" float:left; width:203px; margin-left:84px">
        <div>用户：<?php echo $this->_vars['username']; ?>
</div>
        <div>级别：<?php echo $this->_vars['groupname']; ?>
</div>
        <div>活跃：<?php echo $this->_vars['activenm']; ?>
</div>
        <div>余额：<?php echo $this->_vars['money']; ?>
</div>
      </span>
      <span>
        <div>今日真人有效：<?php echo $this->_vars['todayLiveGameExcludeEvenandTieAmount']; ?>
</div>
        <div>本周真人有效：<?php echo $this->_vars['allweeklivetouzhumoney']; ?>
</div>
        <div>真人视讯投注：<?php echo $this->_vars['allLiveGameExcludeEvenandTieAmount']; ?>
</div>
        <div>总投注额：<?php echo $this->_vars['allStakedAmount']; ?>
</div>
      </span>
    </div>
</div>
<div class="mad"><marquee width=100% scrollamount=2 behavior=scroll direction=left><?php if (count((array)$this->_vars['newsar'])): foreach ((array)$this->_vars['newsar'] as $this->_vars['key'] => $this->_vars['data']): ?><a href="news.php" style=" text-decoration:none;font-size:12px; color:#FEB638;"><?php echo $this->_vars['data']['l_title']; ?>
</a> <?php endforeach; endif; ?></marquee></div>