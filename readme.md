# Projeto teste de seleção

## Instruções instalação

* git clone https://github.com/juliodlima/api_blog.git
* composer install
* cp .env.example .env


## Instruções de uso

* .env (APP_KEY=senhaDoAPI)

```json / Postman
{   
    Header: {
        http-x-api-key : senhaDoAPI
    }
}
```

## URL's de uso

* /api/user/cadastrar

* /api/post
* /api/post/cadastrar

* /api/comment
* /api/comment/cadastrar

* /api/album
* /api/album/cadastrar

* /api/photo
* /api/photo/cadastrar
