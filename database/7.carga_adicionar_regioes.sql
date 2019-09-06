ALTER TABLE tb_uf ADD co_regiao int NULL;

UPDATE tb_uf SET co_regiao = 1 WHERE co_ibge = 12;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 27;
UPDATE tb_uf SET co_regiao = 1 WHERE co_ibge = 16;
UPDATE tb_uf SET co_regiao = 1 WHERE co_ibge = 13;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 29;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 23;
UPDATE tb_uf SET co_regiao = 5 WHERE co_ibge = 53;
UPDATE tb_uf SET co_regiao = 3 WHERE co_ibge = 32;
UPDATE tb_uf SET co_regiao = 5 WHERE co_ibge = 52;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 21;
UPDATE tb_uf SET co_regiao = 5 WHERE co_ibge = 51;
UPDATE tb_uf SET co_regiao = 5 WHERE co_ibge = 50;
UPDATE tb_uf SET co_regiao = 3 WHERE co_ibge = 31;
UPDATE tb_uf SET co_regiao = 1 WHERE co_ibge = 15;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 25;
UPDATE tb_uf SET co_regiao = 4 WHERE co_ibge = 41;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 26;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 22;
UPDATE tb_uf SET co_regiao = 3 WHERE co_ibge = 33;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 24;
UPDATE tb_uf SET co_regiao = 4 WHERE co_ibge = 43;
UPDATE tb_uf SET co_regiao = 1 WHERE co_ibge = 11;
UPDATE tb_uf SET co_regiao = 1 WHERE co_ibge = 14;
UPDATE tb_uf SET co_regiao = 4 WHERE co_ibge = 42;
UPDATE tb_uf SET co_regiao = 3 WHERE co_ibge = 35;
UPDATE tb_uf SET co_regiao = 2 WHERE co_ibge = 28;
UPDATE tb_uf SET co_regiao = 1 WHERE co_ibge = 17;

ALTER TABLE tb_uf ALTER COLUMN co_regiao SET NOT NULL;

CREATE TABLE tb_regiao (
  co_regiao 	INT NOT NULL,
  no_regiao 	VARCHAR(100) NOT NULL,
	CONSTRAINT pk_regiao_coregiao PRIMARY KEY ( co_regiao )
);

INSERT INTO tb_regiao (co_regiao, no_regiao) VALUES (1, 'Norte');
INSERT INTO tb_regiao (co_regiao, no_regiao) VALUES (2, 'Nordeste');
INSERT INTO tb_regiao (co_regiao, no_regiao) VALUES (3, 'Sudeste');
INSERT INTO tb_regiao (co_regiao, no_regiao) VALUES (4, 'Sul');
INSERT INTO tb_regiao (co_regiao, no_regiao) VALUES (5, 'Centro-Oeste');

  ALTER TABLE public.tb_uf
    ADD CONSTRAINT tb_uf_tb_regiao_co_regiao_fk
FOREIGN KEY (co_regiao) REFERENCES public.tb_regiao (co_regiao);
