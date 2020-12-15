<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class TemplatesController extends My_Controller
{

    public function ini()
    {

        //echo $_SERVER['REMOTE_ADDR']; exit;
        $params = $this->_request->getParams();
        $this->id = $params['id'];
        $this->salva = $params['salva'];
        $this->view->id = $this->id;
        $this->view->id_pagina = $this->id_pagina = $params['id_pagina'];
        $this->view->infos = $this->infos = $params['infos'];

        if ($this->view->baseAction == 'campanhas' && !$this->me){

            $this->_redirect('/login');
            exit();

        }

    }

    public function criacaoAction(){

        $this->view->cssPag = '
				<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/campanha-criacao.css?v=2">
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/criacao-itens.css?v=2">';
        $this->view->jsPag = '
				<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
				<script src="assets/'.$this->view->baseModule.'/js/criacao.js?v=2" type="text/javascript"></script>';

        //
        $this->view->tituloPag= 'Criação de templates';

        $post = $this->_request->getPost();
        $params = $this->_request->getParams();

        $this->view->id_pagina = $this->id_pagina = $params['id_pagina'];

        // SELECT
        $uploads = new uploads();
        $this->view->uploads = $uploads->fetchAll('id_usuario = '.$this->me->id_usuario.' AND status != "inativo"');

        $this->view->cores = $this->coresTemplateGeral();

        $uploads = new uploads();
        $this->view->uploads_lixeira = $uploads->fetchAll('id_usuario = '.$this->me->id_usuario.' AND status = "inativo"');

        $landing = new landing_page();
        $this->view->landing = $landing->fetchAll('id_landing_page = '.$this->id.' AND id_usuario IN ('.implode(',', $this->me->familia).')');

        $total_paginas = new paginas_landing();
        $this->view->total_paginas = $total_paginas->fetchAll('id_landing_page = '.$this->id.'');

        if ($this->id_pagina){

            $paginas_landing = new paginas_landing();
            $this->view->paginas_landing = $paginas_landing->fetchAll('id_landing_page = '.$this->id.' AND ordem = '.$this->id_pagina.'');

            if ( count( $this->view->paginas_landing ) == 0 ) {

                // 			    echo '<pre>'; print_r( $_SERVER['HTTP_REFERER'] ); exit;

                $pagePrev = $_SERVER['HTTP_REFERER'];
                $pagePrev = explode( '/id_pagina/', $pagePrev );
                $pagePrev = $pagePrev[1];

                if ( $this->view->id_pagina > $pagePrev ) {

                    $nextpage = $this->view->id_pagina + 1;

                } else {

                    $nextpage = $this->view->id_pagina - 1;

                }

                // 			    echo $nextpage; exit;

                // 			    echo '<pre>'; print_r( $pagePrev ); exit;
                $this->_redirect( $this->view->baseModule.'/'.$this->view->baseController.'/'.$this->view->baseAction.'/id/'.$params['id'].'/id_pagina/'.$nextpage );

            }

        }

    }

    protected function coresTemplateGeral()
    {

        $cores = array();

        array_push($cores, array(
                'nome'=>'transparente',
                'cor'=>'transparent',
                'font'=>'#333'
            )
        );

        array_push($cores, array(
                'nome'=>'vermelho',
                'cor'=>'b81c1c',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'verde-abacate',
                'cor'=>'dbe93a',
                'font'=>'656565'
            )
        );

        array_push($cores, array(
                'nome'=>'marrom',
                'cor'=>'815e39',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'rosa',
                'cor'=>'ee92f9',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'branco',
                'cor'=>'FFF',
                'font'=>'787878'
            )
        );

        array_push($cores, array(
                'nome'=>'laranja',
                'cor'=>'e48f35',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'preto',
                'cor'=>'000',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'amarelo',
                'cor'=>'e6c335',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'roxo',
                'cor'=>'6a2ca9',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'azul',
                'cor'=>'2aa5f3',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'verde',
                'cor'=>'467b31',
                'font'=>'FFF'
            )
        );

        array_push($cores, array(
                'nome'=>'cinxa-claro',
                'cor'=>'dcdcdc',
                'font'=>'787878'
            )
        );

        array_push($cores, array(
                'nome'=>'cinxa-escuro',
                'cor'=>'787878',
                'font'=>'FFF'
            )
        );

        $id_usuario = $this->me->id_usuario;

        if ( $this->_request->getParams()['shorturl'] ){

            $get = $this->_request->getParams();
            $shorturl = $this->postgre('template','shorturl', $get);

            $id_usuario = $shorturl->id_usuario;

        } else if ( $this->_request->getParams()['id'] ){

            $lp = new landing_page();
            $lpfetch = $lp->fetchAll('id_landing_page = '.$this->_request->getParams()['id']);

            $id_usuario = $lpfetch[0]->id_usuario;

        } else {

            $id_usuario = $this->me->id_usuario;

        }

        $coresDb = new templates_cores();
        $coresSql = $coresDb->fetchAll('id_usuario = '.$id_usuario.'');

        foreach ( $coresSql as $row ){

            array_push($cores,
                array(
                    'nome'=>$row['nome'],
                    'cor'=>str_replace('#', '', $row['bg']),
                    'font'=>str_replace('#', '', $row['cor']),
                    'user'=>true
                )
            );

        }

        return $cores;

    }

    public function coresJsonAction()
    {

        echo json_encode($this->coresTemplateGeral()); exit;

    }

    public function coresTemplateAction()
    {

        $this->view->cores = $this->coresTemplateGeral();

    }

    public function newColorAction()
    {

        $post = $this->_request->getPost();

        $this->sql = new Model_Data(new templates_cores());
        $this->sql->_required(array('id_usuario','nome','bg','cor','criado'));
        $this->sql->_notNull(array('bg','cor'));

        $post['id_usuario'] = $this->me->id_usuario;
        $post['cor'] = $post['color'];
        $post['nome'] = uniqid().time();

        $edt = $this->sql->edit( NULL, $post, NULL, Model_Data::NOVO );

        echo json_encode( $post ); exit;

    }

    public function removeColorAction()
    {

        $post = $this->_request->getPost();

        $this->data = new Model_Data(new templates_cores());
        $del = $this->data->_table()->getAdapter()->query('DELETE FROM zz_templates_cores WHERE nome = "'.$post['nome'].'" AND id_usuario = "'.$this->me->id_usuario.'"');

        print_r($del); exit;

    }

    public function boletoAction()
    {


    }

    public function novaLandingAction()
    {

        $this->view->tituloPag = 'Templates';

        $this->view->cssPag = '<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/nova-landing.css">';

        $landing_page = new Zend_Db_Select($this->db);
        $landing_page->from(array('CAT'=>$this->config->tb->categorias),array('*'))

            ->joinLeft(array('PERMISSAO'=>$this->config->tb->usuarios_categorias),
                'PERMISSAO.id_categoria = CAT.id_categoria',array('*'))

            ->where('CAT.status = 1')
            ->where('PERMISSAO.id_usuario = '.$this->me->id_gerenciado)
            ->order('CAT.categoria ASC')
            ->group('CAT.id_categoria');

        $landing_page = $landing_page->query(Zend_Db::FETCH_OBJ);
        $categoriasFetch = $landing_page->fetchAll();

        $categorias_gerenciador = new categorias_gerenciador();
        $categorias_gerenciadorFetch = $categorias_gerenciador->fetchAll("id_gerenciador = ".$this->me->id_gerenciado)->toArray();

        $categorias = array();

        foreach ( $categoriasFetch as $row ) { $categorias[] = (object)$row; }
        foreach ( $categorias_gerenciadorFetch as $row ) { $categorias[] = (object)$row; }

        $sortArray = array();

        foreach($categorias as $person){
            foreach($person as $key=>$value){
                if(!isset($sortArray[$key])){
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        }

        $orderby = "categoria";
        array_multisort($sortArray[$orderby],SORT_ASC,$categorias);

        $this->view->categorias = $categorias;

    }

    public function meusTemplatesAction ()
    {

        $params = $this->_request->getParams();

        $this->view->tituloPag = 'Meus Templates';

        $this->land = new Model_Data(new landing_page());
        $this->land->_required(array('id_campanha', 'status'));
        $this->land->_notNull(array('status'));

        $this->view->cssPag = '
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/nova-landing.css">
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/calendario.css">';

        if ( !$params['id_usuario'] ) {
            $params['id_usuario'] = array('0'=>'0');
        }

        // FILTRO POR USUARIOS
        if ( !array_diff ( $params['id_usuario'], $this->me->familia ) ){
            $id_usuario = implode(',', $params['id_usuario']);
        } else {
            $id_usuario = implode(',', $this->me->familia);
        }

        if ($params['del'] && $params['id']){

            $landing_page = new landing_page();
            $this->view->result = $landing_page->fetchAll('id_usuario IN ('.$id_usuario.') AND id_landing_page = '.$params[id].'');

            if(count($this->view->result) > 0){

                $post['status'] = 'excluido';
                $edt = $this->land->edit($params[id],$post,NULL,Model_Data::ATUALIZA);

                if ($edt){
                    echo 'true';
                } else {
                    echo 'false';
                }

                exit();

            }

        }

        if ($params['restore'] && $params['id']){

            $landing_page = new landing_page();
            $this->view->result = $landing_page->fetchAll('id_usuario IN ('.$id_usuario.') AND id_landing_page = '.$params[id].'');

            if(count($this->view->result) > 0){

                $data = array();
                $data['status'] = 'ativo';

                $edt = $this->land->edit($params[id],$data,NULL,Model_Data::ATUALIZA);

                if ($edt){
                    echo 'true';
                } else {
                    echo 'false';
                }

                exit();

            }

        }

        if ($params['data_i'] != ''){
            $busca_i = 'AND LANDING.criado > \''.$params['data_i'].'\'';
            $this->view->d_i = $params['data_i'];
        }

        if ($params['data_f'] != ''){
            $busca_f = 'AND LANDING.criado < \''.$params['data_f'].'\'';
            $this->view->d_f = $params['data_f'];
        }

        if ($params['nome'] != ''){
            $busca_nome = 'AND LANDING.nome LIKE \'%'.$params[nome].'%\'';
        }

        if ($params['categoria'] == 'lixeira'){
            $lixeira = 'AND LANDING.status = \'excluido\'';
        } else {
            $lixeira = 'AND LANDING.status NOT IN (\'excluido\',\'template\')';
        }

        $landing_page = new Zend_Db_Select($this->db);
        $landing_page->from(array('LANDING'=>$this->config->tb->landing_page),array('*'))

            ->order('LANDING.criado DESC')
            ->where('LANDING.id_usuario IN ('.$id_usuario.') '.$busca_i.' '.$busca_f.' '.$busca_nome.' '.$lixeira);

        $landing_page->joinLeft(array('U'=>$this->config->tb->usuarios),
            'LANDING.id_usuario = U.id_usuario',array('name_user AS nome_user'));

        $landing_page = $landing_page->query(Zend_Db::FETCH_OBJ);
        $this->view->landing_page = $landing_page->fetchAll();


    }

    public function categoriaAction ()
    {

        $params = $this->_request->getParams();

        $this->view->cssPag = '
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/nova-landing.css">
				<link rel="stylesheet" href="assets/'.$this->view->baseModule.'/js/owl-carousel/owl.carousel.css">';
        $this->view->jsPag = '<script src="assets/'.$this->view->baseModule.'/js/owl-carousel/owl.carousel.js"></script>';

        // PEGA TODAS CATEGORIAS
        if ( $params['id'] ) {

            $categorias = new categorias();
            $this->view->categoria = $categorias->fetchAll('status = 1 AND id_categoria = ' . $params['id'] . '', 'id_categoria ASC');

            $templates = new templates();
            $this->view->templates = $templates->fetchAll('status = 1 AND id_categoria = '.$params['id']);

        } else {

            $categorias = new categorias_gerenciador();
            $this->view->categoria = $categorias->fetchAll('status = 1 AND id_categoria = ' . $params['id_template'] . '', 'id_categoria ASC');

            $templates = new templates();
            $this->view->templates = $templates->fetchAll('status = 1 AND id_categoria_gerenciador = '.$params['id_template'].' ');

        }

        $this->view->tituloPag = 'Templates - '.$this->view->categoria[0]->categoria;

    }

    public function comprarTemplateAction()
    {

        $get = $this->_request->getParams();

        $templates = new templates();
        $templateFetch = $templates->fetchAll('id_template = '.$get['id'])->toArray();
        $templateFetch = current($templateFetch);
        $templateFetch['id_usuario'] = $this->me->id_usuario;
        $templateFetch['id_gerenciado'] = $this->me->id_gerenciado;

        $result = array();

        try {

            if ( $templateFetch->valor > $this->view->sms_disponivel ) {
                throw new \Exception('Você não possui créditos suficiente para comprar esse template.');
            }

            $this->templates_comprados = new Model_Data(new templates_comprados());
            $this->templates_comprados->_required(array('id_template', 'id_usuario', 'id_gerenciado', 'valor', 'id_landing_page', 'modificado', 'criado'));
            $this->templates_comprados->_notNull(array('id_template'));

            $comprado = $this->templates_comprados->edit(NULL, $templateFetch,NULL,Model_Data::NOVO);

            $result['error'] = false;

        } catch ( \Exception $e ){

            $result['error'] = true;
            $result['message'] = $e->getMessage();

        }

        echo json_encode( $result ); exit;

    }

    public function criarTemplateAction ()
    {

        $params = $this->_request->getParams();
        $this->id = $params['id'];
        $this->view->id = $this->id;

        $template = new templates();
        $this->view->template = $template->fetchAll('id_template = '.$this->id.'');

        $landing_page = new Zend_Db_Select($this->db);
        $landing_page->from(array('TEMPLATES'=>$this->config->tb->templates),array('*'))

            ->joinLeft(array('LANDING'=>$this->config->tb->landing_page),
                'LANDING.id_landing_page = TEMPLATES.id_landing_page',array('html_pagina','html_final'))

            ->where('TEMPLATES.id_template = '.$this->view->id)
            ->group('LANDING.id_landing_page');

        $landing_page = $landing_page->query(Zend_Db::FETCH_OBJ);
        $this->view->template = $landing_page->fetchAll();

        $shorturl = new landing_page();
        $this->view->url_enviado = $shorturl->fetchAll('id_landing_page = '.$this->id.'');

        $input = time();
        $output = $this->shorturl($input);

        if (count($this->view->url_enviado) > 0){
            foreach($this->view->url_enviado as $ver){
                if($ver->shorturl != $output[0]){
                    $url = $output[0];
                } elseif ($ver->shorturl != $output[1]){
                    $url = $output[1];
                }  elseif ($ver->shorturl != $output[2]){
                    $url = $output[2];
                }  elseif ($ver->shorturl != $output[3]){
                    $url = $output[3];
                }
            }
        } else {
            $url = $output[0];
        }

        $post['shorturl'] = $url;
        $post['id_usuario'] = $this->me->id_usuario;
        $post['status'] = 'ativo';
        $post['id_template'] = $this->id;
        $post['nome'] = $this->view->template[0]->template;
        $post['html_pagina'] = $this->view->template[0]->html_pagina;
        $post['html_final'] = $this->view->template[0]->html_final;

        $this->data = new Model_Data(new landing_page());
        $this->data->_required(array('id_landing_page', 'id_usuario', 'nome', 'status', 'html_pagina', 'html_final', 'modificado', 'criado'));
        $this->data->_notNull(array());

        $this->pages = new Model_Data(new paginas_landing());
        $this->pages->_required(array('id_pagina', 'ordem', 'tag', 'nome', 'html', 'slug', 'id_landing_page', 'modificado', 'criado'));
        $this->pages->_notNull(array('id_landing_page'));

        $edt = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);

        $paginas_templates = new templates_paginas();
        $this->view->paginas_templates = $paginas_templates->fetchAll('id_template = '.$post[id_template].'');
        if(count($this->view->paginas_templates) > 0){

            $page = array();

            foreach($this->view->paginas_templates as $row){
                $page['tag'] = $row->tag;
                $page['ordem'] = $row->ordem;
                $page['nome'] = $row->nome;
                $page['html'] = $row->html;
                $page['slug'] = $row->slug;
                $page['ordem'] = $row->ordem;
                $page['id_landing_page'] = $edt;
                $pages = $this->pages->edit(NULL,$page,NULL,Model_Data::NOVO);
            }

        }

        if ($edt){
            echo $edt;
            exit();
        } else {
            echo 'false';
            exit();
        }

    }

    public function duplicarAction ()
    {

        $params = $this->_request->getParams();
        $this->view->id = $params['id'];
        $this->id = $this->view->id;


        $shorturl = new landing_page();
        $this->view->landing = $shorturl->fetchAll('id_landing_page = '.$this->id.'', 'id_landing_page ASC');

        $post['id_usuario'] = $this->me->id_usuario;
        $post['status'] = 'inativo';
        $post['nome'] = 'Cópia '.$this->view->landing[0]->nome;
        $post['html_pagina'] = $this->view->landing[0]->html_pagina;
        $post['html_final'] = $this->view->landing[0]->html_final;

        $this->data = new Model_Data(new landing_page());
        $this->data->_required(array('id_landing_page', 'id_usuario', 'nome', 'status', 'html_pagina', 'html_final', 'modificado', 'criado'));
        $this->data->_notNull(array('html_pagina'));

        $this->pages = new Model_Data(new paginas_landing());
        $this->pages->_required(array('id_pagina', 'nome', 'html', 'ordem', 'tag', 'slug', 'id_landing_page', 'modificado', 'criado'));
        $this->pages->_notNull(array('id_landing_page'));

        $edt = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);

        if ($this->view->landing[0]->id_landing_page){
            $paginas_templates = new paginas_landing();
            $this->view->paginas_templates = $paginas_templates->fetchAll('id_landing_page = '.$this->view->landing[0]->id_landing_page.'');
        }

        if(count($this->view->paginas_templates) > 0){

            $page = array();

            foreach($this->view->paginas_templates as $row){
                $page['nome'] = $row->nome;
                $page['tag'] = $row->tag;
                $page['html'] = $row->html;
                $page['slug'] = $row->slug;
                $page['ordem'] = $row->ordem;
                $page['id_landing_page'] = $edt;

                $pages = $this->pages->edit(NULL,$page,NULL,Model_Data::NOVO);
            }

        }

        if ($edt){
            echo $edt;
            exit();
        } else {
            echo 'false';
            exit();
        }

    }

    public function modelosAction()
    {

        function limita($str, $quantidade){
            $total = strlen($str);
            $str = substr($str, 0, $quantidade);
            return ($total > $quantidade ? $str."..." : $str);
        }

        $params = $this->_request->getParams();

        $this->land = new Model_Data(new landing_page());
        $this->land->_required(array('id_campanha', 'status'));
        $this->land->_notNull(array('status'));

        if ($params['del'] && $params['id']){

            $landing_page = new landing_page();
            $this->view->result = $landing_page->fetchAll('id_usuario = '.$this->me->id_usuario.' AND id_landing_page = '.$params[id].'');

            if(count($this->view->result) > 0){

                $post['status'] = 'excluido';
                $edt = $this->land->edit($params[id],$post,NULL,Model_Data::ATUALIZA);

                if ($edt){
                    echo 'true';
                } else {
                    echo 'false';
                }

                exit();

            }

        }

        if ($params['restore'] && $params['id']){

            $landing_page = new landing_page();
            $this->view->result = $landing_page->fetchAll('id_usuario = '.$this->me->id_usuario.' AND id_landing_page = '.$params[id].'');

            if(count($this->view->result) > 0){

                $data = array();
                $data['status'] = 'ativo';

                $edt = $this->land->edit($params[id],$data,NULL,Model_Data::ATUALIZA);

                if ($edt){
                    echo 'true';
                } else {
                    echo 'false';
                }

                exit();

            }

        }

        $this->view->cssPag = '
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/campanhas.css">
				<link rel="stylesheet" type="text/css" href="assets/'.$this->view->baseModule.'/css/calendario.css">';

        if ($params['data_i'] != ''){
            $busca_i = 'AND LANDING.criado > \''.$params['data_i'].'\'';
        } else {
            $busca_i = 'AND LANDING.criado > \''.date('Y').'-'.date('m').'-01\'';
        }

        if ($params['data_f'] != ''){
            $busca_f = 'AND LANDING.criado < \''.$params['data_f'].'\'';
        } else {
            $busca_f = 'AND LANDING.criado < \''.date('Y').'-'.date('m').'-31\'';
        }

        if ($params['nome'] != ''){
            $busca_nome = 'AND LANDING.nome LIKE \'%'.$params[nome].'%\'';
        }

        if ($params['categoria'] == 'lixeira'){
            $lixeira = 'AND LANDING.status = \'excluido\'';
        } else {
            $lixeira = 'AND LANDING.status != \'excluido\'';
        }

        $landing_page = new Zend_Db_Select($this->db);
        $landing_page->from(array('LANDING'=>$this->config->tb->landing_page),array('*'))

            ->joinLeft(array('TEMPLATES'=>$this->config->tb->templates),
                'LANDING.id_landing_page = TEMPLATES.id_landing_page',array('id_template AS idTemplate','template'))

            ->order('LANDING.criado DESC')
            ->where('LANDING.id_usuario = '.$this->me->id_usuario.' AND LANDING.status NOT IN (\'excluido\',\'template\') '.$busca_i.' '.$busca_f.' '.$busca_nome.' '.$lixeira)
            ->group('LANDING.id_landing_page');

        $landing_page = $landing_page->query(Zend_Db::FETCH_OBJ);
        $this->view->landing_page = $landing_page->fetchAll();

    }

    public function favoritarTemplateAction()
    {
        $post = $this->_request->getPost();

        $this->data = new Model_Data(new landing_page());
        $this->data->_required(array('id_landing_page', 'favorito'));
        $this->data->_notNull(array('favorito'));

        $post['id_landing_page'] = $post['id'];
        $post['favorito'] = $post['fav'];

        $edt = $this->data->edit($post[id_landing_page],$post,NULL,Model_Data::ATUALIZA);

        if ($edt){
            echo 'true';
            exit();
        } else {
            echo 'false';
            exit();
        }

    }

    public function paginasLandingAction()
    {

        $post = $this->_request->getPost();
        $total_paginas = new paginas_landing();
        $this->view->pagina = $total_paginas->fetchAll('id_landing_page = '.$post['id'].'','ordem ASC');
        $paginas = array();

        foreach($this->view->pagina as $row){

            array_push($paginas, array(
                    'id_pagina'=>$row->id_pagina,
                    'nome'=>$row->nome,
                    'ordem'=>$row->ordem
                )
            );

        }

        echo json_encode($paginas); exit;

    }

    public function clickAction()
    {

        $post = $this->_request->getPost();

        if ( $_SERVER['REMOTE_ADDR'] != '169.57.169.42' ) {
            $shorturl = $this->insertPostgre('template', 'click', $post);
        }
        print_r($shorturl);
        exit;

    }

    protected function msg($mensagem, $row)
    {

        $row = (array) current( $row );

        // MENSAGEM]
        $msg = $mensagem;

        $msg = preg_replace('/\[(.*?)\]/i', '['.strtolower('\\1').']', $msg);

        $campos = array();
        $campos['nome'] 				= '[nome]';
        $campos['sobrenome'] 			= '[sobrenome]';
        $campos['celular'] 				= '[celular]';
        $campos['celular'] 				= '[celular]';
        $campos['data_nascimento'] 		= '[data_nascimento]';
        $campos['email'] 				= '[email]';
        $campos['campo1'] 				= '[cpf]';
        $campos['campo2'] 				= '[empresa]';
        $campos['campo3'] 				= '[cargo]';
        $campos['campo4'] 				= '[telefone_comercial]';
        $campos['campo5'] 				= '[telefone_residencial]';
        $campos['campo6'] 				= '[pais]';
        $campos['campo7'] 				= '[estado]';
        $campos['campo8']		 		= '[cidade]';
        $campos['campo9']		 		= '[bairro]';
        $campos['campo10']		 		= '[endereço]';
        $campos['campo11']		 		= '[cep]';

        for ($i = 1; $i <= 40; $i++) {

            $campos['editavel_'.$i] = '[editavel_'.$i.']';

        }

        foreach ( $campos as $key => $campo )
        {

            $msg = str_replace($campo, $row[$key], $msg);
            $msg = str_replace( strtoupper( $campo ), $row[$key], $msg);

        }

        if ( $_GET['admin'] == 'true' ) {

            echo '<pre>';
            print_r( $row );
            exit;

        }

        return $msg;

    }

    public function detalheAction()
    {

        if ( $_GET['id_pagina'] ){
            $this->id_pagina = $_GET['id_pagina'];
        }

        $get = $this->_request->getParams();

        if ( !empty( $get['short'] ) ):

            $get['shorturl'] = $get['short'];

        endif;

        $this->view->cores = $this->coresTemplateGeral();

 		//die('chegou aqui');

        // VERIFICA SE ESTÁ EM UMA CAMPANHA
        if ($get['shorturl']){

            //die('campanha?');

            $_SESSION['shorturl'] = $get['shorturl'];

            $this->view->shorturl = $get['shorturl'];

            $shorturl = $this->postgre('template','shorturl', $get);
            $this->view->id = $this->id = $shorturl->id_landing_page;
            $this->view->celularUser = $shorturl->celular;

            $landing = new landing_page();
            $this->view->landing = $landing->fetchAll("id_landing_page = '".$this->id."'");

            $envioCampanha = new Zend_Db_Select($this->db);
            $envioCampanha->from(array('LANDING'=>$this->config->tb->landing_page),array('*'))

                ->joinLeft(array('USUARIO'=>$this->config->tb->login),
                    'LANDING.id_usuario = USUARIO.id_usuario',array('id_gerenciado'))

                ->joinLeft(array('GERENCIADOR'=>$this->config->tb->usuarios_gerenciador),
                    'GERENCIADOR.id_usuario = USUARIO.id_gerenciado',array('slug'))

                ->where("id_landing_page = '".$this->id."'");

            $envioCampanha = $envioCampanha->query(Zend_Db::FETCH_OBJ);
            $this->view->landing = $envioCampanha->fetchAll();

            $this->view->slug = $this->view->landing[0]->slug;

            // DADOS DO CONTATO

            $post['id_contato'] = $shorturl->id_contato;
            $this->view->user = json_decode($this->insertPostgre('template','contato',$post));

            if ( $_SERVER['REMOTE_ADDR'] && $_SERVER['REMOTE_ADDR'] != '169.57.169.42' ) {
                $newVisu = $this->insertPostgre('template', 'visualizacao', $shorturl);
            }

            $campanhas = new campanhas();
            $this->view->campanhas = $campanhas->fetchAll('id_campanha = "'.$shorturl->id_campanha.'"');

            $status = $this->view->campanhas[0]->periodo_final;

            $this->view->bloqueio = json_decode($this->view->campanhas[0]->bloqueio);
            $this->view->senha_tipo = str_replace('[', '',$this->view->bloqueio->senha);
            $this->view->senha_tipo = str_replace(']', '',$this->view->senha_tipo);


            // CASO EXISTA BLOQUEIO
            if ($this->view->bloqueio->bloqueio == 's'):

                // ELE VERIFICA SE EXISTE SESSÃO, SE NÃO CRIA UMA VARIAVEL MANDANDO PEDIR SENHA
                if (!isset($_SESSION[$get['shorturl']])):
                    $this->view->bloqueio->bloquear = 's';
                else:
                    $this->view->bloqueio->bloquear = 'n';
                endif;

                if ($this->view->bloqueio->tipo == 'v'):
                    $this->view->bloqueio->senha = $this->msg($this->view->bloqueio->senha, $this->view->user);
                endif;

                $this->view->bloqueio->titulo_block = $this->msg($this->view->bloqueio->titulo_block, $this->view->user);

            endif;

            // TITULO DA PÁGINA
            $this->view->tituloPag = $this->view->campanhas[0]->campanha;

        } else {

            // TITULO DA PÁGINA
            $this->view->tituloPag = 'Previsualização - Template';
            $status = '9999-99-99';

        }

        $this->view->status = $status;

        // SELECT DA LANDING PAGE
        $landing = new Zend_Db_Select($this->db);
        $landing->from(array('LANDING'=>$this->config->tb->landing_page),array('*'))

            ->where('LANDING.id_landing_page = '.$this->id.'')
            ->group('LANDING.id_landing_page');

        $landing = $landing->query(Zend_Db::FETCH_OBJ);
        $this->view->landing = $landing->fetchAll();

        $this->view->analytics = $this->view->landing[0]->analytics;

        if ($this->id_pagina){
            $paginas_landing = new paginas_landing();
            $this->view->paginas_landing = $paginas_landing->fetchAll('id_landing_page = '.$this->id.' AND id_pagina = '.$this->id_pagina.'');
        }

        if (!$_GET['pag']){
            if ($this->id_pagina){
                $this->view->tituloPagInterna = $this->view->paginas_landing[0]->nome;
                $this->view->template = $this->template = $this->view->paginas_landing[0]->html;
            } else {
                $this->view->template = $this->template = $this->view->landing[0]->html_pagina;
            }
        } else {
            $this->view->template = $this->template = $this->view->landing[0]->html_final;
        }

        if ($get['shorturl']){
            $this->view->template = $this->msg($this->view->template, $this->view->user);
        }

        if ($get['prev'] == 'true'):

            if (!$get['pag']):
                $this->view->template = $this->view->landing[0]->html_preview;
            else:
                $this->view->template = $this->view->landing[0]->html_final_preview;
            endif;

        endif;

        // FORMULARIO
        $post = $this->_request->getPost();


        if (!empty($post) && $_SESSION['time'] < time()){

            $_SESSION['time_form'] = time() + 10;

            if ( $this->view->slug ) {

                if ( $post['resposta_unica'] == 'true' ) {

                    $url_resp_unica = $this->view->backend.'api/relatorios/get-form?celular='.$shorturl->celular.'&id_campanha='.$shorturl->id_campanha.'&id_usuario='.$shorturl->id_usuario;
                    $valida_respota_unica = json_decode ( file_get_contents( $url_resp_unica ) );

                    if ( $valida_respota_unica->total_registros > 0 )
                    {

                        $var_encode = utf8_decode('Você ja respondeu esse formulário, só aceitamos respostas unicas.');
                        echo "<script>window.history.back(); alert('".$var_encode."')</script> "; exit;

                    }

                }

            }

            unset( $post['resposta_unica'] );

            $name = array();
            foreach($post['name'] as $key => $row){
                $name[$key] = $row;
            }

            $campos = array();
            $i=0;
            foreach($post as $key => $row){

                if ($i != 0){
                    if ( $key != 'id' && $key != 'id_campanha' && $key != 'id_form' && $key != 'celular'){
                        $campos[$key] = $row;
                    }
                }
                $i++;
            }

            $result = array();

            foreach($campos as $key => $row){

                if ($i != 0){

                    array_push($result, array($name[$key]=>$row));

                }

            }

            if ( $_GET['admin'] ) {
                echo '<pre>';print_r( $result ) ; exit;
            }

// 			echo '<pre>'; print_r( $result ); exit;

            $post['id_campanha'] = $shorturl->id_campanha;
            $post['celular'] = $shorturl->celular;
            $post['campos'] = json_encode($result);
            $post['id_usuario'] = $shorturl->id_usuario;

            //echo '<pre>'; print_r( $post ); exit;
            $new = $this->insertPostgre('template','formulario',$post);

            $pag_final = $_POST['pagina_final'];
            $pag_final = $pag_final == NULL ? 'pag=final' : $pag_final;

            if ($new != 'false'){

                $shortExiste = explode('short', $_SERVER['REQUEST_URI']);
                $prevExiste = explode('prev', $_SERVER['REQUEST_URI']);

                if (count($shortExiste) > 1 || count($prevExiste) > 1):
                    $this->redirect($_SERVER['REQUEST_URI'].'&'.$pag_final);
                else:
                    $this->redirect($_SERVER['REQUEST_URI'].'?'.$pag_final);
                endif;

            }

        }

    }

    public function submitSenhaAction()
    {

        $post = $this->_request->getPost();

        if (!empty($post['senha_correct'])){

            if ($post['senha_correct'] == $post['mysenha']):

                $_SESSION[$post['shorturl']] = 'logged';

            else:

                $this->_messages->addMessage(array('success'=>'Incorreto.'));

            endif;

        }

        $this->_redirect($post['url']);

    }

    public function uploadAction()
    {

        $file 		= $_FILES['uploadfile'];
        $path 		= '';
        @$options 	= array(	'path' 		=> '',
            'where' 	=> NULL,
            'sizeW' 	=> 1200,
            'type' 		=> 'image',
            'root' 		=> $this->pathUpload.'imagens/templates_geral/id/'.$this->me->id_usuario.'/' );
        @$upload =  new App_File_Upload($file, $path, $options);

        $this->data = new Model_Data(new uploads());
        $this->data->_required(array('id_upload', 'link', 'id_landing_page', 'id_usuario','status','data'));
        $this->data->_notNull(array('link', 'id_landing_page', 'id_usuario'));

        $post['status'] = 'ativo';
        $post['link'] = '/assets/uploads/imagens/templates_geral/id/'.$this->me->id_usuario.'/'.$upload->_where();
        $post['id_landing_page'] = $this->id;
        $post['id_usuario'] = $this->me->id_usuario;
        $post['data'] = date('Y-m-d');


        if ($upload->_messages() == 'Image saved'):
            $edt = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
            $post['id_upload'] = $edt;
        else :
            $array = array('link'=>'false','criado'=>'false','msg'=>$upload->_messages());
            echo json_encode($array);
            exit;
        endif;


        if ($edt && $upload) {
            $array = array('id_upload'=>$post['id_upload'],'link'=>$post['link'],'criado'=>$post['data'],'caminho'=>$this->pathUpload.'imagens/templates_geral/', 'file'=>$file, 'upload'=>$upload->_messages());
            echo json_encode($array);
            exit;
        } else {
            $array = array('link'=>'false','criado'=>'false');
            echo json_encode($array);
            exit;
        }

    }

    public function statusImagemAction()
    {

        $post = $this->_request->getPost();

        $this->data = new Model_Data(new uploads());
        $this->data->_required(array('status'));
        $this->data->_notNull(array());

        $upload = new uploads();
        $fetch = $upload->fetchAll('id_upload = "'.$post['id_upload'].'" AND id_usuario = '.$this->me->id_usuario);

        if (count($fetch) > 0):

            $edt = $this->data->edit($post['id_upload'],$post,NULL,Model_Data::ATUALIZA);

            print_r($post);

        else:

            echo '3';

        endif;

        exit;

    }

    public function excluirImagemAction()
    {

        $post = $this->_request->getPost();

        unlink(substr($post['img'], 1));

        $this->data = new Model_Data(new uploads());
        $this->data->_required(array('id_upload', 'link', 'id_landing_page', 'id_usuario','data'));
        $this->data->_notNull(array('link', 'id_landing_page', 'id_usuario'));
        $this->data->_table()->getAdapter()->query('DELETE FROM zz_uploads WHERE id_upload = "'.$post['id_upload'].'" AND id_usuario = "'.$this->me->id_usuario.'"');
        exit;

    }

    public function previewSaveAction()
    {

        $get = $this->_request->getPost();

        $this->data = new Model_Data(new landing_page());
        $this->data->_required(array('html_preview', 'html_final_preview', 'modificado'));
        $this->data->_notNull(array('html_preview','html_final_preview'));

        $edt = $this->data->edit($get['id'],$get,NULL,Model_Data::ATUALIZA);

        if ($edt):

            echo 'true';

        else:

            echo 'false';

        endif;

        exit;

    }

    public function salvarAction(){

        $post = $this->_request->getPost();

        if (!$post[id_pagina]){

            // SALVANDO O HTML DA PÁGINA
            if ($this->salva == 'html_pagina'){

                $this->data = new Model_Data(new landing_page());
                $this->data->_required(array('id_landing_page', 'nome', 'analytics', 'html_pagina', 'html_final', 'modificado', 'criado'));
                $this->data->_notNull(array('html_pagina'));

                $post['nome'] = strip_tags($_POST['nome']);
                $post['html_pagina'] = $_POST['html_pagina'];
                $post['html_final'] = $_POST['html_final'];

                $edt = $this->data->edit($this->id,$post,NULL,Model_Data::ATUALIZA);

                if ($edt){
                    echo 'true';
                } else {
                    echo 'false';
                }

                exit;

            }

        } else {

            $this->id_pagina = $post[id_pagina];

            $this->datas = new Model_Data(new landing_page());
            $this->datas->_required(array('id_landing_page', 'nome', 'html_final', 'modificado', 'criado'));
            $this->datas->_notNull(array('html_pagina'));

            $post['nome'] = strip_tags($_POST['nome']);
            $edts = $this->datas->edit($this->id,$post,NULL,Model_Data::ATUALIZA);

            $this->data = new Model_Data(new paginas_landing());
            $this->data->_required(array('html', 'id_pagina', 'modificado', 'criado'));
            $this->data->_notNull(array('html'));

            $post['html'] = $_POST['html_pagina'];

            $pags = new paginas_landing();
            $this->view->pags = $pags->fetchAll('id_landing_page = '.$this->id.' AND ordem = \''.$this->id_pagina.'\' ');

            $post['id_pagina'] = $this->view->pags[0]->id_pagina;

            $edt = $this->data->edit($post['id_pagina'],$post,NULL,Model_Data::ATUALIZA);

            if ($edt){
                echo 'true'; exit();
            } else {
                echo 'false'; exit();
            }

        }

    }

    public function resetarAction()
    {

        $this->landing = new Model_Data(new landing_page());
        $this->landing->_required(array('html_pagina', 'html_final', 'css_pagina', 'modificado'));
        $this->landing->_notNull(array('html_pagina', 'html_final', 'css_pagina'));

        $get = $this->_request->getParams();

        $templates = new templates();
        $template = $templates->fetchAll('id_landing_page = "'.$get['id'].'"');

        print_r($template); exit;

        $landing = new landing_page();
        $land = $landing->fetchAll('id_landing_page = '.$template[0]->id_landing_page.'');

        print_r($land); exit;

        $data = array();
        $data['html_pagina'] = $land[0]->html;
        $data['html_final'] = $land[0]->html_final;
        $data['css_pagina'] = $land[0]->css;

        $edt = $this->landing->edit($get['id'],$data,NULL,Model_Data::ATUALIZA);

        if ($edt){
            echo '1';
            exit;
        } else {
            echo '0';
            exit;
        }
    }

    public function ajaxEdicaoBoxAction ()
    {
        $params = $this->_request->getParams();
        $this->tipo = $params['tipo'];
        $this->view->tipo = $this->tipo;
        $this->id = $params['id'];
        $this->view->id = $this->id;

        $paginas_landing = new paginas_landing();
        $this->view->paginas_landing = $paginas_landing->fetchAll('id_landing_page = '.$this->id.'','ordem ASC');
    }

    public function meuStatusAction()
    {
        $campanhas_ativo = new campanhas();
        $this->view->campanhas_ativo = $campanhas_ativo->fetchAll('id_usuario = '.$this->me->id_usuario.' AND status = \'ativo\'');

        $array = array('ativos'=>count($this->view->campanhas_ativo),'saldo'=>$this->view->planos[0]->sms_disponivel,'plano_ativos'=>$this->view->planos[0]->campanhas_ativa);
        $json = json_encode($array);
        echo $json;
        exit();

    }

    // GERA UM ID PARA CRIAÇÃO
    public function timeAction()
    {
        echo time();
        exit();
    }

    private function slug($str)
    {

        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '', $str);
        $str = preg_replace('/-+/', "", $str);
        return $str;

    }

    public function edicaoBoxAction()
    {

        $post = $this->_request->getPost();
        echo json_encode(
            array(
                'time'=> time(),
                'slug'=> $this->slug( $post[slug] ),
            )
        );

        exit;

    }

    public function boxAction()
    {

        $post = $this->_request->getPost();
        $this->view->post = $this->post = $post;

    }

}