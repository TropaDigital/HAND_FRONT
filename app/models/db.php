<?php
include_once 'library/Zend/Db/Table/Row/Abstract.php';

abstract class db extends Zend_Db_Adapter_Abstract
{}

/* LOGINS */
class login extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_login';
	protected $_primary = 'id_login';
}
class acessos_login extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_acessos_login';
	protected $_primary = 'id_acessos_login';
}
/* FIM LOGIN */

class usuarios extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_usuarios';
	protected $_primary = 'id_usuario';
}

class landing_page extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_landing_page';
	protected $_primary = 'id_landing_page';
}
class templates_cores extends Zend_Db_Table_Abstract
{
    protected $_name = 'zz_templates_cores';
    protected $_primary = 'id_template_cor';
}
class templates extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_templates';
	protected $_primary = 'id_template';
}
class categorias extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_categorias';
	protected $_primary = 'id_categoria';
}
class usuarios_categorias extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_usuarios_categorias';
	protected $_primary = 'id_usuario_categoria';
}

class contato extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_contato';
	protected $_primary = 'id_contato';
}
class campanhas extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_campanhas';
	protected $_primary = 'id_campanha';
}
class campanhas_envio extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_campanhas_envio';
	protected $_primary = 'id_envio';
}
class campanhas_envio_lote extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_campanhas_envio_lote';
	protected $_primary = 'id_lote';
}
class paginas_landing extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_paginas_landing';
	protected $_primary = 'id_pagina';
}
class usuarios_planos extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_usuarios_planos';
	protected $_primary = 'id_usuario_plano';
}
class templates_paginas extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_templates_paginas';
	protected $_primary = 'id_pagina';
}
class planos extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_planos';
	protected $_primary = 'id_plano';
}

class uploads extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_uploads';
	protected $_primary = 'id_upload';
}
class notificacoes extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_notificacoes';
	protected $_primary = 'id_notificacao';
}
class callback extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_callback_sms';
	protected $_primary = 'id_callback';
}
class campanhas_visu extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_campanhas_visu';
	protected $_primary = 'id_visualizacao';
}
class notificacoes_lido extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_notificacoes_lido';
	protected $_primary = 'id_notificacao_lido';
}

class login_gerenciador extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_login_gerenciador';
	protected $_primary = 'login';
}
class usuarios_gerenciador extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_usuarios_gerenciador';
	protected $_primary = 'id_usuario';
}
class planos_gerenciador extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_planos_gerenciador';
	protected $_primary = 'id_plano';
}
class sms_configuracoes extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_sms_configuracoes';
	protected $_primary = 'id_configuracao';
}
class login_sistema extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_login_sistema';
	protected $_primary = 'login';
}
class usuarios_sistema extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_usuarios_sistema';
	protected $_primary = 'id_usuario';
}
class vendedores extends Zend_Db_Table_Abstract
{
    protected $_name = 'zz_vendedores';
    protected $_primary = 'id_vendedor';
}
class permissoes extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_permissoes';
	protected $_primary = 'id_permissao';
}
class usuarios_permissoes extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_usuarios_permissoes';
	protected $_primary = 'id_permissao_usuario';
}
class usuarios_templates extends Zend_Db_Table_Abstract
{
	protected $_name = 'zz_usuarios_templates';
	protected $_primary = 'id_usuario_template';
}
class usuarios_creditos extends Zend_Db_Table_Abstract
{
    protected $_name = 'zz_usuarios_creditos';
    protected $_primary = 'id_credito';
}
class usuarios_creditos_bloqueados extends Zend_Db_Table_Abstract
{
    protected $_name = 'zz_usuarios_creditos_bloqueados';
    protected $_primary = 'id_credito_bloqueado';
}
class categorias_gerenciador extends Zend_Db_Table_Abstract
{
    protected $_name = 'zz_categorias_gerenciador';
    protected $_primary = 'id_categoria';
}
class templates_comprados extends Zend_Db_Table_Abstract
{
    protected $_name = 'zz_templates_comprados';
    protected $_primary = 'id_template_comprado';
}