<?
$module_id = 'sporina.easysite';

if (!check_bitrix_sessid())
	return;

$session = explode('=', bitrix_sessid_get());

echo CAdminMessage::ShowNote(GetMessage("SPORINA_START_MASTER"));
?>

<form action="/bitrix/admin/wizard_install.php" method="get">
    <input type="hidden" name="lang" value="<?php echo LANG?>"/> 
    <input type="hidden" name="<?php echo $session[0]?>" value="<?php echo $session[1]?>"/> 
	<input type="hidden" name="wizardName" value="sporina:easy_site"/> 
    <input type="button" onclick="onBackClick()" value="<?php echo GetMessage("MOD_BACK")?>"/>
	<input type="submit" name="" value="<?php echo GetMessage("START_MASTER")?>"/>
</form>
<script type="text/javascript">
function onBackClick()
{
    window.location.reload();
}
</script>