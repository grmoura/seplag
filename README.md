# Documentação da SEPLAG API

## Introdução
Esta é a documentação da API desenvolvida em Laravel, utilizando Nginx, MinIO e PostgreSQL.

## Dados de Inscrição
- Nome: Gabriel Rodrigues de Moura
- Inscrições: 10215 ( Full Stack Pleno) ,
              10243 ( Desenvolvedor PHP Pleno ),
              10227 ( Desenvolvedor PHP Junior )
- E-mail: grmoura18@hotmail.com

## Requisitos
- Docker
- Docker Compose
- Postman

## Tecnologias Utilizadas
- PHP 8+
- Laravel 12+
- Docker + Docker Compose
- PostgreSQL
- MinIO (para armazenamento de fotos)

## Instalação e Configuração

1. Clone o repositório
    ```sh
   git clone <URL_DO_REPOSITORIO>
    cd <NOME_DA_PASTA>
   ```
3. Suba os containers com o comando:
   ```sh
   docker-compose up --build
   ```
4. Configure o host no arquivo `hosts` do seu sistema para visualizar corretamente as imagens armazenadas no MinIO.
   
   - **Windows**:
     1. Abra o Bloco de Notas como Administrador.
     2. Edite o arquivo localizado em: `C:\Windows\System32\drivers\etc\hosts`
     3. Adicione a seguinte linha ao final do arquivo:
        ```sh
        127.0.0.1     minio
        ```
     4. Salve e feche o arquivo.
   
   - **Linux**:
     1. Edite o arquivo `hosts` com o seguinte comando:
        ```sh
        sudo nano /etc/hosts
        ```
     2. Adicione a seguinte linha ao final do arquivo:
        ```sh
        127.0.0.1     minio
        ```
     3. Salve e feche o editor (CTRL+X, Y, ENTER).

## Endpoints Principais

### Registro de Usuário

```sh
curl --location 'http://localhost:8000/api/registrar' \
--header 'Accept: application/json' \
--form 'name="GABRIEL"' \
--form 'email="grmoura18@hotmail.com"' \
--form 'password="123123"'
```

### Login

```sh
curl --location 'http://localhost:8000/api/login' \
--header 'Accept: application/json' \
--form 'email="grmoura18@hotmail.com"' \
--form 'password="123123"'
```

### Refresh Token

```sh
curl --location --request POST 'http://localhost:8000/api/refresh' \
--header 'Accept: application/json'
```

## Documentação Completa
A documentação completa da API pode ser acessada no link abaixo:

[Documentação Postman](https://documenter.getpostman.com/view/19098399/2sB2cUCPGn)

Além disso, a collection do Postman está disponível no repositório com o nome:

`seplag_colletion_postman.json`

Como baixar e importar a collection no Postman:

1.Baixar o Postman (caso ainda não tenha instalado):

    Acesse o site oficial do Postman: https://www.postman.com/downloads/

    Escolha a versão compatível com seu sistema operacional e instale.

2.Baixar a Collection:

    Acesse o repositório onde o arquivo `seplag_colletion_postman.json` está disponível.

    Faça o download do arquivo para seu computador.

3.Importar no Postman:

    Abra o Postman.

    No canto superior esquerdo, clique em Import.

    Selecione a aba File e clique em Upload Files.

    Escolha o arquivo `seplag_colletion_postman.json` que você baixou.

    Clique em Import.

