<?php
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


// update
// DB::table('anuncio')->update(array('nome' => 'wever'))->run();
// DB::table('anuncio')->update(array('nome' => 'wever'))->run()->affectedRows();


// delete

var_dump(DB::table('anuncio')->delete()->where(array('id' => 15))->run());