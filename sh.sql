/*	Este banco de dados tem como objetivo ser um sanar, futuramente, uma deficiência no setor de TI de uma empresa X quanto aos auxiliares de TI, os
quais são responsáveis pela manutenção e controle de envios de equipamentos relacionados à TI para as suas demais filiais. 
	O objetivo principal é auxiliá-los com esse controle desse sistema -- que até então era feita de forma não muito intuitiva: usando planilhas -- ao
integrar este banco MySQL à uma linguagem de programação, no caso, o Java, a fim de integrar o CRUD.
Desse modo, facilita-se a inserção, listagem, atualização e deleção de dados.
	Como é um protótipo, pode-se haver equívocos nesta primeira versão. Entretanto, para os fins da empresa, um dos integrantes do trabalho 
que atua na empresa definiu que tal modelo é o mais ideal a ser utilizado.
	O grupo utilizou uma modelagem do banco inicialmente antes de dar início à sua criação.
*/

CREATE SCHEMA controle_equipamentos_ti -- Criação do banco de dados 'controle_equipamentos_ti'
DEFAULT CHARACTER SET utf8mb4 -- Definindo caracteres especiais.
DEFAULT COLLATE utf8mb4_bin; -- Definindo case-sensitive padrões.

USE controle_equipamentos_ti; -- Utilizando o banco.

-- Criação da tabela de equipamento, com a qual se relacionará a classe abstrata 'equipamento', em Java, ou seja, não poderá ser instanciada, servindo, desse como, como herança.
CREATE TABLE equipamento (
	 pk_num_serie VARCHAR (50) PRIMARY KEY,
     placa INT UNIQUE,
	 tipo VARCHAR(30) NOT NULL,
     modelo VARCHAR(30) NOT NULL,
     localizacao_atual INT NOT NULL, -- Loja
     enviado ENUM ('Não', 'Sim') NOT NULL DEFAULT 'Não' -- Após INSERT EM 'envio_equipamento', acionará uma TRIGGER que dará um UPDATE aqui.

) ENGINE=InnoDB; -- Engenharia padrão mais recente que possibilita maior segurança e otimização comparada ao MyISAM. 

-- Criação da tabela de computador, com a qual se relacionará a classe 'computadorDAO', em Java, instanciada.
CREATE TABLE computador (
    fk_num_serie VARCHAR(50) NOT NULL,
	pk_computador INT AUTO_INCREMENT PRIMARY KEY,
    processador VARCHAR(30) NOT NULL,
    memoria VARCHAR(30) NOT NULL,
    windows VARCHAR(30) NOT NULL,
    armazenamento VARCHAR(30) NOT NULL,
    formatacao VARCHAR(30) NOT NULL, -- Ideal se passar data
    manutencao VARCHAR(30) NOT NULL, -- Ideal se passar data
    
    INDEX idx_fk_num_serie (fk_num_serie), -- Indexador que deixará a consulta mais otimizada ao utilizar a respectiva FOREIGN KEY.
    
    CONSTRAINT fk_equipamento_computador FOREIGN KEY (fk_num_serie) REFERENCES equipamento(pk_num_serie) ON DELETE CASCADE ON UPDATE CASCADE -- Definindo a FOREIGN KEY. Deixado-a para deletar e/ou atualizar em cascata caso ela seja apagada ou atualizada na tabela com a tabela que está sendo referenciada nesta.
) ENGINE=InnoDB;

-- Criação da tabela de computador, com a qual se relacionará a classe 'impressoraDAO', em Java, instanciada.
CREATE TABLE impressora (
	fk_num_serie VARCHAR(50) NOT NULL,
	pk_impressora INT AUTO_INCREMENT PRIMARY KEY,
    revisao_recente ENUM ('Não', 'Sim') NOT NULL DEFAULT 'Sim', -- Revisão recente antes de ir para loja x
    data_revisao DATE NOT NULL,
    motivo_revisao VARCHAR(60) NOT NULL,
    
    INDEX idx_fk_num_serie (fk_num_serie),
    
    CONSTRAINT fk_equipamento_impressora FOREIGN KEY (fk_num_serie) REFERENCES equipamento(pk_num_serie) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Criação da tabela de computador, sobre a qual se relacionará a classe 'OutrosEquipamentosDAO', em Java, instanciada.
CREATE TABLE equipamento_generico (
	fk_num_serie VARCHAR(50) NOT NULL,
    pk_equipamento_generico INT AUTO_INCREMENT PRIMARY KEY,
	descricao VARCHAR(80) NOT NULL, -- Passa-se um complemento de informações
    
	INDEX idx_fk_num_serie (fk_num_serie),
    
    CONSTRAINT fk_equipamento_equipamento_generico FOREIGN KEY (fk_num_serie) REFERENCES equipamento(pk_num_serie) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Criação da tabela de computador, sobre a qual se relacionará a classe 'LojaDAO', em Java, instanciada.
CREATE TABLE loja (
	pk_loja INT AUTO_INCREMENT PRIMARY KEY,
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    gerente VARCHAR(30) NOT NULL,
    cidade VARCHAR(20) NOT NULL,
    telefone VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- Criação da tabela de computador, sobre a qual se relacionará a classe 'EnvioEquipamento', em Java, instanciada.
CREATE TABLE envio_equipamento (
	pk_envio INT AUTO_INCREMENT PRIMARY KEY,
	fk_num_serie VARCHAR(50) NOT NULL,
    origem INT,
    fk_loja INT NOT NULL,
    motivo TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    
	INDEX idx_fk_num_serie (fk_num_serie),
	INDEX idx_fk_loja (fk_loja),
    
	CONSTRAINT fk_num_serie_envio FOREIGN KEY (fk_num_serie) REFERENCES equipamento(pk_num_serie) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_loja_envio FOREIGN KEY (fk_loja) REFERENCES loja(pk_loja) ON DELETE CASCADE ON UPDATE CASCADE
   -- CONSTRAINT pk_envio PRIMARY KEY (fk_num_serie, fk_loja)
) ENGINE=InnoDB;

-- Mostrando as tabelas do banco controle_equipamentos_TI.
SHOW TABLES;

-- Povoamento das tabelas de equipamento. Tais atributos da tabela serão herdadas, via FOREIGN KEY, para as tabelas computador, impressora e outros_equipamentos. (Em Java iso é visto mais facilmente.)
START TRANSACTION; -- Iniciando a transação manualmente, sem dar auto-commit. (Ideal para um DBA.)
INSERT equipamento (pk_num_serie, placa, tipo, modelo, localizacao_atual) VALUES
('1', '1', 'Microcomputador', 'Dell Optiplex 3060', 44),
('2', '2', 'Microcomputador', 'Bematech RC-8400', 20),
('3', '3', 'Microcomputador', 'Dell Optiplex 3050', 999),
('4', '4', 'Desktop', 'Montada', 15),
('5', '5', 'Notebook', 'Inspiron 15', 1);
INSERT equipamento (pk_num_serie, placa, tipo, modelo, localizacao_atual) VAlUES
('6', '6', 'Multifuncional a laser', 'HP M1132', 1),
('7', '7', 'Multifuncional a laser', 'Brother 2540', 2),
('8', '8', 'Fotográfica a jato de tinta', 'Epson L805', 33),
('9', '9', 'Multifuncional a laser', 'HP M125a', 43),
('10', '10', 'Impressora a laser', 'P1102', 24);
INSERT equipamento (pk_num_serie, placa, tipo, modelo, localizacao_atual) VALUES
('11', '11', 'Nobreak', 'SMS', 1),
('12', '12', 'Leitor de código de barras', 'Bematech', 1),
('13', '13', 'Monitor', 'AOC', 2),
('14', '14', 'Impressora fiscal', 'Bematech 4200', 1),
('15', '15', 'Estabilizador', 'SMS', 1);

-- Povoamento da  tabela de computador.
INSERT INTO computador (fk_num_serie, pk_computador, processador, memoria, windows, armazenamento, formatacao, manutencao) VALUES
(1, 130, 'i3 8100T', '8GB DDR4', '11 Pro', 'SSD 240GB', 'Sim', 'Sim'),
(2, NULL, 'Celeron N5095', '4GB DDR4', '11 Pro', 'NvME 256GB', 'Sim', 'Sim'),
(3, NULL, 'i3 6100T', '4GB DDR4', '11 Pro', 'HDD 500GB', 'Sim', 'Não'),
(4, NULL, 'Pentium E5300', '4GB DDR2', '10 Pro', 'HDD 500GB', 'Sim', 'Sim'),
(5, NULL, 'i5 71000', '8GB DDR4', '11 Pro', 'SSD 256GB', 'Sim', 'Não');

-- Povoamento das tabela de impressora.
INSERT INTO impressora (fk_num_serie, pk_impressora, revisao_recente, data_revisao, motivo_revisao) VALUES
(6, 35, 'Sim', '2023-07-08', 'Troca de fusor.'),
(7, NULL, 'Sim', '2023-10-2', 'Troca de película.'),
(8, NULL, 'Sim', '2023-02-11', 'Troca de bucha.'),
(9, NULL, 'Sim', '2023-10-02', 'Troca de fusor.'),
(10, NULL, 'Não', '2023-08-19', 'Troca de borracha.');

-- Povoamento das tabela de outros_equipamentos.
INSERT INTO equipamento_generico (fk_num_serie, pk_equipamento_generico, descricao) VALUES
(11, 203, '600 VA'),
(12, NULL, 'Sem fio'),
(13, NULL, '17 polegadas'),
(14, NULL, 'Convertida'),
(15, NULL, '600VA');

-- Povoamento da tabela de loja.
INSERT INTO loja (pk_loja, cnpj, gerente, cidade, telefone) VALUES 
(NULL, '22.222.998/0923-40', 'Marcelo', 'Patrocínio', '(34) 9 98222-343'),
(NULL, '22.222.998/0922-10', 'José', 'Patos de Minas', '(34) 9 9912-7876'),
(NULL, '22.222.998/083-98', 'Kely', 'Paracatu', '(34) 9 97192-9341'),
(NULL, '22.222.998/082-99', 'Raúl', 'São Gotardo', '(34) 9 9834-0973'),
(NULL, '22.222.998/023-21', 'Raquel', 'Araxá', '(34) 9 8293-0287');

-- Povoamento da tabela envio_equipamento, correlacionando com equipamento e loja de forma agregativa. (Em Java isso é visto como associação de agregação.)
INSERT INTO envio_equipamento (fk_num_serie, fk_loja, data_envio, motivo) VALUES
(1, 1, 'BIOS atualizada para tentar corrigir reinício repentino da máquina.'),
(2, 2, 'Trocar máquina do gerente. A que voltar será destinada ao EFN.'),
(3, 3, 'Substituir o computador do balcão que foi queimado.');
INSERT INTO envio_equipamento (fk_num_serie, fk_loja, data_envio, motivo) VALUES
(6, 1, 'Troca da impressora Brother 1617, engasgando papel.'),
(7, 3, 'Troca de impressora, não puxa papel.'),
(8, 2, 'Troca de impressora, borrando papel.');
INSERT INTO envio_equipamento (fk_num_serie, fk_loja, data_envio, motivo) VALUES
(11, 3, 'Troca de nobreak queimado.'),
(12, 2, 'Faltando leitor s/ fio na loja'),
(13, 1, 'Troca de monitor de 15 polegadas.');
-- ROLLBACK; -- Caso deseje voltar para estado anterior antes das inserções.
COMMIT; -- Comitando as inserções feitas.

-- Selecionando todos os atributos das respectivas tabelas.
SELECT * FROM equipamento;
SELECT * FROM computador;
SELECT * FROM impressora;
SELECT * FROM equipamento_generico;
SELECT * FROM loja;
SELECT * FROM envio_equipamento;

-- Criando uma VIEW detalhada, em que há os atributos modelo e tipo advindos de 'equipamento', para o envio de equipamento, que será usada para listar os dados de 'Outros_EquipamentosDAO', no Java.
CREATE VIEW view_equipamento_envio_detalhado AS (
	SELECT eq.fk_num_serie, e.tipo, e.modelo, eq.origem AS origem_loja, eq.fk_loja AS destino_loja, DATE_FORMAT(eq.data_envio, "%d/%m/%Y") AS data_envio,  eq.motivo
    FROM envio_equipamento eq
    INNER JOIN equipamento e
    ON eq.fk_num_serie = e.pk_num_serie
    INNER JOIN loja l
    ON eq.fk_loja = l.pk_loja
);

-- Criando uma VIEW para o envio de computador, na qual pode-se ver os que não foram enviados.
CREATE VIEW view_computador_enviado_nao_enviado AS ( -- Após criar, futuramente, a TRIGGER de envio para alterar o status de equipamento, tal VIEW se torna desnecessária para ver quais computadores foram enviados, podendo torná-la mais simplificada.
	SELECT c.pk_computador AS id_computador, e.modelo
	FROM equipamento e
    INNER JOIN computador c
    ON e.pk_num_serie = c.fk_num_serie
    LEFT JOIN envio_equipamento ee
    ON ee.fk_num_serie = e.pk_num_serie
    WHERE ee.fk_num_serie IS NULL
);

-- Criando uma VIEW para o envio de impressora, na qual pode-se ver as que não foram enviadas.
CREATE VIEW view_impressora_enviada_nao_enviada AS ( -- Após criar, futuramente, a TRIGGER de envio para alterar o status de equipamento, tal VIEW se torna desnecessária para ver quais impressoras foram enviadas, podendo torná-la mais simplificada.
	SELECT i.pk_impressora AS id_impressora, e.modelo
    FROM equipamento e
    INNER JOIN impressora i
    ON e.pk_num_serie = i.fk_num_serie
	LEFT JOIN envio_equipamento ee
    ON ee.fk_num_serie = e.pk_num_serie
    WHERE ee.fk_num_serie IS NULL
);

-- Criando uma VIEW para o envio equipamentos_genericos, na qual pode-se ver os que não foram enviados.
CREATE VIEW view_equipamento_generico_nao_enviado AS ( -- Após criar, futuramente, a TRIGGER de envio para alterar o status de equipamento, tal VIEW se torna desnecessária para ver quais outros equipamentos foram enviados, podendo torná-la mais simplificada.
	SELECT eg.pk_equipamento_generico AS id_outros, e.modelo
    FROM equipamento e
    INNER JOIN equipamento_generico eg
    ON e.pk_num_serie = eg.fk_num_serie
	LEFT JOIN envio_equipamento ee
    ON ee.fk_num_serie = e.pk_num_serie
	WHERE ee.fk_num_serie IS NULL
);

-- Selecionando todos os atributos das respectivas VIEWS. (A primeira é destinada ao READ do 'Envio_Equipamento', pois facilita para inserir o cript no Java, além de ser um facilitador para o usuáio do banco.) 
SELECT * FROM view_equipamento_envio_detalhado;
SELECT * FROM view_computador_enviado_nao_enviado;
SELECT * FROM view_impressora_enviada_nao_enviada;
SELECT * FROM view_equipamento_generico_nao_enviado;

describe loja;

describe envio_equipamento;

-- Criando tabela de LOG para equipamentos descartados após o acionamento da TRIGGER 'trg_descarte_equipamento'
-- Importante ressaltar que não foi utilizada CONSTRAINTS neste LOG em razão de não haver necessidade, além de estar havendo erro, pois tais dados já foram excluídos da TABLE referenciada após o acionamento de sua TRIGGER.
CREATE TABLE log_equipamentos_descartados (
    fk_num_serie INT PRIMARY KEY, -- Atribuiu-se à 'fk_num_serie', em que será inserida a FOREIGN KEY da TABLE equipamento via TRIGGER, como PRIMARY KEY pois a intenção é que o equipamento deletado apenas uma única vez. 
    tipo VARCHAR (30) NOT NULL,
    modelo VARCHAR(30) NOT NULL,
    motivo VARCHAR(30) NOT NULL,
    ultima_localizacao VARCHAR(30) NOT NULL,
	data DATE NOT NULL,
    usuario VARCHAR(25) NOT NULL,
    
    INDEX idx_fk_num_serie (fk_num_serie)
)ENGINE=InnoDB;

-- Criando tabela de LOG para envios descartados de equipamento após o acionamento da TRIGGER 'trg_descarte_envio'
CREATE TABLE log_envios_antigos_equipamentos (
	pk_envio_antigo INT AUTO_INCREMENT PRIMARY KEY,
    fk_num_serie VARCHAR(100) NOT NULL, -- Como a intenção que envio de um equipamento X para uma loja X possa ser descartado mais de uma vez, criou-se uma própria PRIMARY KEY que possibilita isso.
    fk_loja INT NOT NULL,
    motivo VARCHAR(30) NOT NULL,
	data DATE NOT NULL,
    usuario VARCHAR(25) NOT NULL,
    
	INDEX idx_fk_num_serie (fk_num_serie),
    INDEX idx_fk_loja (fk_loja),
    
    CONSTRAINT pk_envio_equipamento_descarte FOREIGN KEY (fk_num_serie) REFERENCES equipamento(pk_num_serie) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT pk_envio_loja_descarte FOREIGN KEY (fk_loja) REFERENCES loja(pk_loja) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB;

/*Criação do usuário; atribuição de papel criado com seus respectivos privilégios relativos somente ao CRUD. Como
não se pode selecionar mais de uma tabela a serem concedidas os privilégios, houve a necessidade de 
atribuí-los uma a uma. 
Criou-se o papel para caso haja outros usuários que contemplem os mesmos privilégios, facilitando, desse modo,
a atribuição. (Além do 'auxiliar_01_TI,', poderia haver o 02, 03 etc.)*/
CREATE USER 'auxiliar01_ti'@'%' IDENTIFIED BY 'Nac@2000';
CREATE ROLE aux_ti;

GRANT aux_ti TO 'auxiliar01_ti'@'%';
SET DEFAULT ROLE aux_ti TO 'auxiliar01_ti'@'%'; -- definindo papel como padrão para o usuário para que não haja erros de concessão de privilégios.

GRANT USAGE -- Atribuindo o privilégio primordial de usar o banco ao papel. (Essencial para se conectá-lo ao Java.)
ON contole_equipamentos_ti.*
TO aux_ti;
GRANT INSERT, SELECT, UPDATE, DELETE 
ON controle_equipamentos_ti.equipamento
TO aux_ti;
GRANT INSERT, SELECT, UPDATE, DELETE 
ON controle_equipamentos_ti.computador
TO aux_ti;
GRANT INSERT, SELECT, UPDATE, DELETE 
ON controle_equipamentos_ti.impressora
TO aux_ti;
GRANT INSERT, SELECT, UPDATE, DELETE 
ON controle_equipamentos_ti.outros_equipamentos
TO aux_ti;
GRANT INSERT, SELECT, UPDATE, DELETE 
ON controle_equipamentos_ti.loja
TO aux_ti;
GRANT INSERT, SELECT, UPDATE, DELETE 
ON controle_equipamentos_ti.envio_equipamento
TO aux_ti;
GRANT SELECT
ON controle_equipamentos_ti.log_equipamentos_descartados
TO aux_ti;
GRANT SELECT
ON controle_equipamentos_ti.log_envios_antigos_equipamentos
TO aux_ti;
GRANT SELECT
ON controle_equipamentos_ti.view_equipamento_envio_detalhado
TO aux_ti;
GRANT SELECT
ON controle_equipamentos_ti.view_computador_enviado_nao_enviado
TO aux_ti;
GRANT SELECT
ON controle_equipamentos_ti.view_impressora_enviada_nao_enviada
TO aux_ti;
GRANT SELECT
ON controle_equipamentos_ti.view_outros_equip_enviado_nao_enviado
TO aux_ti;
FLUSH PRIVILEGES; -- Garantindo a atualização dos privilégios.

-- Mostrando os privilégios da ROLE 'aux_ti'.
SHOW GRANTS FOR aux_ti;
-- Mostrando os priviégios do USER 'auxiliar_ti'@'%'
SHOW GRANTS FOR 'auxiliar01_ti'@'%';

-- Criação da TRIGGER da tabela 'equipamento', em que, ao deletar algum dado desta, insere-se na tabela de 'log_equipamentos_descartados' os respectivos dados dessa. Mesma coisa ocorre na TRIGGER log_equipamentos_descartados', inserindo na TABLE 'log_envios_equipamentos_descartados'.
/*A utilidade das TRIGGERS logos abaixo é justamente, respectivamente, saber quais os equipamentos que foram descartados, ou seja, que não serão usados mais
e saber os descarte de envios de equipamentos, que se refere a: caso um equipamento seja devolvido de uma loja X, o usuário deverá deletar o envio de equipamento, esse dado será armazenado na tabela de log para isso.
Em outras palavras, na tabela de envio de equipamentos importa-se somente o último envio dela, mas é importante saber os outros possíveis envios anteriores para outras lojas, ou até mesmo para a própria loja.*/
DELIMITER &&
CREATE TRIGGER trg_envio_update_localizacao_atual_enviado BEFORE INSERT -- arrumar ainda, antes de inserir, delete os que forem iguais chave composta
ON envio_equipamento
FOR EACH ROW 
BEGIN
    SET NEW.origem = (SELECT localizacao_atual FROM equipamento WHERE pk_num_serie = NEW.fk_num_serie);
    
	UPDATE equipamento SET localizacao_atual = NEW.fk_loja WHERE pk_num_serie = NEW.fk_num_serie;
    
    UPDATE equipamento SET enviado = 'Sim' WHERE pk_num_serie = NEW.fk_num_serie;
    
	-- DELETE FROM envio_equipamento WHERE fk_num_serie = NEW.fk_num_serie;
END&&
DELIMITER ;
    
DELIMITER &&
CREATE TRIGGER trg_descarte_equipamento BEFORE DELETE
ON equipamento
FOR EACH ROW 
BEGIN
	INSERT INTO log_equipamentos_descartados (fk_num_serie, tipo, modelo, motivo, ultima_localizacao, data, usuario) VALUES (OLD.pk_num_serie, OLD.tipo, OLD.modelo, 'Velho ou estragado', OLD.localizacao_atual, NOW(), USER());
END&&
DELIMITER ;

DELIMITER &&
CREATE TRIGGER trg_envio_antigo BEFORE DELETE -- MUDAR TRIGGER PARA INSERIR 
ON envio_equipamento
FOR EACH ROW
BEGIN
	INSERT INTO log_envios_antigos_equipamentos (fk_num_serie, fk_loja, motivo, data, usuario) VALUES (OLD.fk_num_serie, OLD.fk_loja, 'Equipamento devolvido', NOW(), USER());
END&&
DELIMITER ;

DELIMITER %%
CREATE PROCEDURE proc_deletar_envio_equipamento_duplicado (IN trg_pk_envio INT, IN trg_fk_num_serie VARCHAR(30))
BEGIN
	DELETE FROM envio_equipamento WHERE pk_envio != trg_pk_envio AND fk_num_serie = trg_fk_num_serie;
END%%
DELIMITER ;

-- Criação de PROCEDURE a fim de automatizar o processo, via banco, de DELETE de um determinado equipamento. (Ideal fazer pelo Java.)
DELIMITER %%
CREATE PROCEDURE proc_deletar_equipamento (IN id_equipamento INT)
BEGIN
	DELETE FROM equipamento WHERE pk_num_serie = id_equipamento;
END%%
DELIMITER ;

-- Criação de PROCEDURE a fim de automatizar o processo, via banco, de DELETE de um determinado envio de equipamento. (Ideal fazer pelo Java.)
DELIMITER %%
CREATE PROCEDURE proc_deletar_envio_equipamento (IN id_equipamento INT, IN id_loja INT)
BEGIN
	DELETE FROM envio_equipamento WHERE fk_num_serie = id_equipamento AND fk_loja = id_loja;
END%%
DELIMITER ;

-- Atribuindo os privilégios restantes quanto às TRIGGES e PROCEDURES criadas.
GRANT TRIGGER
ON controle_equipamentos_ti.*
TO aux_ti;
GRANT EXECUTE
ON PROCEDURE controle_equipamentos_ti.proc_deletar_equipamento
TO aux_ti;
GRANT EXECUTE
ON PROCEDURE controle_equipamentos_ti.proc_deletar_envio_equipamento 
TO aux_ti;
FLUSH PRIVILEGES;

-- Chamando a PROCEDURE e passando o respectivo valor referente ao ID da tabela 'equipamento'; já na segunda, além desse, passa-se também o de 'loja'.
CALL proc_deletar_equipamento(9);
CALL proc_deletar_envio_equipamento(2, 2);

-- Selecionando os atributos da tabela 'log_equipamentos_descartados' e 'log_envios_equipamentos_descartados'.
SELECT * FROM log_equipamentos_descartados;
SELECT * FROM log_envios_antigos_equipamentos;

CREATE TABLE usuarios (
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome_usuario VARCHAR(15) UNIQUE NOT NULL,
    senha CHAR(64) NOT NULL,
    data_criacao TIMESTAMP DEFAULT NOW()
);

INSERT INTO usuarios (nome_usuario, senha) 
VALUES ('Lucas', SHA2('teste', 256));

CREATE VIEW view_equipamento_computador AS (
	SELECT c.pk_computador, e.pk_num_serie, e.placa, e.tipo, e.modelo, c.processador, c.memoria, c.armazenamento,  c.windows, c.manutencao, c.formatacao, e.localizacao_atual, e.enviado
    FROM equipamento e
    INNER JOIN computador c
    ON e.pk_num_serie = c.fk_num_serie
    ORDER BY c.pk_computador ASC
);

CREATE VIEW view_equipamento_impressora AS (
	SELECT i.pk_impressora, e.pk_num_serie, e.placa, e.tipo, e.modelo, i.revisao_recente, i.data_revisao, i.motivo_revisao, e.localizacao_atual, e.enviado
    FROM equipamento e
    INNER JOIN impressora i
    ON e.pk_num_serie = i.fk_num_serie
    ORDER BY i.pk_impressora ASC
);

CREATE VIEW view_equipamento_equipamento_generico AS (
	SELECT eg.pk_equipamento_generico, e.pk_num_serie, e.placa, e.tipo, e.modelo, eg.descricao, e.localizacao_atual, e.enviado
    FROM equipamento e
    INNER JOIN equipamento_generico eg
    ON e.pk_num_serie = eg.fk_num_serie
    ORDER BY eg.pk_equipamento_generico ASC
);

SELECT * FROM view_equipamento_computador;
SELECT * FROM view_equipamento_impressora;
SELECT * FROM view_equipamento_equipamento_generico;

INSERT INTO envio_equipamento (fk_num_serie, fk_loja, motivo) VALUES
(2, 2, 'BIOS atualizada para tentar corrigir reinício repentino da máquina.');

INSERT INTO envio_equipamento (fk_num_serie, fk_loja, motivo) VALUES
(2, 3, 'BIOS atualizada para tentar corrigir reinício repentino da máquina.');

SELECT * FROM log_envios_antigos_equipamentos;
SELECT * FROM envio_equipamento;
SELECT * FROM equipamento;
SELECT * FROm loja;
SELECT * FROM usuarios;

SELECT * FROM view_equipamento_envio_detalhado WHERE (SELECT MAX(pk_envio) FROM envio_equipamento);

/*DROP SCHEMA controle_equipamentos_ti; -- Caso seja necessário resetar o banco de dados apague-o.
DROP USER auxiliar01_ti; -- Caso seja necessário excluir o usuário.
DROP ROLE aux_ti; -- Caso seja necessário excluir o papel atribuído ao usuário.
