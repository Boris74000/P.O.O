<?php

require_once "lib/article.php";

/* $monArticle = new Article(1);

$monArticle->update("text", "C'est est mon nouveau texte !");
$monArticle->update("slug", "C'est est mon nouveau slug !");
$monArticle->update("title", "C'est mon nouveau titre !"); */

/*$newArticle = Article::create([
    'title' => 'titre test 2',
    'slug' => 'new slug 2',
    'text' => 'gezrgergesgergeg 2',
]);

var_dump($newArticle); */

$allArticles = Article::findAll(['title' => 'titre test 2']);
var_dump($allArticles);


