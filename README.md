Classe utilitária para registrar e identificar exceções como por exemplo dados sensíveis do seu banco de dados no ADIANTI FRAMEWORK.
Ideal para aplicações que precisam logar erros no banco de dados sem exibir mensagens sensíveis ao usuário final.

🧠 Visão Geral

A Excecao é uma classe abstrata que centraliza o tratamento de erros.
Quando ocorre uma falha (por exemplo, em uma consulta ou regra de negócio), você pode chamar:

Excecao::identificar($erro);

Cria um registro no banco com todos os detalhes da exceção.

Retorna um código único de erro (ex: CÓDIGO DO ERRO: 123) que pode ser exibido ao usuário e salvo em log.

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
```
nunca mais mostre para o usuário desta forma:
<img width="903" height="454" alt="image" src="https://github.com/user-attachments/assets/e536b66b-741e-45e0-bb7d-1693b49c2081" />

mostre assim:
<img width="930" height="462" alt="2025-10-21_16-02" src="https://github.com/user-attachments/assets/795d2764-84a5-4727-9aac-bb5596043084" />

registre os logs na listagem dos registros:
<img width="1534" height="500" alt="2025-10-21_16-04" src="https://github.com/user-attachments/assets/8ca8ce45-66cd-4c16-8c59-4cd14e58cbd4" />



