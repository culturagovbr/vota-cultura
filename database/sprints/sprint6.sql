CREATE TABLE public.tb_organizacao_indicacao
(
    co_organizacao_indicacao serial        NOT NULL,
    co_organizacao           int           NOT NULL,
    nu_cpf_indicado          varchar(11)   NOT NULL,
    no_indicado              text          NOT NULL,
    tp_indicado              char(1)       NOT NULL,
    dt_nascimento_indicado   date          NOT NULL,
    ds_curriculo             varchar(1000) NOT NULL,
    CONSTRAINT tb_organizacao_indicacao_pk PRIMARY KEY (co_organizacao_indicacao),
    CONSTRAINT organizacao_indicacao_cpf_uk UNIQUE (nu_cpf_indicado),
    CONSTRAINT organizacao_indicacao_organizacao_fk FOREIGN KEY (co_organizacao) REFERENCES public.tb_organizacao (co_organizacao)
);

-- Column comments

COMMENT ON COLUMN public.tb_organizacao_indicacao.co_organizacao_indicacao IS 'Identificador da indicação. Chave primária da tabela.';
COMMENT ON COLUMN public.tb_organizacao_indicacao.co_organizacao IS 'Código da organização.';
COMMENT ON COLUMN public.tb_organizacao_indicacao.nu_cpf_indicado IS 'CPF do indicado pela organização.';
COMMENT ON COLUMN public.tb_organizacao_indicacao.no_indicado IS 'Nome do indicado pela organização.';
COMMENT ON COLUMN public.tb_organizacao_indicacao.tp_indicado IS 'Tipo do indicado. t = Titular, s = Suplente';
COMMENT ON COLUMN public.tb_organizacao_indicacao.dt_nascimento_indicado IS 'Data de nascimento do indicado.';

insert into tb_fase
    (co_fase, tp_fase, dh_inicio, dh_fim, ds_detalhamento)
values (6,
        'abertura_inscricoes_indicados_organizacao',
        '2019-11-20 18:00:00',
        '2066-12-30 18:00:00',
        'Pelos poderes de Felix, Garfield e Tom...');


