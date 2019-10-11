-- Drop table

-- DROP TABLE public.tb_conselho_indicacao;

CREATE TABLE public.tb_conselho_indicacao (
                                              co_conselho_indicacao serial NOT NULL,
                                              nu_cpf_indicado varchar(11) NOT NULL, -- Número do CPF do indicado.
                                              no_indicado text NOT NULL, -- Nome do indicado.
                                              co_endereco int4 NOT NULL, -- Código referente ao endereço do indicado.
                                              co_conselho int4 NOT NULL, -- Código do conselho.
                                              dh_indicacao timestamp NOT NULL DEFAULT now(), -- Data da indicação.
                                              ds_curriculo varchar(1000) NULL, -- Currículo do indicado pelo conselho.
                                              co_arquivo int4 NULL, -- Código do arquivo da foto do indicado, referente à tabela tb_arquivo
                                              dt_nascimento_indicado date NOT NULL, -- Data de nascimento do indicado
                                              CONSTRAINT pk_conselho_indicacao PRIMARY KEY (co_conselho_indicacao),
                                              CONSTRAINT uk_conselho_indicacao UNIQUE (nu_cpf_indicado, co_conselho),
                                              CONSTRAINT fk_conselho_indicacao_arquivo FOREIGN KEY (co_arquivo) REFERENCES tb_arquivo(co_arquivo),
                                              CONSTRAINT fk_conselho_indicacao_endereco FOREIGN KEY (co_endereco) REFERENCES tb_endereco(co_endereco)
);

-- Column comments

COMMENT ON COLUMN public.tb_conselho_indicacao.nu_cpf_indicado IS 'Número do CPF do indicado.';
COMMENT ON COLUMN public.tb_conselho_indicacao.no_indicado IS 'Nome do indicado.';
COMMENT ON COLUMN public.tb_conselho_indicacao.co_endereco IS 'Código referente ao endereço do indicado.';
COMMENT ON COLUMN public.tb_conselho_indicacao.co_conselho IS 'Código do conselho.';
COMMENT ON COLUMN public.tb_conselho_indicacao.dh_indicacao IS 'Data da indicação.';
COMMENT ON COLUMN public.tb_conselho_indicacao.ds_curriculo IS 'Currículo do indicado pelo conselho.';
COMMENT ON COLUMN public.tb_conselho_indicacao.co_arquivo IS 'Código do arquivo da foto do indicado, referente à tabela tb_arquivo';
COMMENT ON COLUMN public.tb_conselho_indicacao.dt_nascimento_indicado IS 'Data de nascimento do indicado';

-- Permissions

ALTER TABLE public.tb_conselho_indicacao OWNER TO votacultura;
GRANT ALL ON TABLE public.tb_conselho_indicacao TO votacultura;

--#############
ALTER TABLE public.tb_conselho RENAME COLUMN st_inscricao TO st_indicacao;
ALTER TABLE public.tb_conselho ALTER COLUMN st_indicacao SET DEFAULT 'a';
COMMENT ON COLUMN public.tb_conselho.st_indicacao IS 'situação em que se encontra o período de indicados do conselho. Possíveis opções: a = aberto, f = fechado';

