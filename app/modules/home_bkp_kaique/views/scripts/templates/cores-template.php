<style>
    /* CORES */

    <?php foreach($this->cores as $row){?>

    #c-<?php echo $row['nome'];?>.cron,
    #c-<?php echo $row['nome'];?>.bt,
    #c-<?php echo $row['nome'];?>.boleto input[type="submit"],
    #c-<?php echo $row['nome'];?>.oferta .valor,
    form#c-<?php echo $row['nome'];?> .submit-link,
    #c-<?php echo $row['nome'];?>.modal-template {
        background:#<?php echo $row['cor'];?> !important;
        border:none !important;
        color:#<?php echo $row['font'];?> !important;
        outline: none !important;
    }
    form#c-<?php echo $row['nome'];?> label input,
    form#c-<?php echo $row['nome'];?> label textarea {
        border:2px solid #<?php echo $row['cor'];?> !important;
        outline: none !important;
        font-size: 1rem;
        padding: 15px;
        font-family: 'Roboto', sans-serif;
    }
    form#c-<?php echo $row['nome'];?> label.texto[required="required"]:before,
    form#c-<?php echo $row['nome'];?> label.pergunta[required="required"]:before {
        border-top: 53px solid #<?php echo $row['cor'];?> !important;
    }
    #c-<?php echo $row['nome'];?> form.form-geral label.texto[required="required"]:after,
    #c-<?php echo $row['nome'];?> form.form-geral label.pergunta[required="required"]:after{
        color: #<?php echo $row['font'];?> !important;
    }
    #c-<?php echo $row['nome'];?> .form-radio p,
    #c-<?php echo $row['nome'];?> .form-radio label span,
    #c-<?php echo $row['nome'];?> .form-checkbox p,
    #c-<?php echo $row['nome'];?> .pergunta p,
    #c-<?php echo $row['nome'];?> .form-checkbox label span {
        font-size: 1rem;
    }
    #c-<?php echo $row['nome'];?> form.form-geral .form-radio p,
    #c-<?php echo $row['nome'];?> form.form-geral .form-checkbox p,
    #c-<?php echo $row['nome'];?> form.form-geral .pergunta p{
        color: #<?php echo $row['font'];?> !important;
    }
    #c-<?php echo $row['nome'];?> .ui-state-active,
    #c-<?php echo $row['nome'];?> .ui-button:active {
        background:#<?php echo $row['cor'];?> !important;
        color:#<?php echo $row['font'];?> !important;
        outline: none !important;
        border:1px solid rgba(0,0,0,0.1) !important;
    }
    #c-<?php echo $row['nome'];?>.drop-drag {
        background:#<?php echo $row['cor'];?> !important;
        color:#<?php echo $row['font'];?> !important;
    }
    #c-<?php echo $row['nome'];?>.ico-funcao i {
        border:3px solid #<?php echo $row['cor'];?> !important;
    }
    #c-<?php echo $row['nome'];?>.ico-funcao:hover i {
        background:#<?php echo $row['cor'];?>;
        color:#<?php echo $row['font'];?>;
    }
    #c-<?php echo $row['nome'];?>.ico-funcao {
        color:#<?php echo $row['cor'];?> !important;
    }
    #c-<?php echo $row['nome'];?>.cor-paleta {
        background:#<?php echo $row['cor'];?> !important;
        color:#<?php echo $row['font'];?> !important;
    }
    <?php } ?>
</style>