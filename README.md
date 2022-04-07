<p align="center">
<img src="https://user-images.githubusercontent.com/88275533/162101242-a67eeb4a-ce27-48db-a868-570d9727d9d3.png" alt="mcquery">
</p>

<!-- <p align="center">
<a href="https://travis-ci.org/haleydev/mcquery"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/haleydev/mcquery"><img src="https://img.shields.io/packagist/dt/haleydev/mcquery" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/haleydev/mcquery"><img src="https://img.shields.io/packagist/v/haleydev/mcquery" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/haleydev/mcquery"><img src="https://img.shields.io/packagist/l/haleydev/mcquery" alt="License"></a>
</p> -->

## Sobre o mcquery
O MCQUERY foi feito com a intenção de ser um framework que não dependa de outras bibliotecas ou frameworks para funcionar, sendo a única biblioteca utilizada por padrão no mcquery e o PHPMailer sendo essencial para envio de emails com o PHP, mas é claro sinta-se a vontade para instalar quantas dependências forem necessárias para seu projeto, confira a baixo a documentação desse maravilhoso projeto:

- [Comandos via terminal](#comandos-via-terminal)
- [Variáveis de ambiente](#variáveis-de-ambiente)
- [Router o básico](#router)
    - [Metodo URL](#url---este-metodo-não-permite-que-a-rota-tenha-parâmetros)
    - [Metodo GET](#get---este-metodo-permite-que-a-rota-tenha-parâmetros)
    - [Metodo POST](#post---para-utilizar-o-metodo-post-e-necessário-ter-um-token-de-segurança-em-seus-formulários)
    - [Metodo AJAX](#ajax---ao-contrario-do-metodo-post-o-metodo-ajax-não-atualiza-o-token-de-segurança-a-cada-requisição-mas-ainda-e-necessário-utilizar-o-token-de-segurança-em-seus-formulários)
    - [Metodo API](#api---metodo-dedicado-a-apis-seu-header-cabeçalho-ja-vem-com-content-typeapplicationjson)
- [Controllers](#controllers)
- [Models e conexão](#models-e-conexão)
## Comandos via terminal
![mcquery terminal](https://user-images.githubusercontent.com/88275533/162103945-9826d12d-e9bd-4bfd-bd45-061acff4740c.png)
- **php mcquery config** cria o arquivo de configurações (config.ini) e instala dependências
- **php mcquery controller:Nome** cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta
- **php mcquery model:Nome** cria um novo model
- **php mcquery conexao** testa a conexão com o banco de dados
- **php mcquery autoload** atualiza o autoload de classes
## Variáveis de ambiente

Para iniciar esse projeto, você vai precisar rodar "php mcquery config" no terminal e configurar as variáveis de ambiente, caso não for utilizar o PHPMailer ou banco de dados, os campos podem ficar em branco.
## Router


Não é obrigatório nomear as rotas, mas é muito útil se você quiser obter a url completa da rota utilizando a função: router('nome');

Para passar parâmetros dinâmicos na url coloque entre chaves exemplo "post/{post}/{id}" em router, e para pegar esse valor utilize a função get('post') , get('id') que ira retornar o valor que esta na url.

Caso queira pegar uma url completa que contém parâmetros utilize router('post', 'php,15') separando os parâmetros a serem substituidos por ",".



Você pode chamar um arquivo diretamente, exemplo:
```php
$app->url("post", "./Templates/views/post.php")->name('post');
```
ou chamar uma classe ou função, exemplo:
```php
$app->post("post", function(){ 
    echo 'HELO WORD';
    view('post');
})->name('post');
```

### URL - Este metodo não permite que a rota tenha parâmetros

Exemplo invalido: www.example.com/blog?p=414906

Exemplo valido: www.example.com/blog
```php
$app->url("blog", function(){ 
    (new BlogController)->render();
})->name('blog');
```

### GET - Este metodo permite que a rota tenha parâmetros

Exemplo valido: www.example.com/blog?p=414906

```php
$app->get("blog", function(){ 
    (new BlogController)->render();
})->name('blog');
```

### POST - Para utilizar o metodo POST e necessário ter um token de segurança em seus formulários

Função do mcquery: validate()

Exemplo:
```php
$app->post("post", function(){ 
    (new PostController)->render();
})->name('post');
```

```php
<form method="POST" action="<?=router('post')?>">
    <?=validate()?>
    <input type="text" name="email" placeholder="email">
    <input type="text" name="senha" placeholder="senha">
    <input type="submit" value="entrar">
</form>
```
O HTML ficará assim:
```html
<form method="POST" action="http://localhost/post">
    <input type='hidden' name='token' value='2b32ee40f6ceaa69a91b39abc62c5ccf'/>
    <input type="text" name="email" placeholder="email">
    <input type="text" name="senha" placeholder="senha">
    <input type="submit" value="entrar">
</form> 
```

### AJAX - Ao contrario do metodo POST o metodo AJAX não atualiza o token de segurança a cada requisição, mas ainda e necessário utilizar o token de segurança em seus formulários
Lembrando que este metodo AJAX é via POST.

Exemplo:
```php
$app->ajax("search", function(){ 
     (new AjaxController)->pesquisa();
})->name('search');
```

### API - Metodo dedicado a APIs, seu header (cabeçalho) ja vem com "Content-Type:application/json"
Os metodos aceitos nas rotas de APIs podem ser varios separados por ",".

Exemplo:
```php
$app->api("api/genero/{genero}", function(){
     (new ApiController)->genero();
},"get,post")->name('api.genero');
```
## Controllers
O mcquery agiliza a criação de controllers com o comando ( php mcquery controller:NomeController ) caso queira adionar o controller a uma sub pastas basta adicionar "/" , ( php mcquery controller:Pasta/OutraPasta/NomeController ) o resultado será:

```php
namespace Controllers\Pasta\OutraPasta;
use App\Controller;

class NomeController extends Controller
{        
    public $title = "NomeController";
    public $view = "";    

    public function render(){
        $this->layout("main");         
    }
}
```
Para adiocionar um layout,view ou include em um controller utilize as seguintes funções do controller:
- $this->layout('nome-do-layout')
- $this->view('nome-da-view')
- $this->include('nome-do-include')

Lembrando que estes arquivos devem estar na pasta Templates.

Também e possivel acessar o banco de dados diretamenta no controller dessa forma 'mas é recomendável utilizar as Models':
```php
// e possivel criar varias querys desta forma:
$this->query([
    "SELECT * FROM filmes ORDER BY id DESC limit 10",
    "SELECT * FROM animes ORDER BY id DESC limit 30"
]); 

$this->total[0] // imprime 10
$this->total[1] // imprime 30

// $this->data pode ser acessada na view,layout ou include se forem adicionados abaixo da query
// acessando os resultados com $this->data :

foreach($this->data[0] as $result){
echo 
    $result['titulo']."-".
    $result['descricao']."<br>";       
}   
```

## Models e conexão
Um model pode ser criado com o comando ( php mcquery model:NomeModel )

Para ajudar o mcquery cria as models com alguma funções, que podem ser alteradas de acordo com as suas necessidades:

- select
- insert
- update
- delete

Lembrando que o banco de dados deve estar devidamente configurado em config.ini

Você pode acessar o banco de dados diretamente dessa forma:

```php
use App\Conexao;
$conexao = new Conexao;
$conexao->pdo(); // ou $conexao->mysqli();
$conexao->conect; // para conectar
$conexao->close(); // para fechar a conexao
```
