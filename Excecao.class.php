<?php

abstract class Excecao
{

	/**
	 * Gera uma identificação para o erro
	 * 
	 * Grava em banco de dados uma identificação, detalhes e dados
	 * referentes ao problema ocorrido.
	 * 
	 * ESSE MÉTODO NÃO DEVE MOSTRAR NENHUM ERRO!
	 * 
	 * @param string $mensagemExcecao A mensagem/detalhes da exceção
	 * 
	 * @return string  Idenfificação do erro OU uma string em branco em caso de erros
	 */
	public static function identificar($excecao)
	{
		$backtrace = @debug_backtrace();

		if (!isset($backtrace[1])) return '';

		$mensagemExcecao = null;
		if (is_string($excecao)) {
			$mensagemExcecao = $excecao;
		} else if ($excecao instanceof Throwable) {
			$mensagemExcecao = $excecao->__toString();
		}

		$excecaoPortal = new ExcecaoPortal;
		$excecaoPortal->classe = $backtrace[1]['class'] ?? null;
		$excecaoPortal->metodo = $backtrace[1]['function'] ?? null;
		$excecaoPortal->detalhes = $mensagemExcecao;

		try {
			Consultas::store($excecaoPortal);
		} catch (Exception $e) {
			@error_log($e->getMessage());
			return '';
		}

		return '<br /><span style="font-size:10px;" class="text-danger">CÓDIGO DO ERRO: ' . $excecaoPortal->id . '</span>';
	}
}