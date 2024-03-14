-- Geração de Modelo físico
-- Sql ANSI 2003 - brModelo.

CREATE DATABASE resv;
-- Drop database resv;
USE resv;

CREATE TABLE statususuario (
id_status INTEGER PRIMARY KEY AUTO_INCREMENT,
status VARCHAR(20)
);

CREATE TABLE cobranca (
id_cobranca INTEGER PRIMARY KEY AUTO_INCREMENT,
cobranca VARCHAR(20)
);

CREATE TABLE pagamento (
id_pagamento INTEGER PRIMARY KEY AUTO_INCREMENT,
id_cliente INTEGER,
id_estacionamento INTEGER,
tipocobranca VARCHAR(20),
tempototal INTEGER,
valor FLOAT(10,2),
datapagamento DATE
);

CREATE TABLE usuario (
id_usuario INTEGER PRIMARY KEY AUTO_INCREMENT,
id_status INTEGER,
nome varchar(30),
login VARCHAR(15),
senha VARCHAR(10),
FOREIGN KEY(id_status) REFERENCES statususuario (id_status)
);

CREATE TABLE plano (
id_plano INTEGER PRIMARY KEY AUTO_INCREMENT,
plano VARCHAR(20),
valorplano FLOAT(10,2)
);

CREATE TABLE esveiculos (
id_estacionamento INTEGER PRIMARY KEY AUTO_INCREMENT,
id_cliente INTEGER,
id_tipoveiculo INTEGER,
id_cobranca INTEGER,
placa VARCHAR(7),
marcamodelo VARCHAR(30),
telefone VARCHAR(12),
dhentrada DATETIME,
dhsaida DATETIME,
id_usuario INTEGER,
FOREIGN KEY(id_cobranca) REFERENCES cobranca (id_cobranca),
FOREIGN KEY(id_usuario) REFERENCES usuario (id_usuario)
);

CREATE TABLE tipoveiculo (
id_tipoveiculo INTEGER PRIMARY KEY AUTO_INCREMENT,
tipoveiculo VARCHAR(15),
valorhora FLOAT(10,2),
valorminuto FLOAT(10,2),
valordiaria FLOAT(10,2),
vagastotais INTEGER,
vagasdisponiveis INTEGER
);

CREATE TABLE cliente (
id_cliente INTEGER PRIMARY KEY AUTO_INCREMENT,
cliente VARCHAR(30),
cpfcnpj VARCHAR(14),
telefonecliente VARCHAR(12),
placa VARCHAR(7),
marcamodelo VARCHAR(30),
id_tipoveiculo INTEGER,
id_plano INTEGER,
diapagamento INTEGER,
FOREIGN KEY(id_plano) REFERENCES plano (id_plano),
FOREIGN KEY(id_tipoveiculo) REFERENCES tipoveiculo (id_tipoveiculo)
);

ALTER TABLE cliente AUTO_INCREMENT = 1000;
ALTER TABLE usuario AUTO_INCREMENT = 100;

ALTER TABLE pagamento ADD FOREIGN KEY(id_cliente) REFERENCES cliente (id_cliente);
ALTER TABLE pagamento ADD FOREIGN KEY(id_estacionamento) REFERENCES esveiculos (id_estacionamento);
ALTER TABLE esveiculos ADD FOREIGN KEY(id_cliente) REFERENCES cliente (id_cliente) ;
ALTER TABLE esveiculos ADD FOREIGN KEY(id_tipoveiculo) REFERENCES tipoveiculo (id_tipoveiculo);

INSERT INTO plano (plano, valorplano)
	VALUES 	('Cliente Frequente', 0),
			('Diario', 200),
			('Noturno', 50),
			('Garagem', 300);
           
INSERT INTO statususuario (status)
	VALUES ('Administrador'),
		   ('Funcionario'),
           ('Inativo');
           
INSERT INTO usuario (nome, login, senha, id_status)
	VALUES 	('Albano Dias','albdias', '123', 1),
			('Eduardo Dursley','dudadursley', '123', 2),
			('Régulo Black', 'regblack', '123', 2);
           
INSERT INTO tipoveiculo (tipoveiculo, valorhora, valorminuto, valordiaria, vagastotais, vagasdisponiveis)
	VALUES ('Motocicleta', 4, 0.05, 25, 25, 25),
		   ('Pequeno', 5, 0.05, 30, 25, 25),
           ('Medio', 7, 0.05, 40, 25, 25),
           ('Grande', 10, 0.05, 50, 25, 25);
           
INSERT INTO cobranca(cobranca)
	VALUES	('Tempo'),
			('Diaria'),
            ('Mensalista');
            

SET GLOBAL log_bin_trust_function_creators = 1;
  
DELIMITER \\
CREATE PROCEDURE sp_entradaveiculocomum ( tipo INT, cobranca INT, placaveiculo VARCHAR(7), veiculo varchar(30), telefone VARCHAR(12), usuario INT)
	BEGIN
		INSERT INTO esveiculos(id_tipoveiculo, id_cobranca, placa, marcamodelo, telefone, dhentrada, id_usuario)
			VALUES	(tipo, cobranca, placaveiculo, veiculo, telefone, CURRENT_TIMESTAMP(), usuario);
	END \\
DELIMITER ;

DELIMITER \\
CREATE PROCEDURE sp_entradaveiculocliente ( id INT, cobranca INT, usuario INT)
	BEGIN
		DECLARE tipo INT;
        SET tipo=(SELECT id_plano FROM cliente 	WHERE id_cliente=id);
         
         IF tipo != 1 THEN
			INSERT INTO esveiculos(id_cliente, id_tipoveiculo, id_cobranca, placa, marcamodelo, telefone, dhentrada, id_usuario)
				VALUES	(id, (SELECT id_tipoveiculo FROM cliente WHERE id_cliente=id), 3 , (SELECT placa FROM cliente WHERE id_cliente=id), 
				(SELECT marcamodelo FROM cliente WHERE id_cliente=id), (SELECT telefonecliente FROM cliente WHERE id_cliente=id), CURRENT_TIMESTAMP(), usuario);
		ELSE
			INSERT INTO esveiculos(id_cliente, id_tipoveiculo, id_cobranca, placa, marcamodelo, telefone, dhentrada, id_usuario)
				VALUES	(id, (SELECT id_tipoveiculo FROM cliente WHERE id_cliente=id), cobranca , (SELECT placa FROM cliente WHERE id_cliente=id), 
				(SELECT marcamodelo FROM cliente WHERE id_cliente=id), (SELECT telefonecliente FROM cliente WHERE id_cliente=id), CURRENT_TIMESTAMP(), usuario);
		END IF;
	
    END \\
DELIMITER ;

DELIMITER \\
CREATE PROCEDURE sp_saidaveiculo(identifica int)
	BEGIN
		UPDATE esveiculos
			SET dhsaida= (CURRENT_TIMESTAMP)
            WHERE id_estacionamento = identifica;
	END \\
DELIMITER ;

DELIMITER \\
CREATE PROCEDURE sp_addcliente(cliente VARCHAR(30), documento VARCHAR(14), telefone VARCHAR(12), placa VARCHAR(7), 
veiculo VARCHAR(30), tipo INT, plano INT, diapagamento INT)
	BEGIN
		INSERT INTO cliente (cliente, cpfcnpj, telefonecliente, placa, marcamodelo, id_tipoveiculo, id_plano, diapagamento)
			VALUES	(cliente, documento, telefone, placa, veiculo, tipo, plano, diapagamento);
	END \\
DELIMITER ;

DELIMITER \\
CREATE PROCEDURE sp_editacliente(id INT, cliente VARCHAR(30), documento VARCHAR(14), telefone VARCHAR(12), plca VARCHAR(7), veiculo VARCHAR(30), tipo INT , plano INT, dia INT)
	BEGIN
		
        UPDATE cliente
			SET cliente = cliente, cpfcnpj = documento, telefonecliente = telefone, placa = plca, marcamodelo = veiculo, id_tipoveiculo = tipo, id_plano = plano, diapagamento = dia 
            WHERE id_cliente = id;
            
	END \\
DELIMITER ;

DELIMITER \\
CREATE PROCEDURE sp_pagamentocliente(cliente INT)
	BEGIN
		
        DECLARE plano INT;
        SET plano = (SELECT id_plano FROM cliente WHERE id_cliente = cliente);
        
        IF plano != 1 THEN
        INSERT INTO pagamento(id_cliente, tipocobranca, valor, datapagamento)
			VALUES	(cliente, 'Mensalidade', (SELECT valorplano FROM plano WHERE id_plano = plano), CURRENT_DATE());
		END IF;
	END \\
DELIMITER ;

DELIMITER \\
CREATE PROCEDURE sp_addusuario (idstatus INT, nome VARCHAR(30), login VARCHAR(15), senha VARCHAR(10))
	BEGIN
        INSERT INTO usuario(id_status, nome, login, senha)
			VALUES	(idstatus, nome, login, senha);
	END \\
DELIMITER ;

DELIMITER \\
CREATE PROCEDURE sp_editausuario (id int, idstatus INT, nome VARCHAR(30), login VARCHAR(15), senha VARCHAR(10))
	BEGIN
        UPDATE usuario
			SET id_status = idstatus, nome = nome, login = login, senha = senha
            WHERE id_usuario = id;
	END \\
DELIMITER ;

DELIMITER \\ 
CREATE PROCEDURE sp_editatipoveiculo (id INT, vlhora FLOAT(10,2), vlmin FLOAT(10,2), vldia FLOAT(10,2), vaga INT)
	BEGIN
		
        DECLARE vagadisp INT;
        SET vagadisp=((SELECT vagastotais FROM tipoveiculo WHERE id_tipoveiculo = id) - 
            (SELECT vagasdisponiveis FROM tipoveiculo WHERE id_tipoveiculo = id));
        
        UPDATE tipoveiculo
			SET valorhora = vlhora, valorminuto = vlmin, valordiaria = vldia, vagastotais = vaga, 
            vagasdisponiveis = (vaga - vagadisp)
            WHERE id_tipoveiculo = id;
	
	END \\
DELIMITER ;


DELIMITER \\ 
CREATE PROCEDURE sp_editaplano (id INT, valor FLOAT(10,2))
	BEGIN
		
        UPDATE plano
			SET valorplano = valor
            WHERE id_plano = id;
	
	END \\
DELIMITER ;

DELIMITER \\
CREATE TRIGGER tg_calculatempovalor
	AFTER UPDATE ON esveiculos
    FOR EACH ROW
		BEGIN
        
			DECLARE id INT;
            DECLARE idcli INT;
            DECLARE cobranca INT;
            DECLARE veiculo INT;
            DECLARE de datetime;
            DECLARE ds datetime;
            DECLARE tempo INT;
				SET id = (SELECT id_estacionamento FROM esveiculos WHERE dhsaida = NEW.dhsaida);
                SET idcli = (SELECT id_cliente FROM esveiculos WHERE dhsaida = NEW.dhsaida);
                SET cobranca= (SELECT id_cobranca FROM esveiculos WHERE dhsaida = NEW.dhsaida);
                SET veiculo= (SELECT id_tipoveiculo FROM esveiculos WHERE dhsaida = NEW.dhsaida);
				SET de = (SELECT dhentrada FROM esveiculos WHERE dhsaida = NEW.dhsaida);
				SET ds = (SELECT dhsaida FROM esveiculos WHERE dhsaida = NEW.dhsaida);
                SET tempo = TIMESTAMPDIFF(MINUTE, de ,ds);
            
            IF cobranca = 1 THEN
				IF tempo < 60 THEN
					INSERT INTO pagamento(id_estacionamento, id_cliente, tipocobranca, tempototal, valor, datapagamento)
						VALUES	(id, idcli, 'Tempo', tempo, (SELECT valorhora FROM tipoveiculo WHERE id_tipoveiculo = veiculo), CURRENT_DATE());
				ELSE 
					INSERT INTO pagamento(id_estacionamento, id_cliente, tipocobranca, tempototal, valor, datapagamento)
						VALUES	(id, idcli, 'Tempo', tempo, (((tempo - 60) * (SELECT valorminuto FROM tipoveiculo WHERE id_tipoveiculo = veiculo)) + 
						(SELECT valorhora FROM tipoveiculo WHERE id_tipoveiculo = veiculo)), CURRENT_DATE());
				END IF;
	
			ELSEIF cobranca = 2 THEN
					INSERT INTO pagamento(id_estacionamento, id_cliente, tipocobranca, valor, datapagamento)
						VALUES	(id, idcli, 'Diaria', (SELECT valordiaria FROM tipoveiculo WHERE id_tipoveiculo = veiculo), CURRENT_DATE());
		
			END IF;
		END \\
DELIMITER ;
				
DELIMITER \\
CREATE TRIGGER tg_subtraivaga
	AFTER INSERT ON esveiculos
    FOR EACH ROW
		BEGIN
			
            DECLARE tipo INT;
            SET tipo= (SELECT id_tipoveiculo FROM esveiculos WHERE id_estacionamento= NEW.id_estacionamento);
            
            UPDATE tipoveiculo
				SET vagasdisponiveis = (vagasdisponiveis - 1)
                WHERE id_tipoveiculo=tipo;
                
		END \\
DELIMITER ;
            
DELIMITER \\
CREATE TRIGGER tg_somavaga
	AFTER UPDATE ON esveiculos
    FOR EACH ROW
		BEGIN
			
            DECLARE tipo INT;
            SET tipo= (SELECT id_tipoveiculo FROM esveiculos WHERE dhsaida= NEW.dhsaida);
            
            UPDATE tipoveiculo
				SET vagasdisponiveis = (vagasdisponiveis + 1)
                WHERE id_tipoveiculo=tipo;
                
		END \\
DELIMITER ;	