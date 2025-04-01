# Documentação da API

## Introdução
Esta é a documentação da API desenvolvida em Laravel, utilizando Nginx, MinIO e PostgreSQL.

## Requisitos
- Docker
- Docker Compose

## Instalação e Configuração

1. Clone o repositório
2. Suba os containers com o comando:
   ```sh
   docker-compose up --build
   ```
3. Execute as migrações do banco de dados:
   ```sh
   docker exec -it app php artisan migrate
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

[Documentação Postman](https://documenter.getpostman.com/view/19098399/2sB2cPk6FY)

Além disso, a collection do Postman está disponível no repositório com o nome:

`seplag_colletion_postman.json`

Se precisar de mais informações ou ajustes, entre em contato!

