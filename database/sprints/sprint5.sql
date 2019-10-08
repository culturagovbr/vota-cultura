CREATE TABLE public.tb_conselho_indicacao (
	co_conselho_indicacao serial NOT NULL,
	nu_cpf_indicado varchar(11) NOT NULL,
	no_indicado text NOT NULL,
	co_endereco integer NOT NULL,
	co_conselho integer NOT NULL,
	dh_indicacao timestamp NOT NULL,
	CONSTRAINT "pk_conselho_indicacao" PRIMARY KEY (co_conselho_indicacao),
	CONSTRAINT uk_conselho_indicacao UNIQUE (nu_cpf_indicado,co_conselho),
	CONSTRAINT fk_conselho_indicacao_endereco FOREIGN KEY (co_endereco) REFERENCES public.tb_endereco(co_endereco)
);

-- Column comments

ALTER TABLE public.tb_conselho_indicacao ALTER COLUMN dh_indicacao SET DEFAULT NOW();

COMMENT ON COLUMN public.tb_conselho_indicacao.co_conselho_indicacao IS 'Chave primária da tabela.';
COMMENT ON COLUMN public.tb_conselho_indicacao.nu_cpf_indicado IS 'Número do CPF do indicado.';
COMMENT ON COLUMN public.tb_conselho_indicacao.no_indicado IS 'Nome do indicado.';
COMMENT ON COLUMN public.tb_conselho_indicacao.co_endereco IS 'Código referente ao endereço do indicado.';
COMMENT ON COLUMN public.tb_conselho_indicacao.co_conselho IS 'Código do conselho.';
COMMENT ON COLUMN public.tb_conselho_indicacao.dh_indicacao IS 'Data da indicação.';
