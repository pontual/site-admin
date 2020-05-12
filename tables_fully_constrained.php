<?php

// array of table names (keys) and corresponding columns (values)
// used in install.php and delete_all.php

/* Ficha
   
id int not null auto_increment,
razao_social varchar(255) not null,
nome_fantasia varchar(255),
slogan varchar(255),
telefone varchar(255),
endereco varchar(500),
aviso varchar(500),
*/

$TABLES = [
  
  "v2_administrador" => "

id int not null auto_increment,
email varchar(80) not null,
username varchar(80) not null,
password_hash varchar(255) not null,
constraint pk_v2_administrador primary key (id, username)
",

  "v2_ficha" => "

id int not null auto_increment,
campo varchar(80),
valor varchar(255),
constraint pk_v2_ficha primary key (id)
",

  "v2_produto" => "

id int not null auto_increment,
codigo varchar(16) not null,
descricao varchar(200),
peso varchar(32),
medidas varchar(50),
preco varchar(16),
atualizado varchar(16),
normalizado varchar(255),
constraint pk_v2_produto primary key (id)
",

  "v2_categoria" => "

id int not null auto_increment,
nome varchar(80) not null,
constraint pk_v2_categoria primary key (id)
",

  "v2_produtos_de_categoria" => "

id int not null auto_increment,
id_categoria int not null,
id_produto int not null,
constraint pk_v2_produtos_de_categoria primary key (id),
constraint fk_v2_produtos_de_categoria_categoria foreign key (id_categoria)
  references v2_categoria (id),
constraint fk_v2_produtos_de_categoria_produto foreign key (id_produto)
  references v2_produto (id)
",

  "v2_pasta" => "

id int not null auto_increment,
nome varchar(80) not null,
constraint pk_v2_pasta primary key (id)
",

  "v2_link" => "

id int not null auto_increment,
id_pasta int not null,
id_categoria int not null,
nome varchar(80) not null,
constraint pk_v2_link primary key (id),
constraint fk_v2_link_pasta foreign key (id_pasta)
  references v2_pasta (id),
constraint fk_v2_link_categoria foreign key (id_categoria)
  references v2_categoria (id)
",
  
  
];

?>
