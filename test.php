<?php
require_once 'DB.class.php';
// insert
// DB::table('condominio')->insert(array('nome' => 'wever'))->run();
// DB::table('anuncio')->insert(array('nome' => 'wever'))->run()->insertId();


// select
// var_dump(DB::table('anuncio')->select()->fetch());
// var_dump(DB::table('anuncio')->select()->fetchAll());
// var_dump(DB::table('anuncio')->select(array('id', 'data_criacao'))->fetchAll());
// var_dump(DB::table('anuncio')->select('id, data_criacao')->fetchAll());
// var_dump(DB::table('anuncio')->select()->where(array('id' => '5', 'operator' => '>'))->fetchAll());