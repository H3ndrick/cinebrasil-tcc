
🎬 Cine Brasil

> Plataforma de análises de filmes nacionais, oferecendo conteúdos para ampliar o acesso ao cinema e à cultura brasileira.



🌐 Acesse o site:
https://cinebrasil.gt.tc/


---

📖 Sobre o Projeto

O Cine Brasil é uma plataforma web que disponibiliza um catálogo com informações sobre filmes brasileiros, tornando o conteúdo audiovisual mais acessível para pessoas.

O objetivo do projeto é promover o conhecimento de obras cinematográficas criadas por brasileiros, permitindo que mais pessoas possam conhecer e discutir sobre o cinema nacional de forma dinâmica.


---

✨ Funcionalidades:

🎥 Catálogo de filmes

🔎 Navegação

📱 Interface responsiva

👥 Interação entre usuários


---

🛠️ Tecnologias Utilizadas

O projeto foi desenvolvido utilizando tecnologias web tradicionais:

🖥️ Backend:

PHP


🌐 Frontend:

HTML5

CSS3

JavaScript

Bootstrap


🛢 Banco de Dados

MySQL



---

🏗️ Estrutura do Projeto (exemplo)
```
cinebrasil/
│
├── assets/                # Arquivos estáticos do site
│   ├── css/               # Arquivos de estilos (CSS)
│   ├── img/               # Imagens e ícones do site
│   └── js/                # Scripts JavaScript
│
├── inclusas/              # Arquivos PHP reutilizáveis (header, footer, conexões, etc.)
├── proc/                  # Scripts de processamento (requisições, formulários, lógica do sistema) / está em processo de substituições pelos webservices
├── scripts/               # Scripts SQL
├── uploads/               # Arquivos enviados pelos usuários ou pelo sistema
├── ws/                    # Endpoints / serviços web
│
├── *.php                  # Páginas principais do site
│
└── README.md
```

---

🚀 Como Executar o Projeto

1️⃣ Clonar o repositório

git clone https://github.com/H3ndrick/cinebrasil-tcc.git

2️⃣ Configurar o servidor

Você pode usar:

XAMPP (utilizado no desenvolvimento)

WAMP


Coloque o projeto na pasta:

htdocs/

3️⃣ Configurar o banco de dados

1. Crie um banco de dados no MySQL


2. Importe o arquivo .sql do projeto: cinebrasil-tcc/scripts/banco.sql


3. Configure a conexão no arquivo de configuração PHP:  cinebrasil-tcc/includes/functions.php



Exemplo:

```
function connect(){
        $server = "localhost";
        $user = "root";
        $password = "";
        $database = "cinema";
        $port = 3306;

        $conn = mysqli_connect($server, $user, $password, $database, $port);

        if(!$conn){
            die("Erro ao conectar no banco de dados ". mysqli_connect_error());
        }

        mysqli_set_charset($conn,"utf8mb4");

        return $conn;
}
```

4️⃣ Rodar o projeto

Abra no navegador:

http://localhost/cinebrasil-tcc

---

📸 Imagens do sistema web rodando:

início:
<img width="1600" height="771" alt="Image" src="https://github.com/user-attachments/assets/23b8198c-c592-49a0-b4de-af7a7d688c70" />

catálogo de filmes:

<img width="1600" height="770" alt="Image" src="https://github.com/user-attachments/assets/31ff6f55-ffdc-4176-b3ca-70eec45be92a" />
