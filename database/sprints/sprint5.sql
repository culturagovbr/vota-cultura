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
