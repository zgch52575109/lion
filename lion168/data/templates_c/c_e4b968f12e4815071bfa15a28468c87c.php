<div id="informlist">
<ul>
  <?php if (count((array)$this->_vars['noticear'])): foreach ((array)$this->_vars['noticear'] as $this->_vars['key'] => $this->_vars['data']): ?>
  <li><a href="member/notice.php"><?php echo $this->_vars['data']['l_body']; ?>
</a></li>
  <?php endforeach; endif; ?>
</ul>
</div>