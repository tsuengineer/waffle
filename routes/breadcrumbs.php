<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbsTrail;

Breadcrumbs::for('top.index', fn(BreadcrumbsTrail $trail) => [
    $trail->push('ホーム', route('top.index'))
]);

Breadcrumbs::for('post.index', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('棋譜一覧', route('posts.index'))
]);

Breadcrumbs::for('post.show', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('post.index'),
    $trail->push('棋譜詳細')
]);
