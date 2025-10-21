Classe utilitária para registrar e identificar exceções de forma segura e controlada em PHP.
Ideal para aplicações que precisam logar erros no banco de dados sem exibir mensagens sensíveis ao usuário final.

🧠 Visão Geral

A Excecao é uma classe abstrata que centraliza o tratamento de erros.
Quando ocorre uma falha (por exemplo, em uma consulta ou regra de negócio), você pode chamar:

Excecao::identificar($erro);

Cria um registro no banco com todos os detalhes da exceção.

Retorna um código único de erro (ex: CÓDIGO DO ERRO: 123) que pode ser exibido ao usuário ou salvo em log.

Garante que nenhum erro visível seja mostrado em tela, mesmo que o processo de registro falhe.

Exemplo de uso, no try cath simplesmente concatenar com alguma mensagem genérica e passar o Excecao::identificar($e):
```php
public function exemplo()
{
    try {

        //somente exemplo

    } catch (Exception $e) {
        // Mostra mensagem amigável e registra no banco
        new TMessage('error', 'Oops, ocorreu um erro ao gerar os dados. ' . Excecao::identificar($e));
    }
}

<img width="903" height="454" alt="image" src="https://github.com/user-attachments/assets/e536b66b-741e-45e0-bb7d-1693b49c2081" />



