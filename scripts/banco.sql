DROP SCHEMA IF EXISTS cinema;
CREATE SCHEMA IF NOT EXISTS cinema;

USE cinema;

CREATE TABLE IF NOT EXISTS usuarios(
    id int auto_increment PRIMARY KEY,
    username varchar(255) not null,
    email varchar(255) not null,
    senha varchar(255) not null,
    foto varchar(255),
    bio varchar(140),
    role ENUM('user','admin') NOT NULL DEFAULT 'user'
);

-- FILMES

CREATE TABLE IF NOT EXISTS filmes(
    id int auto_increment PRIMARY KEY,
    titulo varchar(255) not null,
    dataDeLancamento date not null,
    sinopse text not null,
    capa varchar(255) not null,
    foto varchar(255) not null
);

CREATE TABLE IF NOT EXISTS analises(
    id_filme INT NOT NULL,
    id_usuario INT NOT NULL,
    comentario varchar(255),
    nota DECIMAL(2,1) not null,
    curtidas INT DEFAULT 0,
    PRIMARY KEY(id_filme, id_usuario),
    CONSTRAINT FK_ANALISE_FILME FOREIGN KEY (id_filme) REFERENCES filmes(id),
    CONSTRAINT FK_ANALISE_USUARIO FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- LISTAS

CREATE TABLE IF NOT EXISTS listas(
    id INT auto_increment PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao varchar(255) NOT NULL,
    idCriadorLista INT NOT NULL,
    CONSTRAINT fk_listas FOREIGN KEY (idCriadorLista) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS lista_filmes (
    id_lista INT NOT NULL,
    id_filme INT NOT NULL,
    PRIMARY KEY (id_lista, id_filme),
    CONSTRAINT FK_LISTA FOREIGN KEY (id_lista) REFERENCES listas(id),
    CONSTRAINT FK_FILME FOREIGN KEY (id_filme) REFERENCES filmes(id)
);

CREATE TABLE IF NOT EXISTS listas_salvas (
    id_lista INT NOT NULL,
    id_usuario INT NOT NULL,
    PRIMARY KEY (id_lista, id_usuario),
    CONSTRAINT FK_LISTA_SALVA FOREIGN KEY (id_lista) REFERENCES listas(id),
    CONSTRAINT FK_LISTA_SALVA_USUARIO FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- COMUNIDADES
CREATE TABLE IF NOT EXISTS comunidades(
    id INT auto_increment PRIMARY KEY,
    titulo varchar(255) not null,
    descricao varchar(255),
    criador_id int not null,
    dono_id int not null,
    criado_em DATETIME not null,
    atualizado_em DATETIME,
    categoria_id int,
    capa varchar(255),
    banner varchar(255),
    CONSTRAINT FK_COMUNIDADE_CRIADOR FOREIGN KEY (criador_id) REFERENCES usuarios(id),
    CONSTRAINT FK_COMUNIDADE_DONO FOREIGN KEY (dono_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS post(
    id INT auto_increment PRIMARY KEY,
    elemento_pai_id int null,
    comunidade_id int not null,
    usuario_id int not null,
    titulo varchar(255) not null,
    comentario TEXT not null,
    data_hora DATETIME not null,
    up_votes int default 0,
    down_votes int default 0,
    CONSTRAINT FK_POST_USUARIO FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    CONSTRAINT FK_POST_COMUNIDADE FOREIGN KEY (comunidade_id) REFERENCES comunidades(id),
    CONSTRAINT FK_ELEMENTO_PAI FOREIGN KEY (elemento_pai_id) REFERENCES post(id)
);

CREATE TABLE IF NOT EXISTS postsRetidos(
    idPost int not null PRIMARY KEY,
    CONSTRAINT FK_POST_RETIDO_ID FOREIGN KEY (idPost) REFERENCES post(id)
);

CREATE TABLE IF NOT EXISTS avaliacoesRetidas(
    idFilme int not null,
    idUsuario int not null,
    PRIMARY KEY(idFilme, idUsuario),
    CONSTRAINT FK_FILME_AVALIACAO_RETIDO_ID FOREIGN KEY (idFilme) REFERENCES filmes(id),
    CONSTRAINT FK_USUARIO_AVALIACAO_RETIDO_ID FOREIGN KEY (idUsuario) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS votos_posts(
    id_post INT NOT NULL,
    id_usuario INT NOT NULL,
    up_vote BOOLEAN NOT NULL DEFAULT FALSE,
    down_vote BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY(id_post, id_usuario),
    CONSTRAINT FK_VOTO_POST_ID FOREIGN KEY (id_post) REFERENCES post(id),
    CONSTRAINT FK_VOTO_USUARIO_ID FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS comunidade_usuarios(
    id_comunidade INT NOT NULL,
    id_usuario INT NOT NULL,
    PRIMARY KEY(id_comunidade, id_usuario),
    CONSTRAINT FK_COMUNIDADE_ID FOREIGN KEY (id_comunidade) REFERENCES comunidades(id),
    CONSTRAINT FK_COMUNIDADE_USUARIO_ID FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS comunidade_adm(
    id_comunidade INT NOT NULL,
    id_usuario INT NOT NULL,
    PRIMARY KEY(id_comunidade, id_usuario),
    CONSTRAINT FK_COMUNIDADE_ADM_ID FOREIGN KEY (id_comunidade) REFERENCES comunidades(id),
    CONSTRAINT FK_COMUNIDADE_USUARIO_ADM_ID FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- TOKEN
CREATE TABLE IF NOT EXISTS usuario_token (
    id_usuario INT,
    token VARCHAR(255),
    data_expiracao DATETIME,
    PRIMARY KEY (id_usuario, token)
);

ALTER TABLE usuario_token
ADD CONSTRAINT FK_USUARIOS_TOKEN
FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
ON DELETE CASCADE
ON UPDATE CASCADE;

CREATE TABLE seguidores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario_seguidor INT NOT NULL,
  id_usuario_seguindo INT NOT NULL,
  UNIQUE KEY (id_usuario_seguidor, id_usuario_seguindo)
);

INSERT INTO usuarios (username, email, senha, foto, bio, role) VALUES (
  'Administrador',
  'admin@cinebrasil.com',
  '$2y$10$mn8RmhHEfcS7aE1/PxKKLuWwx/c7.daI1zgMCvxdCkyxcyXo.U5Ei',
  'assets/img/logo.png',
  'Conta oficial',
  'admin'
);


INSERT INTO `filmes`(`titulo`, `dataDeLancamento`, `sinopse`, `capa`, `foto`) VALUES 
('Os carrinhos', '2006-06-20', 'Aqueçam seus motores e preparem-se para conhecer Rodópolis, uma cidade onde os carros falam e pensam como gente. Tudo nesse lugar gira em torno da velocidade, e todo mundo só pensa em corridas. Tonny trabalha numa companhia de entregas da cidade e é um dos maiores fãs do automobilismo. Seus dois grandes sonhos são se tornar um corredor profissional e conquistar o coração da sobrinha do patrão.', 'uploads/filmes/capas/os-carrinhos.webp','uploads/filmes/fotos/os-carrinhos.jpg'),
('Cidade de Deus','2002-08-30','Baseado em fatos reais, retrata a ascensão do crime organizado na favela Cidade de Deus, no Rio de Janeiro.','uploads/filmes/capas/cidade-de-deus.jpg','uploads/filmes/fotos/cidade-de-deus.jpg'),
('Tropa de Elite','2007-10-12','Capitão Nascimento lidera operações do BOPE enquanto lida com a corrupção policial e o tráfico de drogas no Rio de Janeiro.','uploads/filmes/capas/tropa-de-elite.jpg','uploads/filmes/fotos/tropa-de-elite.jpg'),
('Astronauta','2024-10-18','Em Astronauta, após integrantes da renomada Agência de Pesquisa Espacial Brasileira, a BRASA, desaparecerem em uma misteriosa missão na Lua, visões estranhas começam a perturbar Pereira, um astronauta recém-afastado da organização. Agora, que seus colegas precisam de um resgate urgente, ele vê a oportunidade perfeita para seguir para o espaço buscando compreender a estranha abdução que vivenciou cinco anos antes.','uploads/filmes/capas/astronauta.jpg','uploads/filmes/fotos/astronauta.jpeg'),
('Que Horas Ela Volta?','2015-08-27','Uma empregada doméstica vive em São Paulo na casa de seus patrões, até que a chegada da filha muda toda a dinâmica da casa.','uploads/filmes/capas/que-horas-ela-volta.jpg','uploads/filmes/fotos/que-horas-ela-volta.jpg'),
('Ursinho da Pesada','2008-06-20','Pancada é um faxineiro que trabalha no Bear Bar Box e seu maior sonho é estrelar um espetáculo de dança. Quando finalmente consegue dar asas à sua fantasia, seus planos mudam por uma brilhante ideia.','uploads/filmes/capas/ursinho-da-pesada.webp','uploads/filmes/fotos/ursinho-da-pesada.jpg'),
('Ratatoing','2007-08-20','Ratatoing conta a história de Marcell Toing, um rato que é o chef mais talentoso no Rio de Janeiro. Ele é dono do restaurante famoso "Ratatoing", juntamente com sua tripulação, composta por ratos colegas Carol e Greg. Eles planejam incursões semanais para a cozinha humana para adquirir ingredientes frescos para uso em seus pratos. No entanto, os proprietários do restaurante rival estão desesperados para descobrir os segredos de Marcell e estão dispostos a arriscar colocando seus próprios restaurantes fora do negócio para desenterrá-los.','uploads/filmes/capas/ratatoing.jpg','uploads/filmes/fotos/ratatoing.jpg'),
('Central do Brasil','1998-04-03','Uma ex-professora ajuda um menino a encontrar o pai no interior do Brasil, formando um vínculo inesperado.','uploads/filmes/capas/central-do-brasil.jpg','uploads/filmes/fotos/central-do-brasil.webp'),
('Bacurau','2019-08-29','Moradores de um vilarejo do sertão enfrentam visitantes estrangeiros e descobrem que estão sendo caçados.','uploads/filmes/capas/bacurau.jpeg','uploads/filmes/fotos/bacurau.jpg'),
('Os carrinhos 2', '2006-06-20', 'Os Carrinhos estão de volta com mais ação nas pistas nesta coleção de três aventuras animadas para crianças. Combo tenta salvar sua empresa de entregas provando ser o caminhão mais rápido da Rodópolis Race. Cris espera que uma transformação a ajude a se enturmar. Um artigo de jornal acusa Cruise de trapaça insinuando que a denúncia partiu de Combo. Será que Cruise conseguirá recuperar sua reputação e consertar a amizade?', 'uploads/filmes/capas/os-carrinhos-2.jpg','uploads/filmes/fotos/os-carrinhos-2.jpg'),
('Auto da Compadecida','2000-09-10','As aventuras de João Grilo e Chicó no sertão nordestino misturam humor e crítica social.','uploads/filmes/capas/auto-da-compadecida.jpg','uploads/filmes/fotos/auto-da-compadecida.jpg'),
('O Menino e o Mundo','2013-12-17','Animação que mostra um menino em busca do pai desaparecido, explorando o contraste entre campo e cidade.','uploads/filmes/capas/o-menino-e-o-mundo.jpg','uploads/filmes/fotos/o-menino-e-o-mundo.jpg'),
('Carandiru','2003-04-11','Médico narra as histórias dos detentos da Casa de Detenção de São Paulo antes do massacre.','uploads/filmes/capas/carandiru.jpg','uploads/filmes/fotos/carandiru.jpg'),
('2 Filhos de Francisco','2005-08-19','A trajetória da dupla Zezé Di Camargo & Luciano desde a infância humilde até o sucesso.','uploads/filmes/capas/2-filhos-de-francisco.jpg','uploads/filmes/fotos/2-filhos-de-francisco.jpg'),
('Lixo Extraordinário','2010-10-22','Documentário sobre o trabalho do artista Vik Muniz com catadores do lixão de Gramacho.','uploads/filmes/capas/lixo-extraordinario.jpg','uploads/filmes/fotos/lixo-extraordinario.jpg'),
('O Palhaço','2011-10-28','Benjamim é um palhaço que vive em circo itinerante, mas sente que lhe falta algo.','uploads/filmes/capas/o-palhaco.jpg','uploads/filmes/fotos/o-palhaco.jpg'),
('A Vida Invisível','2019-11-21','Duas irmãs são separadas pela sociedade conservadora dos anos 1950 e vivem vidas paralelas.','uploads/filmes/capas/a-vida-invisivel.jpg','uploads/filmes/fotos/a-vida-invisivel.webp'),
('O Som ao Redor','2013-01-04','A chegada de uma empresa de segurança muda a rotina de um bairro em Recife.','uploads/filmes/capas/o-som-ao-redor.jpg','uploads/filmes/fotos/o-som-ao-redor.jpg'),
('Aquarius','2016-09-01','Uma mulher resiste à pressão de uma construtora para deixar seu apartamento em Recife.','uploads/filmes/capas/aquarius.jpg','uploads/filmes/fotos/aquarius.jpg'),
('Hoje Eu Quero Voltar Sozinho','2014-03-28','Adolescente cego enfrenta mudanças com a chegada de um novo aluno em sua escola.','uploads/filmes/capas/hoje-eu-quero-voltar-sozinho.jpeg','uploads/filmes/fotos/hoje-eu-quero-voltar-sozinho.jpg');