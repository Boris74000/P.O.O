<?php

require_once "lib/article.php";

$monArticle = new Article(1);

$monArticle->update("text", "C'est est mon nouveau texte !");
$monArticle->update("slug", "C'est est mon nouveau slug !");
$monArticle->update("title", "C'est mon nouveau titre !");

