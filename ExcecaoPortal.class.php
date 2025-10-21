<?php
/**
 * ExcecaoPortal Active Record
 */
class ExcecaoPortal extends TRecord
{
    const TABLENAME = 'auditoria.excecoes_portal';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('classe');
        parent::addAttribute('metodo');
        parent::addAttribute('detalhes');
        parent::addAttribute('data_hora');
    }
}
