<?
// english doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					
          <td bgcolor="#FFFFFF"><b>T&iacute;tulo</b></td>
					
          <td bgcolor="#FFFFFF"><b>Argumento</b></td>
					
          <td bgcolor="#FFFFFF"><b>Descri&ccedil;&atilde;o</b></td>
				</tr>
				<tr> 
					
          <td bgcolor="#FFFFFF">IP do Cliente</td>
					
          <td bgcolor="#FFFFFF">IP rede/m&aacute;scara: ip.ip.ip.ip/mask.mask.mask.mask, 
            por exemplo 127.0.0.1/255.255.255.0</td>
					
          <td bgcolor="#FFFFFF">Mostra o banner apenas para uma regi&atilde;o 
            especificada pelo IP (Brasil: 200.x.x.x)</td>
				</tr>
				<tr> 
					
          <td bgcolor="#FFFFFF">Navegador do Cliente</td>
					
          <td bgcolor="#FFFFFF">Express&atilde;o coincidente com o navegador de 
            um usu&aacute;rio. Ex.: Mozilla/4.? ou MSIE/5.?</td>
		 			
          <td bgcolor="#FFFFFF">Mostra o banner apenas para o navegador especificado</td>
				</tr>
				<tr> 
					
          <td bgcolor="#FFFFFF">Dia da semana</td>
          <td bgcolor="#FFFFFF">Dia da semana (domingo: 0 - s&aacute;bado:6)</td>
					
          <td bgcolor="#FFFFFF">Mostra o banner apenas no dia da semana determinado</td>
				</tr>
				<tr>
					
          <td bgcolor="#FFFFFF">Dom&iacute;nio</td>
					
          <td bgcolor="#FFFFFF">Sufixo de dom&iacute;nio (ex.: br, com.br, org, 
            onda.com.br), sem o primeiro ponto</td>
					
          <td bgcolor="#FFFFFF">Exibe o banner apenas para os dom&iacute;nios 
            determinados </td>
				</tr>
				<tr>
					
          <td bgcolor="#FFFFFF">Fonte</td>
					
          <td bgcolor="#FFFFFF">Nome da p&aacute;gina fonte</td>
					
          <td bgcolor="#FFFFFF">Exibe o banner apenas em determinadas p&aacute;ginas</td>
				</tr>
                <tr> 
                    
          <td bgcolor="#FFFFFF">Hora</td>
                    
          <td bgcolor="#FFFFFF">Hora do dia (0 = meia-noite, 23 = 11 da noite)</td>
                    
          <td bgcolor="#FFFFFF">Mostra o banner apenas nas horas determinadas</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Por exemplo, se voc&ecirc; deseja que um banner seja exibido apenas nos fins-de-semana, 
  voc&ecirc; teria 2 entradas LCA:</p>
<ul>
  <li>Dia da Semana (0-6), 
    <? echo $strAllow; ?>
    , argumento 6 (para s&aacute;bado)</li>
  <li>Dia da Semana (0-6), 
    <? echo $strAllow; ?>
    , argumento 0 (para domingo)</li>
  <li>Dia da Semana (0-6), 
    <? echo $strDeny; ?>
    , argumento * (para qualquer dia)</li>
</ul>
Note que a &uacute;ltima entrada n&atilde;o precisaria ser &quot;Dia da Semana&quot;. 
Qualquer LCA 
<? echo $strDeny; ?>
* seria sufu\iciente para bloquear um banner que n&atilde;o tenha um LCA 
<? echo $strAllow; ?>
associado
<p>Para exibir o banner entre 5 da tarde e 8 da noite:</p>
<ul>
  <li>Hora, 
    <? echo $strAllow; ?>
    , argumento 17</li>
  (17:00- 17:59pm) 
  <li>Hora, 
    <? echo $strAllow; ?>
    , argumento 18</li>
  (18:00pm - 18:59pm) 
  <li>Hora, 
    <? echo $strAllow; ?>
    , argumento 19</li>
  (19:00pm - 19:59pm) 
  <li>Hora, 
    <? echo $strDeny; ?>
    , argumento * (para qualquer hora)</li>
</ul>
<?
// EOF english doc file for Banner ACL administration
?>
