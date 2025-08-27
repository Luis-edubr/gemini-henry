# Web App IA Text-to-SQL

Projeto de demonstração de geração de consultas SQL a partir de linguagem natural usando IA (Google Gemini) e PostgreSQL.

## Instalação

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/nome-do-repo.git
   cd nome-do-repo/backend
   ```

2. **Instale as dependências PHP:**
   ```bash
   composer install
   ```

3. **Configure o banco de dados PostgreSQL:**
   - Crie o banco e usuário conforme o arquivo `.env`.
   - Execute os comandos SQL do schema e dos dados de exemplo (veja `.env` e instruções no projeto).

4. **Configure as variáveis de ambiente:**
   - Copie `.env.example` para `.env` e preencha com suas credenciais.

5. **Inicie o servidor PHP:**
   ```bash
   php -S localhost:8000
   ```

## Uso

- Acesse no navegador:  
  ```
  http://localhost:8000/frontend
  ```
- Faça perguntas sobre o banco de dados e veja a consulta SQL gerada e o resultado.

## Estrutura

- `/backend`: Código PHP, integração com Gemini e PostgreSQL.
- `/frontend`: Interface web (HTML, CSS, JS).

## Observações

- É necessário uma chave de API Gemini válida.
- O usuário do banco de dados deve ter permissões nas tabelas.
- Para dúvidas, consulte os arquivos de exemplo e instruções no projeto.

---
