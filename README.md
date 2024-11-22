<h1 align="center">Laravel Comment</h1>
<h3 align="center">Comments to your Laravel projects.</h3>
<p align="center">
<a href="https://packagist.org/packages/balajidharma/laravel-comment"><img src="https://poser.pugx.org/balajidharma/laravel-comment/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/balajidharma/laravel-comment"><img src="https://poser.pugx.org/balajidharma/laravel-comment/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/balajidharma/laravel-comment"><img src="https://poser.pugx.org/balajidharma/laravel-comment/license" alt="License"></a>
</p>

## Table of Contents

- [Installation](#installation)
- [Demo](#demo)

## Installation
- Install the package via composer
```bash
composer require balajidharma/laravel-comment
```
- Publish the migration and the config/comment.php config file with
```bash
php artisan vendor:publish --provider="BalajiDharma\LaravelComment\CommentServiceProvider"
```
- Run the migrations
```bash
php artisan migrate
```

## Demo
The "[Basic Laravel Admin Penel](https://github.com/balajidharma/basic-laravel-admin-panel)" starter kit come with Laravel Comment
