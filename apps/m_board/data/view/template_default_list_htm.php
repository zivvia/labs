<?php
//Nemo Cache @ 2012-04-21 13:04:10
echo '';
include_once template("header.htm",'template/default/','','','');
if ($master) {
echo '
��<table width="100%" border="0" cellpadding="0" cellspacing="1" class="List">
	<tr>
		<th>�������</th>
		<th>��������</th>
		<th>������</th>
		<th>������</th>
		<th>����</th>
	</tr>
';
if(is_array($lovelist)) foreach ($lovelist as $love) {
echo '
<tr class="tr"><td class="ListA">';
echo $love['id'];
echo '</td>
<td class="ListB"><a href="'.$PHP_SELF.'?id=';
echo $love['id'];
echo '">'.$love['info'].'</a>��'.$love['ip'].'<a href='.$PHP_SELF.'?a=admin&m=del&id=';
echo $love['id'];
echo '><img src="images/close.gif" alt="ɾ��" />)</a></td>
<td class="ListC">'.$love['send'].'</td><td class=""ListC"">'.$love['pick'].'</td><td class=""ListD"">';
echo date("$a", $love['postdate']);
echo '</td></tr>    
';
}
echo '  
<tr>
	<td colspan="5" class="ListP">
			<a href="'.$PHP_SELF.'?a=admin&m=editpass">�޸�����</a>������������'.$row.'�� '.$dispage.'
	</td>
</tr>
</table>
';
} else {
echo '
��<table width="100%" border="0" cellpadding="0" cellspacing="1" class="List">
	<tr>
		<th>�������</th>
		<th>��������</th>
		<th>������</th>
		<th>������</th>
		<th>����</th>
	</tr>
';
if(is_array($lovelist)) foreach ($lovelist as $love) {
echo '
<tr class="tr"><td class="ListA">';
echo $love['id'];
echo '</td>
<td class="ListB"><a href="'.$PHP_SELF.'?id=';
echo $love['id'];
echo '">'.$love['info'].'</a></td>
<td class="ListC">'.$love['send'].'</td><td class=""ListC"">'.$love['pick'].'</td><td class=""ListD"">';
echo date("$a", $love['postdate']);
echo '</td></tr>    
';
}
echo '  
<tr>
	<td colspan="5" class="ListP">
			������������'.$row.'�� '.$dispage.'
	</td>
</tr>
</table>
';
}
include_once template("footer.htm",'template/default/','','','');
echo '';
?>