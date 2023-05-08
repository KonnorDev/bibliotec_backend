<?php

use yii\db\Migration;

/**
 * Class m230507_203503_initial_migration
 */
class m230507_203503_initial_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%usuarios}}', [
            'usu_id' => $this->primaryKey(),
            'usu_documento' => $this->string(255)->notNull(),
            'usu_nombre' => $this->string(255)->notNull(),
            'usu_apellido' => $this->string(255)->notNull(),
            'usu_mail' => $this->string(255)->notNull(),
            'usu_clave' => $this->string(255)->notNull(),
            'usu_telefono' => $this->string(255)->notNull(),
            'usu_activo' => $this->char(1)->notNull()->defaultValue('S'),
            'usu_tipo_usuario' => $this->integer()->notNull()->defaultvalue(1),
            'usu_habilitado' => $this->char(1)->notNull()->defaultValue('N'),
            'usu_token' => $this->text(),
        ]);
        $this->createTable('{{%sugerencias}}', [
            'sug_id' => $this->primaryKey(),
            'sug_sugerencia' => $this->text()->notNull(),
            'sug_fecha_hora' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'sug_vigente' => $this->char(1)->notNull()->defaultValue('S'),
        ]);

        // autogenerated
        $this->createTable('log_abm', [
            'logabm_id' => $this->primaryKey(),
            'logabm_fecha_hora' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'logabm_usu_id' => $this->integer(),
            'logabm_tabla' => $this->string(255),
            'logabm_accion_id' => $this->integer(),
            'logabm_nombre_accion' => $this->string(255),
            'logabm_modelo_viejo' => $this->text(),
            'logabm_modelo_nuevo' => $this->text(),
            'logabm_descripcion' => $this->text(),
        ]);

        $this->createTable('log_accion', [
            'loga_id' => $this->primaryKey(),
            'loga_endpoint' => $this->string(255),
            'loga_nombre_accoin' => $this->string(255),
            'loga_descripcion' => $this->text(),
            'loga_usu_id' => $this->integer(),
            'loga_fecha_hora' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'loga_logabm_id' => $this->integer(),
        ]);

        $this->createTable('reservas', [
            'resv_id' => $this->primaryKey(),
            'resv_usu_id' => $this->integer(),
            'resv_fecha_hora' => $this->dateTime(),
            'resv_lib_id' => $this->integer(),
            'resv_fecha_desde' => $this->date(),
            'resv_fecha_hasta' => $this->date(),
            'resv_estado' => $this->char(2),
        ]);

        $this->createTable('sub_categorias', [
            'subcat_id' => $this->primaryKey(),
            'subcat_cat_id' => $this->integer(),
            'subcat_nombre' => $this->string(255),
            'subcat_vigente' => $this->char(1)->defaultValue('S'),
        ]);

        $this->createTable('categorias', [
            'cat_id' => $this->primaryKey(),
            'cat_nombre' => $this->string(255),
            'cat_vigente' => $this->char(1)->defaultValue('S'),
        ]);
        
        $this->createTable('comentarios', [
            'comet_id' => $this->primaryKey(),
            'comet_fecha_hora' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'comet_usu_id' => $this->integer(),
            'comet_lib_id' => $this->integer(),
            'comet_comentario' => $this->text(),
            'comet_referencia_id' => $this->integer(),
            'comet_padre_id' => $this->integer(),
            'comet_vigente' => $this->char(1)->defaultValue('S'),
        ]);
        
        $this->createTable('favoritos', [
            'fav_id' => $this->primaryKey(),
            'fav_usu_id' => $this->integer(),
            'fav_lib_id' => $this->integer(),
        ]);
        
        $this->createTable('libros', [
            'lib_id' => $this->primaryKey(),
            'lib_fecha_creado' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'lib_titulo' => $this->string(255),
            'lib_isbn' => $this->string(255),
            'lib_imagen' => $this->text(),
            'lib_posicion' => $this->string(25),
            'lib_descripcion' => $this->text(),
            'lib_stock' => $this->integer(),
            'lib_autores' => $this->text(),
            'lib_edicion' => $this->string(255),
            'lib_fecha_lanzamiento' => $this->date(),
            'lib_novedades' => $this->char(1),
            'lib_idioma' => $this->string(255),
            'lib_disponible' => $this->char(1)->defaultValue('S'),
            'lib_vigente' => $this->char(1)->defaultValue('S'),
            'lib_puntuacion' => $this->double(16, 2),
        ]);
        
        $this->createTable('libros_categorias', [
            'libcat_id' => $this->primaryKey(),
            'libcat_lib_id' => $this->integer(),
            'libcat_cat_id' => $this->integer(),
            'libcat_subcat_id' => $this->integer(),
        ]);

        $this->addForeignKey('comet_lib_fk', 'comentarios', 'comet_lib_id', 'libros', 'lib_id');
        $this->addForeignKey('comet_usu_fk', 'comentarios', 'comet_usu_id', 'usuarios', 'usu_id');
        $this->addForeignKey('fav_lib_fk', 'favoritos', 'fav_lib_id', 'libros', 'lib_id');
        $this->addForeignKey('fav_usu_fk', 'favoritos', 'fav_usu_id', 'usuarios', 'usu_id');
        $this->addForeignKey('libcat_cat_fk', 'libros_categorias', 'libcat_cat_id', 'categorias', 'cat_id');
        $this->addForeignKey('libcat_lib_fk', 'libros_categorias', 'libcat_lib_id', 'libros', 'lib_id');
        $this->addForeignKey('libcat_subcat_fk', 'libros_categorias', 'libcat_subcat_id', 'sub_categorias', 'subcat_id');

        // add foreign key to log_abm table
        $this->addForeignKey('log_abm_ibfk_1', 'log_abm', 'logabm_usu_id', 'usuarios', 'usu_id');
        $this->addForeignKey('log_abm_ibfk_2', 'log_abm', 'logabm_accion_id', 'log_accion', 'loga_id');

        // add foreign key to log_accion table
        $this->addForeignKey('log_accion_ibfk_1', 'log_accion', 'loga_logabm_id', 'log_abm', 'logabm_id');
        $this->addForeignKey('log_accion_ibfk_2', 'log_accion', 'loga_usu_id', 'usuarios', 'usu_id');

        // add foreign key to reservas table
        $this->addForeignKey('reservas_ibfk_1', 'reservas', 'resv_usu_id', 'usuarios', 'usu_id');
        $this->addForeignKey('reservas_ibfk_2', 'reservas', 'resv_lib_id', 'libros', 'lib_id');

        // add foreign key to sub_categorias table
        $this->addForeignKey('sub_categorias_ibfk_1', 'sub_categorias', 'subcat_cat_id', 'categorias', 'cat_id');
        // end-autogenerated
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('comet_lib_fk', 'comentarios');
        $this->dropForeignKey('comet_usu_fk', 'comentarios');
        $this->dropForeignKey('fav_lib_fk', 'favoritos');
        $this->dropForeignKey('fav_usu_fk', 'favoritos');
        $this->dropForeignKey('libcat_cat_fk', 'libros_categorias');
        $this->dropForeignKey('libcat_lib_fk', 'libros_categorias');
        $this->dropForeignKey('libcat_subcat_fk', 'libros_categorias');

        // drop foreign keys from sub_categorias table
        $this->dropForeignKey('sub_categorias_ibfk_1', 'sub_categorias');

        // drop foreign keys from reservas table
        $this->dropForeignKey('reservas_ibfk_2', 'reservas');
        $this->dropForeignKey('reservas_ibfk_1', 'reservas');

        // drop foreign keys from log_accion table
        $this->dropForeignKey('log_accion_ibfk_2', 'log_accion');
        $this->dropForeignKey('log_accion_ibfk_1', 'log_accion');

        // drop foreign keys from log_abm table
        $this->dropForeignKey('log_abm_ibfk_2', 'log_abm');
        $this->dropForeignKey('log_abm_ibfk_1', 'log_abm');

        $this->dropTable('{{%usuarios}}');
        $this->dropTable('{{%sugerencias}}');
        $this->dropTable('{{%log_abm}}');
        $this->dropTable('{{%log_accion}}');
        $this->dropTable('{{%reservas}}');
        $this->dropTable('{{%sub_categorias}}');
    }
}
