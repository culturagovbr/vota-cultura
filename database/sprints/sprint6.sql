
-- Tabela de votação dos indicados
CREATE TABLE public.tb_conselho_votacao
(
    co_conselho_votacao serial PRIMARY KEY NOT NULL,
    dh_voto timestamp DEFAULT now() NOT NULL,
    co_eleitor int NOT NULL,
    co_conselho_indicacao int NOT NULL,
    CONSTRAINT fk_conselho_votacao_indicacao FOREIGN KEY (co_conselho_indicacao) REFERENCES public.tb_conselho_indicacao (co_conselho_indicacao),
    CONSTRAINT tb_conselho_votacao_eleitor FOREIGN KEY (co_eleitor) REFERENCES public.tb_eleitor (co_eleitor)
);
CREATE UNIQUE INDEX tb_conselho_votacao_co_conselho_votacao_uindex ON public.tb_conselho_votacao (co_conselho_votacao);
CREATE UNIQUE INDEX tb_conselho_votacao_co_eleitor_uindex ON public.tb_conselho_votacao (co_eleitor);
COMMENT ON COLUMN public.tb_conselho_votacao.co_conselho_votacao IS 'chave primária da tabela';
COMMENT ON COLUMN public.tb_conselho_votacao.co_eleitor IS 'eleitor do voto';
COMMENT ON COLUMN public.tb_conselho_votacao.co_conselho_indicacao IS 'indicado que recebeu o voto';
COMMENT ON TABLE public.tb_conselho_votacao IS 'tabela de registro de votos dos indicados';