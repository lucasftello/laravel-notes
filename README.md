# Laravel Notes


## Para rodar este projeto
```bash
$ git clone https://github.com/lucasftello/laravel-notes
$ cd laravel-notes
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate #antes de rodar este comando verifique sua configuracao com banco em .env
$ php artisan db:seed #para gerar os seeders, dados de teste
$ php artisan serve
```
Acesssar pela url: http://localhost:8000

## Pré-requisitos
- PHP >= 8.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
