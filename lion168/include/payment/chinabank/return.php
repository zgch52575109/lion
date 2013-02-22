<?php
require_once ("../../common.php");
require_once (EK_INC."/check.member.php");
CheckRank(0,0);
class _wespace_apis_payment_return_{
function loader(){
global $dsql,$cfg_ml,$cfg_basehost;
$result = 0;
$config = array();
$variable = array();
$variable['v_mid']			= trim($_POST['v_oid']);
$variable['v_pmode']		= trim($_POST['v_pmode']);
$variable['v_pstatus']		= trim($_POST['v_pstatus']);
$variable['v_pstring']		= trim($_POST['v_pstring']);
$variable['v_amount']		= trim($_POST['v_amount']);
$variable['v_moneytype']	= trim($_POST['v_moneytype']);
$variable['remark1']		= trim($_POST['remark1']);
$variable['remark2']		= trim($_POST['remark2']);
$variable['v_md5str']		= trim($_POST['v_md5str']);
$decodes = explode("\t",$this->_base_endecode_($variable['remark1'],1));
$decodes['0'] = is_numeric($decodes['0']) && $decodes['0'] > 0 ? intval($decodes['0']) : 0; // id.payment.api
$decodes['1'] = is_numeric($decodes['1']) && $decodes['1'] > 0 ? intval($decodes['1']) : 0; // id.payment.record
$decodes['3'] = is_numeric($decodes['3']) && $decodes['3'] > 0 ? sprintf('%.02f',$decodes['3']) : 0.00; // price
if ($decodes['0']){
$fetch = $dsql->GetOne("SELECT * FROM ek_payment_config WHERE id = '{$decodes[0]}' AND used = '1' AND upid = '0'");
if ($fetch['id']){
$config['api'] = &$fetch;
$dsql->SetQuery("SELECT * FROM ek_payment_config WHERE upid = '{$decodes[0]}'");
$dsql->Execute('config_list');
while ($apier = $dsql->GetArray('config_list')){
$config['conf'][$apier['confkey']] = $apier['confval'];
}
}
$md5string = strtoupper(md5($variable['v_mid'].$variable['v_pstatus'].$variable['v_amount'].$variable['v_moneytype'].$config['conf']['authkey']));
if ($md5string == $variable['v_md5str'] && $variable['v_pstatus'] == '20'){
$result = 1;
}
}
if ($result){
$mtime=time();
$dsql->ExecuteNoneQuery("update `ek_member` set money='$vars[total_fee]' where uid='{$cfg_cl->M_ID}'");
$dsql->ExecuteNoneQuery("update `ek_member_incash` set state='2' where orderid='{$decodes[1]}'");
}
$result=$result ? 'success' : 'fail';
$rtnUrl=$cfg_basehost."/member/";
header("Location:$rtnUrl");
}
}
$wespace = new _wespace_apis_payment_return_();
$wespace->loader();
?>