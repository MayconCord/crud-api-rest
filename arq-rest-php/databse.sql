create database rest_4tit;

use rest_4tit;

create table turma(
    id int primary key auto_increment,
    nome varchar(10),
    num_alunos decimal(10,2)
);

create table aluno(
    id int primary key auto_increment,
    nome varchar(45),
    idade decimal(10,2),
    turma varchar(10)
    foreign key (turma) references turma(nome)
);