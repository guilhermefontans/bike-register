
### Descrição

Este projeto consiste em fornecer uma API de cadastro de bicicletas na qual pode ser utilizada como um microserviço que
pode ser chamado  para efetuar todas operações básicas de cadastro através de sua implementação rest, nas quais são `GET, POST, PUT, DELETE e PATCH`

O desenvolvimento desse projeto foi efetuado em cima do skeleton do framework [Slim](https://www.slimframework.com/), o mesmo foi escolhido por
se tratar de um framework simples e sem muitas dependências, no qual atende muito bem os requisitos impostos.
O framework escolhido também respeita as recomendações de padronização feitas pela [comunidade PHP](https://www.php-fig.org/)
através de suas [PSRs](https://www.php-fig.org/psr), o que facilita a utilização de componentes feitos pela comunidade de desenvolvedores.

#### Estrutura
A estrutura de pastas que estão dentro da pasta `src` mantém as camadas separadas, facilitando o entendimento do que cada uma é responsável:
```
- Application: Este módulo é o resposável por manter os arquivos que irão tratar a comunicação com o usuário, como
middlewares que podem ser adicionados na applicação, tratamento de respostas e handlers. Além disso, em sua sub-pasta chamada `Actions/Bike`, possui
um arquivo que trata cada rota definida para o serviço.

- Domain: Essa pasta é responsável por isolar as regras específicas para o serviço, como entidades, validação, e exceções personalizadas.

- Infraestructure: Essa camada é a responsável por tratar as configurações externas, como a persistência e consulta dos registros na base de dados.
A camada de acesso a base de dados também faz uso de uma camada de cache local de arquivos, diminuindo a ida até a base para consultar um item já salvo previamente no cache
```

Com essa estrutura então quando o usuário faz uma chamada para um endpoint são efetuados as seguintes operações pelo sistema:
1. Identificação de qual action que trata aquela url;
2. Chamada das camadas de Dominio para tratar as regras e validar os dados;
3. Se for uma operação GET que está em cache carrega o objeto do cache, se não tiver em cache busca no banco.;
4. Se for uma operação de persistência, salva/atualiza os dados e retorna as informações necessárias;
5. Camada application monta o retorno para o usuário. 

#### Pré requisitos para ambiente de desenvolvimento
Para a instalação em ambiente local, foi utilizado Docker e Docker Compose pela facilidade de execução em ambientes UNIX.
* Ter o [Docker](https://docs.docker.com/install/linux/docker-ce/debian/) na máquina que irá subir o projeto.
* Ter o [Docker Compose](https://docs.docker.com/compose/install/) na máquina que irá subir o projeto.
* Por default o container irá utilizar a porta 8000 da máquina aonde o projeto irá rodar, então é necessário que está porta esteja liberada.  

#### Instalação
Tendo os pré-requisitos preenchidos, para a instalação é necessário seguir os seguintes passos:

1. Fazer uma cópia do arquivo .env.dist para .env na raiz do projeto
```sh
$ cp .env.dist .env
``` 
2. Rodar o comando abaixo para subir os containers necessários: 
```sh
$ docker-compose up -d
```
3. Rodar o comando abaixo para instalar as dependências do projeto: 
```sh
$ docker run  --rm  --volume $PWD:/app --user $(id -u):$(id -g)   composer install --ignore-platform-reqs
```
4. Importar o dump da base de dados
```
$ docker-compose exec -T db mysql  -pesales   < dumps/InitDB.sql
```
 
Após efetuar esses passos, acessar o seguinte endereço em seu navegador: http://localhost:8000
 
 
#### Rotas disponíveis:

A aplicação possúi os seguintes endpoints

```
1. GET http://localhost:8000/bikes - Lista todas as bikes 

2. GET http://localhost:8000/bikes/{id} - Lista a bike com o id informado na url

3. POST http://localhost:8000/bikes - Cria uma nova bike com os dados passados no corpo da requisição

3. PUT http://localhost:8000/bikes/{id} - Atualiza todos os dados passados no corpo da requisição na bike que o id foi inormado na url

4. DELETE http://localhost:8000/bikes/{id} - Deleta a bike informada na url

5. PATCH http://localhost:8000/bikes/{id} - Atualiza um ou mais campos com os dados passados no corpo da requisição
 ```

##### Exemplos

Abaixo o exemplo das chamadas utilizando o curl através de um terminal Linux:

 
* Criar uma bike<br> 
 Envio
```bash
$  curl -X POST http://localhost:8000/bikes -d '{"descricao": "uma bike", "modelo": "caloi", "preco": 1000, "data-compra": "2020-10-22", "nome-comprador": "Guilherme", "nome-loja": "loja de bike"}'
```
Retorno
```
{
    "statusCode": 201,
    "data": {
        "id": 1,
        "descricao": "uma bike",
        "modelo": "caloi",
        "preco": 1000,
        "data-compra": "2020-10-22",
        "nome-comprador": "Guilherme",
        "nome-loja": "loja de bike"
    }
}
 ```

* Consultar todas bikes <br> 
 Envio
```bash
$  curl -X GET http://localhost:8000/bikes
```
Retorno
```
{
    "statusCode": 200,
    "data": [
        {
            "id": "1",
            "description": "umesmabike",
            "model": "caloi",
            "price": "1000",
            "purchase_date": "2020-10-22 21:58:11",
            "buyer_name": "Guilherme",
            "store_name": "loja de biike"
        },
        {
            "id": "2",
            "description": "outra bike",
            "model": "caloi",
            "price": "500",
            "purchase_date": "2020-10-20 00:00:00",
            "buyer_name": "Guilherme",
            "store_name": "outra loja de bike"
        }
    ]
}
 ```


* Atualizar apenas um campo de uma bike, essa operação retorna o código 204 sem corpo na resposta<br> 
 Envio
```bash
$  curl -X PATCH http://localhost:8000/bikes/1 -d '{"preco": 1500}'
```
* Consultar todas bikes <br> 
 Envio
```bash
$  curl -X GET http://localhost:8000/bikes/1
```
Retorno
```
{
    "statusCode": 200,
    "data": {
        "id": 1,
        "descricao": "umesmabike",
        "modelo": "caloi",
        "preco": 1000,
        "data-compra": "2020-10-22",
        "nome-comprador": "Guilherme",
        "nome-loja": "loja de biike"
    }
}
 ```
* Atualizar uma bike<br> 
 Envio
```bash
$  curl -X PUT http://localhost:8000/bikes/1 -d '{"descricao": "uma bike", "modelo": "caloi", "preco": 1100, "data-compra": "2020-10-21", "nome-comprador": "Guilherme", "nome-loja": "loja de bike"}'
```
Retorno
```
{
    "statusCode": 200,
    "data": {
        "id": 1,
        "descricao": "uma bike",
        "modelo": "caloi",
        "preco": 1100,
        "data-compra": "2020-10-21",
        "nome-comprador": "Guilherme",
        "nome-loja": "loja de bike"
    }
}
 ```
* Deleta uma bike, essa operação retorna o código 204 sem corpo na resposta<br> 
 Envio
```bash
$  curl -X DELETE http://localhost:8000/bikes/1
```

#### Informações extras

Executando os testes:
```
docker-compose run --rm slim /var/www/vendor/bin/phpunit
```

Visualizando os logs

```
docker-compose logs -f slim
```
