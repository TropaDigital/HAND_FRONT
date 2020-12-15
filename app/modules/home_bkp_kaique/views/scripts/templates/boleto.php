<?php /* <script>window.print();</script> */ ?>
<html>
	<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=850px, user-scalable=no" />
		

		<style>
			fieldset{
				border:0;
				padding-left:0;
				padding-bottom:0;
				font-family:Arial;
				font-size:11px;
				font-weight:bold;
			}
			legend{
				margin:0;
				font-family:Helvetica;
				font-size:9px;
			}
			td.boleto{
				vertical-align:top;
				border-bottom: 1px solid black;
				border-right: 1px solid black;
				border-collapse: collapse;
			}
		</style>
		
	<script src="/assets/home/js/boleto.min.js?v=1.21"></script>
	<script src="/assets/home/js/boleto.js?v=1.21"></script>
		
	</head>
	<body>
		
			<tr bgcolor="#fff" id="boleto_teste">
				<td colspan=2><font face="Verdana" color="#0032AB" size="1">&nbsp;</font>
					<div id="conteudo">
					<center>
						<hr size=1 width=800 style="border:1px dashed #999;">
						<br>
							<table width=800 style="border-spacing:0px;" bgcolor="#fff">
								<tr>
									<td class="boleto" style="vertical-align:center;align:center"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Banco_do_Brasil_logo.svg/2000px-Banco_do_Brasil_logo.svg.png" height=26 width=140></td>
									<td class="boleto" style="vertical-align:center;align:center"><font style="font-weight:bold;font-size:22;">001-9</font></td>
									<td class="boleto" colspan=5 style="border-right:0px;font-size:18;" align="right"><?php echo $_REQUEST['codbarras'];?></td>
								</tr>
								<tr>
									<td class="boleto" colspan=3><fieldset style="border:0"><legend>Beneficiário</legend>BANCO DO BRASIL S.A.</fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>Espécie</legend>Real</fieldset></td>
									<td class="boleto" colspan=2><fieldset style="border:0"><legend>Quantidade</legend></fieldset></td>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>Nosso Número</legend><?php echo $_REQUEST['codcli'];?></fieldset></td>
								</tr>
								<tr>
									<td class="boleto"  style="border-right:0px;"colspan=7><fieldset style="border:0"><legend>Endereço</legend>&nbsp;</fieldset></td>
								</tr>
								<tr>
									<td class="boleto"><fieldset style="border:0"><legend>Nº do Documento</legend>&nbsp;</fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>Contrato</legend><?php echo $_REQUEST['codcli'];?></fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>CPF / CNPJ / Beneficiário</legend></fieldset></td>
									<td class="boleto" colspan=2><fieldset style="border:0"><legend>Vencimento</legend><?php echo $_REQUEST['vencimento'];?></fieldset></td>
									<td class="boleto" style="border-right:0px;" colspan=2><fieldset style="border:0"><legend>Valor do documento</legend><?php echo $_REQUEST['saldo'];?></fieldset></td>
								</tr>
								<tr>
									<td class="boleto"><fieldset style="border:0"><legend>(-) Desconto / Abatimento</legend><br></fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>(-) Outras deduções</legend></fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>(-) Mora / Multa</legend></fieldset></td>
									<td class="boleto" colspan=2><fieldset style="border:0"><legend>(-) Outros acréscimos</legend></fieldset></td>
									<td class="boleto" colspan=2 style="border-right:0px;" bgcolor="#ddd"><fieldset style="border:0"><legend>(=) Valor cobrado</legend></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" style="border-right:0px;" colspan=7>
										<fieldset style="border:0">
											<legend>Pagador</legend>
											<br>
											<?php echo $_REQUEST['prinome'];?> - <?php echo $_REQUEST['codcli'];?><br>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td class="boleto" style="border-right:0px;" colspan=7>
										<fieldset style="border:0">
											<legend>Instruções (texto de responsabilidade do beneficiário)</legend>
											<br>
											*** RECEBER SOMENTE EM DINHEIRO ***<br>
											NAO RECEBER APOS 25 DIAS CORRIDOS DO VENCIMENTO<br>
											APOS O VENCIMENTO COBRAR JUROS DEFINIDOS PELO BANCO (FACP)            
											<br>
											<br>
											<br>
										</fieldset>
									</td>
								</tr>
							</table>
							<br>

							<hr size=1 width=800 style="border:1px dashed #999;">
							
							<br>
							<table width=800 style="border-spacing:0px;" bgcolor="#fff">
								<tr>
									<td class="boleto" style="vertical-align:center;align:center"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Banco_do_Brasil_logo.svg/2000px-Banco_do_Brasil_logo.svg.png" height=26 width=140></td>
									<td class="boleto" style="vertical-align:center;align:center"><font style="font-weight:bold;font-size:22;">001-9</font></td>
									<td class="boleto" colspan=5 style="border-right:0px;font-size:18;" align="right"><?php echo $_REQUEST['codbarras'];?></td>
								</tr>
								<tr>
									<td class="boleto" colspan=6><fieldset style="border:0"><legend>Local de Pagamento</legend>Pagável em qualquer banco até o vencimento</fieldset></td>
									<td class="boleto" style="border-right:0px;" bgcolor="#ddd"><fieldset style="border:0"><legend>Vencimento</legend><?php echo $_REQUEST['vencimento'];?></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" colspan=6>
										<fieldset style="border:0">
											<legend>Nome do Beneficiário / CNPJ / CPF</legend>
											BANCO DO BRASIL S.A.<br>
										</fieldset></td>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>Agência / Código do Beneficiário</legend>3477-0 / 28892001-5</fieldset></td>
								</tr>
								<tr>
									<td class="boleto"><fieldset style="border:0"><legend>Data do Documento</legend>&nbsp;</fieldset></td>
									<td class="boleto" colspan=2><fieldset style="border:0"><legend>Nº do Documento</legend>&nbsp;</fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>Espécie Doc.</legend>RC</fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>Aceite</legend>A</fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>Data Processamento</legend>&nbsp;</fieldset></td>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>Nosso Número</legend><?php echo $_REQUEST['codcli'];?></fieldset></td>
								</tr>
								<tr>
									<td class="boleto"><fieldset style="border:0"><legend>Carteira</legend>17</fieldset></td>
									<td class="boleto"><fieldset style="border:0"><legend>Espécie Moeda</legend>Real</fieldset></td>
									<td class="boleto" colspan=2><fieldset style="border:0"><legend>Quantidade da Moeda</legend></fieldset></td>
									<td class="boleto" colspan=2><fieldset style="border:0"><legend>xValor</legend></fieldset></td>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>(=) Valor do Documento</legend><?php echo $_REQUEST['saldo'];?></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" colspan=6 rowspan=5>
										<fieldset style="border:0">
											<legend>Instruções (texto de responsabilidade do beneficiário)</legend>
											<br>
											*** RECEBER SOMENTE EM DINHEIRO ***<br>
											NAO RECEBER APOS 25 DIAS CORRIDOS DO VENCIMENTO<br>
											APOS O VENCIMENTO COBRAR JUROS DEFINIDOS PELO BANCO (FACP)            
											<br>
											<br>
											<br>
										</fieldset></td>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>(-) Desconto / Abatimento</legend><br></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>(-) Outras deduções</legend><br></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>(-) Juros / Multa</legend><br></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" style="border-right:0px;"><fieldset style="border:0"><legend>(-) Outros acréscimos</legend><br></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" style="border-right:0px;" bgcolor="#ddd"><fieldset style="border:0"><legend>(=) Valor Cobrado</legend><br></fieldset></td>
								</tr>
								<tr>
									<td class="boleto" colspan=7 style="border-right:0px;">
										<fieldset style="border:0">
											<legend>Nome do Pagador / CPF / CNPJ</legend>
												<br>
												<?php echo $_REQUEST['prinome'];?> - <?php echo $_REQUEST['codcli'];?><br>
												<?php echo $_REQUEST['cpf_mascara'];?><br>
												<br>
										</fieldset>
									</td>
								</tr>
								<tr height="80">
									<td id="boleto_teste" class="boleto" colspan=6 style="border-right:0px;padding-right:80px;">
										<fieldset style="border:0">
											<legend>Autenticação Mecânica</legend>
											<script>
												var number = '<?php echo $_REQUEST['codbarras'];?>';
												new Boleto(number).toSVG('#boleto_teste');
											</script><br>
										</fieldset>
									</td>
									<td class="boleto" style="border-right:0px;">
										&nbsp;
									</td>
								</tr>
							</table>
							</table>
						<br>
					</center>
					</div>
					<div id="editor"></div>
				</td>
			</tr>
			<tr>
				
			<tr bgcolor="#0032AB">
				<td colspan=2><font face="Verdana" color="#0032AB" size="1">&nbsp;</font></td>
			</tr>
			<tr bgcolor="#FFF">
				<td colspan=2><font face="Verdana" color="#0032AB" size="1">&nbsp;</font></td>
			</tr>
			<tr bgcolor="#F9DC12">
				<td align="center" colspan=2>
					<font face="Verdana" color="#0032AB" size="2">
						
					</font>
				</td>
			</tr>
		</table>
	</body>
</html>

