create database universidade;


use universidade;

create table alunos(

	alu_id int primary key auto_increment,
    alu_nome varchar(255) not null,
    alu_status varchar(255) not null
    
);

create table professores(

	prof_id int primary key auto_increment,
    prof_nome varchar(255) not null
    
);

create table curso(

	cur_id int primary key auto_increment,
    cur_nome varchar(255) not null
);

create table disciplina(

	dis_id int primary key auto_increment,
    dis_nome varchar(255) not null,
    cur_id int not null,

    foreign key (cur_id) references curso(cur_id)

);

create table periodo(

	per_id int primary key auto_increment,
    ano int,
    semes int

);

create table turma(

	tur_id int primary key auto_increment,
	dis_id int,
    prof_id int,
    per_id int,
    
    foreign key (dis_id) references disciplina(dis_id),
    foreign key (prof_id) references professores(prof_id),
    foreign key (per_id) references periodo(per_id)

);

create table matricula(

	matr_id int primary key auto_increment,
	tur_id int not null,
    alu_id int not null,
    
	foreign key (tur_id) references turma(tur_id),
    foreign key (alu_id) references alunos(alu_id)

);	

create table notas_frequencia(

	fre_id int primary key auto_increment,
    fre float,
    nota int,
    matr_id int,
    
    foreign key (matr_id) references matricula(matr_id)

);



insert into alunos (alu_nome, alu_status) values

	('Ana','ativo'),
    ('Bruno','ativo'),
    ('Carlos','inativo'),
    ('Daniela','ativo'),
    ('Eduarda','ativo'),
    ('Felipe','inativo')  

;

insert into professores (prof_nome) values

	('Gabriel'),
    ('Heitor'),
    ('Iara')

;

insert into curso (cur_nome) values

	('Banco de Dados'),
    ('Programação Web')

;

insert into disciplina (dis_nome, cur_id) values

	('MySQL', 1),
    ('HTML', 2),
    ('CSS', 2),
    ('NoSQL', 1),
    ('PHP', 2)

;

insert into periodo (ano, semes) values

	(2025, 1),
    (2025, 2)   
;

insert into turma (dis_id, prof_id, per_id) values

	(1,1,1),
    (2,2,1),
    (3,3,1),
    (5,2,2),
    (4,1,2)

;

insert into matricula (tur_id, alu_id) values

	(1,1),
    (1,2),
    (2,1),
    (2,3),
    (3,4),
    (3,5),
    (4,1),
    (5,6)

    
;

insert into notas_frequencia (nota, fre, matr_id) values

	(80,90,1),
    (50,80,2),
    (70,60,3),
    (90,95,4),
    (85,80,5),
    (40,50,6),
    (100,100,7),
    (60,75,8)

;