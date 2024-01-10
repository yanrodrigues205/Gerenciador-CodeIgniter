# Gerenciador de Clientes - CodeIgniter
## Apresentação 📽️
<div align="center">
  <img src="https://github.com/yanrodrigues205/AMZMP-CodeIgniter/assets/92941649/a67f3ee9-cfdf-4f95-97c1-8762fd12ca06" width="500" height="250"/>
  <img src="https://github.com/yanrodrigues205/AMZMP-CodeIgniter/assets/92941649/64d8de75-658a-4583-b84d-e2c1cc3dba38" width="500" height="250"/>
</div>
<sub>Vídeos demonstrativos do funcionamento do sistema.</sub>

<details>
  <summary>📊 Análise Gráfica</summary>
https://github.com/yanrodrigues205/AMZMP-CodeIgniter/assets/92941649/b400e17a-9d68-4f67-8166-aace6346db28
</details>

<details>
  <summary>👨‍💻 Login e adição de cliente</summary>
https://github.com/yanrodrigues205/AMZMP-CodeIgniter/assets/92941649/dc50af2a-2383-4cb6-9007-cca98c0ecf92
</details>

<details>
  <summary>✏️ Edição de cliente</summary>
https://github.com/yanrodrigues205/AMZMP-CodeIgniter/assets/92941649/0ea52eb1-2740-410d-a3b5-c330d96ef708
</details>

<details>
  <summary>🗑️ Remoção de cliente</summary>
https://github.com/yanrodrigues205/AMZMP-CodeIgniter/assets/92941649/eed346b4-8217-4cd9-a05c-8fe7d7f0c00f
</details>

## Modelo Entidade Relacional
<div align="center">
  <img src="https://github.com/yanrodrigues205/Gerenciador-CodeIgniter/assets/92941649/eb081614-eeff-4e74-884d-32c79ef806a4" width="500" height="250"/>
</div>





## Instalar 🛠️
<sub>Passo a passo de como instalar e rodar a aplicação na sua máquina.</sub>
- Banco de Dados: Verifique de estar utilizando o banco de dados relacional MySql, e que o mesmo esteja alocado na porta default (:3306), certifique que o servidor está rodando. <pre>default = http://localhost:3306/ </pre>
- Git clone: pegue o endereço de clonagem do repositório aqui no GitHub em Code -> Local -> Clone -> HTTPS, execute: <pre>git clone ENDEREÇO_REPOSITÓRIO</pre>
- Instalando dependências: entre na pasta raiz do projeto e execute o comando: <pre>composer install</pre>
- Contruir tabelas: para que o projeto possa armazenar informações, deve ser utilizadas tabelas do banco de dados, então devemos rodas as migrations do projeto para a tabela ser gerada automaticamente, vá até a pasta raiz do projeto e execute: <pre>php spark migration</pre>
- Executar código: após seguir todos os passos, você deve iniciar o servidor da aplicação, para que possa acessar e realizar a utilização, para isso execute: <pre>php spark serve</pre>
- Login Default: <pre>Email = admin@admin.com
 Senha = admin</pre>

 ## Descrição 🗯️
 <sub>Breve explicação sobre o projeto</sub>
 - Este projeto é uma API Rest construída com PHP, possuindo a opção de criar, alterar e deletar clientes, para front-end foi utilizado BootStrap e JQuery, foram utilizadas algumas bibliotecas como InputMask, CanvasJS, SweetAlert e DataTable. Um sistema síncrono que não depende de "refresh" para acontecer, focado em otimização e experiência do usuário. Os gráficos são alimentados por rotas dentro da api, assim que feita qualquer operação o mesmo busca informações referentes ao momento atual, atualizando os grafícos e a tabela em tempo real. 

## Objetivo 🎖️
<sub>Detalhando os respectivos pontos a serem atingidos com a aplicação.</sub>
- O objetivo do projeto foi a elaboração de um CRUD para clientes, ou seja um sistema que C=crie, R=leia, U=altere e D=apague.
- O sistema deve conter autenticação para que os dados não sejam acessados por "qualquer um", ou seja, deve ser verificado as informações de usuário em cada respectiva "rota".
- Quando for cadastrar um novo cliente o endereço deve ser gerado pela busca do CEP, para isso deve ser utilizado a API ViaCEP.
- Utilzar PHP, se for utilizar algum framework, é recomendado CodeIgniter 3.1+.

## Ferramentas 💻
### Front-End:
    - ☕JQuery
    - 🅱️BootStrap
    - ‼️SweetAlert
    - 📊CanvasJS
    - 📅DataTable
    - 🗯️InputMask
### Back-End:
     - 🐘PHP
     - 🔥CodeIgniter4
     - 💱JSON Web Token

## Licença 🔑
  <pre>
    The MIT License (MIT) &copy;
  </pre>
      

  
