<?php
$GLOBALS['config']['db'] = array(
    'host' => 'localhost',
    'user' => 'root',
    'password' => '123456',
    'db' => 'sistema'
);

require_once 'DB.class.php';

// insert
// DB::table('condominio')->insert(array('nome' => 'wever'))->run();
// DB::table('anuncio')->insert(array('nome' => 'wever'))->run()->insertId();


// select
// DB::table('anuncio')->select()->fetch();
// DB::table('anuncio')->select()->fetchAll();
// DB::table('anuncio')->select(array('id', 'data_criacao'))->fetchAll();
// DB::table('anuncio')->select('id, data_criacao')->fetchAll();
// DB::table('anuncio')->select()->where(array('id' => '5', 'operator' => '>'))->where(array('cidade' => 'Campos Belos'))->fetchAll();
// DB::table('anuncio')->select()->where(array('id' => '5', 'operator' => '>'))->where(array('cidade' => 'Campos Belos'))->orderBy('id, cidade')->fetchAll();
// DB::table('anuncio')->select()->where(array('id' => '5', 'operator' => '>'))->where(array('cidade' => 'Campos Belos'))->orderBy(array('id', 'cidade'))->fetchAll();
// DB::table('anuncio')->select()->where(array('id' => '5', 'operator' => '>'))->where(array('cidade' => 'Campos Belos'))->orderBy(array('id', 'cidade'), 'DESC')->fetchAll();
// DB::table('anuncio')->select()->limit(2)->fetchAll();
// DB::table('anuncio')->select()->limit('1, 2')->fetchAll();
// DB::table('anuncio')->select()->limit(array('1', '2'))->fetchAll();


// update
// DB::table('anuncio')->update(array('nome' => 'wever'))->run();
// DB::table('anuncio')->update(array('nome' => 'wever'))->run()->affectedRows();


// delete
// var_dump(DB::table('anuncio')->delete()->run());
// var_dump(DB::table('anuncio')->delete()->where(array('id' => 15))->run());
