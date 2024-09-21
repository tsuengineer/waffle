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

Breadcrumbs::for('post.create', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('post.index'),
    $trail->push('棋譜投稿')
]);

Breadcrumbs::for('post.edit', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('post.index'),
    $trail->push('棋譜編集')
]);

Breadcrumbs::for('search.index', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('検索')
]);

Breadcrumbs::for('board.index', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('棋譜ビューワー')
]);

Breadcrumbs::for('xot.random', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('XOT初期盤面(ランダム)')
]);

Breadcrumbs::for('user.index', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('ユーザ一覧', route('users.index'))
]);

Breadcrumbs::for('user.show', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('user.index'),
    $trail->push('ユーザ詳細')
]);

Breadcrumbs::for('profile.show', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('マイページ')
]);

Breadcrumbs::for('static.links', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('リンク集')
]);

Breadcrumbs::for('static.basic-strategy', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('オセロ基本戦略')
]);

Breadcrumbs::for('error.index', fn(BreadcrumbsTrail $trail) => [
    $trail->parent('top.index'),
    $trail->push('エラーページ')
]);
