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

ALTER TABLE public.tb_endereco ALTER COLUMN nu_cep DROP NOT NULL;
ALTER TABLE public.tb_endereco ALTER COLUMN ds_logradouro DROP NOT NULL;

--#############
ALTER TABLE public.tb_conselho RENAME COLUMN st_inscricao TO st_indicacao;
ALTER TABLE public.tb_conselho ALTER COLUMN st_indicacao SET DEFAULT 'a';
COMMENT ON COLUMN public.tb_conselho.st_indicacao IS 'situação em que se encontra o período de indicados do conselho. Possíveis opções: a = aberto, f = fechado';

--#############

-- Drop table

-- DROP TABLE public.rl_conselho_indicacao_arquivo;

CREATE TABLE public.rl_conselho_indicacao_arquivo (
	co_conselho_indicacao_arquivo serial NOT NULL, -- chave primária da tabela
	co_conselho_indicacao int4 NOT NULL, -- chave estrangeira referente a tabela tb_conselho_indicacao
	co_arquivo int4 NOT NULL, -- chave estrangeira referente a tabela tb_arquivo
	tp_arquivo varchar(255) NOT NULL, -- tipo do arquivo com slug do módulo.
	CONSTRAINT pk_conselho_indicacao_arquivo PRIMARY KEY (co_conselho_indicacao_arquivo),
	CONSTRAINT fk_conselho_indicacao_arquivo_arquivo FOREIGN KEY (co_arquivo) REFERENCES tb_arquivo(co_arquivo) ON DELETE CASCADE,
	CONSTRAINT fk_conselho_indicacao_arquivo_conselho_indicacao FOREIGN KEY (co_conselho_indicacao) REFERENCES tb_conselho_indicacao(co_conselho_indicacao) ON DELETE CASCADE
);

-- Column comments

COMMENT ON COLUMN public.rl_conselho_indicacao_arquivo.co_conselho_indicacao_arquivo IS 'chave primária da tabela';
COMMENT ON COLUMN public.rl_conselho_indicacao_arquivo.co_conselho_indicacao IS 'chave estrangeira referente a tabela tb_conselho_indicacao';
COMMENT ON COLUMN public.rl_conselho_indicacao_arquivo.co_arquivo IS 'chave estrangeira referente a tabela tb_arquivo';
COMMENT ON COLUMN public.rl_conselho_indicacao_arquivo.tp_arquivo IS 'tipo do arquivo com slug do módulo.';

-- Permissions

ALTER TABLE public.rl_conselho_indicacao_arquivo OWNER TO votacultura;
GRANT ALL ON TABLE public.rl_conselho_indicacao_arquivo TO votacultura;

CREATE TABLE public.tb_organizacao_habilitacao_historico
(
    co_organizacao_habilitacao_historico serial PRIMARY KEY NOT NULL,
    co_organizacao_habilitacao int,
    co_organizacao int NOT NULL,
    st_avaliacao char(1) NOT NULL,
    ds_parecer text,
    dh_avaliacao timestamp DEFAULT current_timestamp,
    nu_nova_pontuacao int,
    CONSTRAINT tb_organizacao_habilitacao_historico_tb_organizacao_habilitacao_co_organizacao_habilitacao_fk FOREIGN KEY (co_organizacao_habilitacao) REFERENCES public.tb_organizacao_habilitacao (co_organizacao_habilitacao),
    CONSTRAINT tb_organizacao_habilitacao_historico_tb_organizacao_co_organizacao_fk FOREIGN KEY (co_organizacao) REFERENCES public.tb_organizacao (co_organizacao)
);

ALTER TABLE public.tb_organizacao_habilitacao ADD co_usuario_avaliador integer NULL;
ALTER TABLE public.tb_organizacao_habilitacao
ADD CONSTRAINT tb_organizacao_habilitacao_tb_usuario_co_usuario_fk
FOREIGN KEY (co_usuario_avaliador) REFERENCES public.tb_usuario (co_usuario);


ALTER TABLE public.tb_organizacao_habilitacao_historico ADD co_usuario_avaliador integer NULL;
ALTER TABLE public.tb_organizacao_habilitacao_historico
ADD CONSTRAINT tb_organizacao_habilitacao_historico_tb_usuario_co_usuario_fk
FOREIGN KEY (co_usuario_avaliador) REFERENCES public.tb_usuario (co_usuario);

ALTER TABLE public.tb_organizacao_habilitacao ADD st_revisao_final boolean NULL;
COMMENT ON COLUMN public.tb_organizacao_habilitacao.st_revisao_final IS 'null - Sem avaliação
false - Não é revisão final
true - Última revisão da habilitação';

ALTER TABLE public.tb_organizacao_habilitacao_historico ADD st_revisao_final boolean NULL;
COMMENT ON COLUMN public.tb_organizacao_habilitacao_historico.st_revisao_final IS 'null - Sem avaliação
false - Não é revisão final
true - Última revisão da habilitação';

UPDATE public.tb_conselho SET st_indicacao = 'a';

-- Column comments

COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.co_organizacao_habilitacao_recurso IS 'Chave primária da tabela';
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.co_organizacao IS 'Chave estrangeira referente a organização';
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.ds_recurso IS 'Descrição do recurso';
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.dh_cadastro_recurso IS 'Data de cadastro do recurso';

--################## Avaliação do recurso das organizações

ALTER TABLE public.tb_organizacao_habilitacao_recurso ADD ds_parecer text NULL;
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.ds_parecer IS 'Parecer do recurso';
ALTER TABLE public.tb_organizacao_habilitacao_recurso ADD st_parecer char(1) NULL;
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.st_parecer IS '0 - Inabilitada, 1 = habilitada e desclassificada, 2 habilitada e classificada';
ALTER TABLE public.tb_organizacao_habilitacao_recurso ADD st_avaliacao_final integer NOT NULL DEFAULT 0;
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.st_avaliacao_final IS 'Valida se o usuário selecionou o recurso como concluído.';
ALTER TABLE public.tb_organizacao_habilitacao_recurso ADD nu_pontuacao integer NULL;
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.nu_pontuacao IS 'Nova pontuação após avaliação do recurso.';
ALTER TABLE public.tb_organizacao_habilitacao_recurso ADD co_arquivo integer NULL;
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.co_arquivo IS 'Código do arquivo referente a tabela tb_arquivo.';
ALTER TABLE public.tb_organizacao_habilitacao_recurso ADD CONSTRAINT fk_organizacao_habilitacao_recurso_arquivo FOREIGN KEY (co_arquivo) REFERENCES public.tb_arquivo(co_arquivo);

