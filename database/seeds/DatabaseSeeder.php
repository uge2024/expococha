<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        //DATOS BASICOS
        DB::table('users')->insert([
            'name'=>'Administrador Pagina',
            'email'=>'juantezana67@gmail.com',
            'email_verified_at'=>'2020-10-10 00:00:00',
            'password'=>'$2y$10$XO8I3SW4S0YvGgoKsSH4POi1oH20Cx.INKsZsfG15x3w.pO4FhJZa',
            'remember_token'=>null,
            'created_at'=>'2020-10-18 00:00:00',
            'updated_at'=>'2020-10-18 00:00:00',
            'estado'=>'AC',
            'rol'=>3,
            'correo_validado'=>1,
            'celular'=>77777777,
            'direccion'=>'sin direccion'
        ]);

        $ins = DB::table('ins_institucion')->insertGetId([
            'ins_id'=> 1,
            'sigla'=> 'ExpoCocha',
            'nombre' => 'ExpoCocha',
            'descripcion' => 'Plataforma web de exposición y comercion de productos de Cochabamba',
            'direccion' => 'Calle Litoral, esquina Benajmin Blanco y Oquendo',
            'imagen_icono' => '16056436985fb42db2da148.jpeg',
            'imagen_reporte' => '16056424075fb428a7591e7.jpeg',
            'imagen_banner' => '16056424075fb428a7591e7.jpeg',
            'link_facebook' => 'https://www.facebook.com/sergio.limachigironda',
            'link_twiter' => 'https://twitter.com/MarquinaRuddy',
            'link_instagram' => 'https://www.instagram.com/ruddymarquina/',
            'link_youtube' => 'https://www.youtube.com/channel/UCUjrDJokSX8JavRwy5iUOkA',
            'celular' => '63902726',
            'celular_wp' => '62909726',
            'estado' => 'AC'
        ],'ins_id');

        $par1 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 1,
            'codigo' => 'TIPO-IMAGEN_1',
            'valor1' => '1',
            'valor2' => '1920',
            'valor3' => '480',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');

        $par2 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 2,
            'codigo' => 'TIPO-IMAGEN-2',
            'valor1' => '2',
            'valor2' => '1920',
            'valor3' => '470',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par3 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 3,
            'codigo' => 'TIPO-IMAGEN-3',
            'valor1' => '3',
            'valor2' => '1110',
            'valor3' => '470',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par4 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 4,
            'codigo' => 'TIPO-IMAGEN-4',
            'valor1' => '4',
            'valor2' => '1110',
            'valor3' => '350',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par5 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 5,
            'codigo' => 'TIPO-IMAGEN-5',
            'valor1' => '5',
            'valor2' => '850',
            'valor3' => '550',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par6 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 6,
            'codigo' => 'TIPO-IMAGEN-6',
            'valor1' => '6',
            'valor2' => '730',
            'valor3' => '480',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par7 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 7,
            'codigo' => 'TIPO-IMAGEN-7',
            'valor1' => '7',
            'valor2' => '690',
            'valor3' => '220',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');

        $par8 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 8,
            'codigo' => 'TIPO-IMAGEN-8',
            'valor1' => '8',
            'valor2' => '600',
            'valor3' => '600',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par9 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 9,
            'codigo' => 'TIPO-IMAGEN-9',
            'valor1' => '9',
            'valor2' => '540',
            'valor3' => '210',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par10 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 10,
            'codigo' => 'TIPO-IMAGEN-10',
            'valor1' => '10',
            'valor2' => '540',
            'valor3' => '170',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par11 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 11,
            'codigo' => 'TIPO-IMAGEN-11',
            'valor1' => '11',
            'valor2' => '450',
            'valor3' => '330',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par12 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 12,
            'codigo' => 'TIPO-IMAGEN-12',
            'valor1' => '12',
            'valor2' => '350',
            'valor3' => '350',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par13 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 13,
            'codigo' => 'TIPO-IMAGEN-13',
            'valor1' => '13',
            'valor2' => '350',
            'valor3' => '210',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par14 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 14,
            'codigo' => 'TIPO-IMAGEN-14',
            'valor1' => '14',
            'valor2' => '350',
            'valor3' => '140',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par15 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 15,
            'codigo' => 'TIPO-IMAGEN-15',
            'valor1' => '15',
            'valor2' => '255',
            'valor3' => '210',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par16 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 16,
            'codigo' => 'TIPO-IMAGEN-16',
            'valor1' => '16',
            'valor2' => '255',
            'valor3' => '165',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par17 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 17,
            'codigo' => 'TIPO-IMAGEN-17',
            'valor1' => '17',
            'valor2' => '255',
            'valor3' => '155',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par18 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 18,
            'codigo' => 'TIPO-IMAGEN-18',
            'valor1' => '18',
            'valor2' => '120',
            'valor3' => '120',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');


        $par19 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 19,
            'codigo' => 'ZOOM-PRODUCTOR-MAPA-1',
            'valor1' => '16',
            'valor2' => '-17.392409',
            'valor3' => '-66.159072',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par20 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 20,
            'codigo' => 'LATITUD-INICIAL-PRODUCTOR',
            'valor1' => '16',
            'valor2' => '-17.392409',
            'valor3' => '-66.159072',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par21 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 21,
            'codigo' => 'LONGITUD-INICIAL-PRODUCTOR',
            'valor1' => '16',
            'valor2' => '-17.392409',
            'valor3' => '-66.159072',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par22 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 22,
            'codigo' => 'MAX-PRODUCTO-IMAGEN',
            'valor1' => '5',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');
        $par23 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 23,
            'codigo' => 'DIAS-PRODUCTO-NUEVO',
            'valor1' => '10',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');

        $par24 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 24,
            'codigo' => 'TIPO-IMAGEN-19',
            'valor1' => '19',
            'valor2' => '112',
            'valor3' => '27',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');

        $par25 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 25,
            'codigo' => 'TIPO-IMAGEN-20',
            'valor1' => '20',
            'valor2' => '550',
            'valor3' => '850',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');

        $par26 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 26,
            'codigo' => 'TIPO-IMAGEN-21',
            'valor1' => '21',
            'valor2' => '164',
            'valor3' => '38',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ],'par_id');

        $publicidad1 = DB::table('tpu_tipo_publicidad')->insertGetId([
            'tipo' => 1,
            'nombre' => 'P1-BANNER',
            'alto' => '480',
            'ancho' => '1920',
            'costo_pedido' => '1',
            'disponible' => '1',
            'estado' => 'AC'
        ],'tpu_id');

        $publicidad2 = DB::table('tpu_tipo_publicidad')->insertGetId([
            'tipo' => 3,
            'nombre' => 'P2-CAJA#1',
            'alto' => '170',
            'ancho' => '540',
            'costo_pedido' => '1',
            'disponible' => '1',
            'estado' => 'AC'
        ],'tpu_id');

        $publicidad3 = DB::table('tpu_tipo_publicidad')->insertGetId([
            'tipo' => 3,
            'nombre' => 'P3-CAJA#2',
            'alto' => '170',
            'ancho' => '540',
            'costo_pedido' => '1',
            'disponible' => '1',
            'estado' => 'AC'
        ],'tpu_id');

        /*$publicidad4 = DB::table('tpu_tipo_publicidad')->insertGetId([
            'tipo' => 4,
            'nombre' => 'P4-POPUP',
            'alto' => '600',
            'ancho' => '600',
            'costo_pedido' => '1',
            'disponible' => '1',
            'estado' => 'AC'
        ],'tpu_id');*/

        //END DATOS BASICOS


        /*$usr1 = DB::table('users')->insertGetId([
            'name'=>'Administrador Pagina',
            'email'=>'sergiolimachi7@gmail.com',
            'email_verified_at'=>null,
            'password'=>'$2y$10$XO8I3SW4S0YvGgoKsSH4POi1oH20Cx.INKsZsfG15x3w.pO4FhJZa',
            'remember_token'=>null,
            'created_at'=>'2020-10-18 00:00:00',
            'updated_at'=>'2020-10-18 00:00:00',
            'estado'=>'AC',
            'rol'=>2,
            'correo_validado'=>1,
            'celular'=>77777777,
            'direccion'=>'sin direccion'
        ]);
        $usr2 = DB::table('users')->insertGetId([
            'name'=>'Administrador Pagina',
            'email'=>'sergio-0091@hotmail.com',
            'email_verified_at'=>null,
            'password'=>'$2y$10$XO8I3SW4S0YvGgoKsSH4POi1oH20Cx.INKsZsfG15x3w.pO4FhJZa',
            'remember_token'=>null,
            'created_at'=>'2020-10-18 00:00:00',
            'updated_at'=>'2020-10-18 00:00:00',
            'estado'=>'AC',
            'rol'=>2,
            'correo_validado'=>1,
            'celular'=>77777777,
            'direccion'=>'sin direccion'
        ]);

        $usr3 = DB::table('users')->insertGetId([
            'name'=>'Administrador Pagina',
            'email'=>'ruddy_marquina@hotmail.com',
            'email_verified_at'=>null,
            'password'=>'$2y$10$XO8I3SW4S0YvGgoKsSH4POi1oH20Cx.INKsZsfG15x3w.pO4FhJZa',
            'remember_token'=>null,
            'created_at'=>'2020-10-18 00:00:00',
            'updated_at'=>'2020-10-18 00:00:00',
            'estado'=>'AC',
            'rol'=>2,
            'correo_validado'=>1,
            'celular'=>77777777,
            'direccion'=>'sin direccion'
        ]);

        $usr4 = DB::table('users')->insertGetId([
            'name'=>'Administrador Pagina',
            'email'=>'escobar.ariel4444@gmail.com',
            'email_verified_at'=>null,
            'password'=>'$2y$10$XO8I3SW4S0YvGgoKsSH4POi1oH20Cx.INKsZsfG15x3w.pO4FhJZa',
            'remember_token'=>null,
            'created_at'=>'2020-10-18 00:00:00',
            'updated_at'=>'2020-10-18 00:00:00',
            'estado'=>'AC',
            'rol'=>2,
            'correo_validado'=>1,
            'celular'=>77777777,
            'direccion'=>'sin direccion'
        ]);


        $usr5 = DB::table('users')->insertGetId([
            'name'=>'Productor',
            'email' => 'cintia_marquina@hotmail.com',
            'email_verified_at'=>null,
            'password'=>'$2y$10$XO8I3SW4S0YvGgoKsSH4POi1oH20Cx.INKsZsfG15x3w.pO4FhJZa',
            'remember_token'=>null,
            'created_at'=>'2020-10-18 00:00:00',
            'updated_at'=>'2020-10-18 00:00:00',
            'estado'=>'AC',
            'rol'=>2,
            'correo_validado'=>1,
            'celular'=>77777777,
            'direccion'=>'sin direccion'
        ]);

        $usr2 = DB::table('users')->insertGetId([
            'name'=>'Administrador Pagina',
            'email'=>'ruddymarquina@gmail.com',
            'email_verified_at'=>null,
            'password'=>'$2y$10$XO8I3SW4S0YvGgoKsSH4POi1oH20Cx.INKsZsfG15x3w.pO4FhJZa',
            'remember_token'=>null,
            'created_at'=>'2020-10-18 00:00:00',
            'updated_at'=>'2020-10-18 00:00:00',
            'estado'=>'AC',
            'rol'=>2,
            'correo_validado'=>1,
            'celular'=>77777777,
            'direccion'=>'sin direccion'
        ]);

        $rubro1 = DB::table('rub_rubro')->insertGetId([
            'nombre' => 'VENTA DE ROPA',
            'descripcion' => 'Negocio atractivo para emprendedores que quieren invertir poco dinero y desarrollarlo en su tiempo libre. Además, no sólo puedes enfocarte en la ropa.',
            'estado' => 'AC',
            'imagen_banner' => '16056436985fb42db2da148.jpeg',
            'imagen_icono' => '16056424075fb428a7591e7.jpeg'
        ],'rub_id');

        $rubro2 = DB::table('rub_rubro')->insertGetId([
            'nombre' => 'CARPINTERIA',
            'descripcion' => 'Arte y tecnica de trabajar la madera y de fabricar o arreglar objetos con ella.',
            'estado' => 'AC',
            'imagen_banner' => '16056439065fb42e82229a7.jpeg',
            'imagen_icono' => '16056439065fb42e8265837.jpeg'
        ],'rub_id');

        $rubro3 = DB::table('rub_rubro')->insertGetId([
            'nombre' => 'METALMECANICA',
            'descripcion' => 'abarca las máquinas industriales y herramientas proveedoras de partes a las demás industrias metálicas, siendo el metal y las aleaciones de hierro.',
            'estado' => 'AC',
            'imagen_banner' => '16056433645fb42c6499444.jpeg',
            'imagen_icono' => '16056433645fb42c64c539d.jpeg'
        ],'rub_id');

        $rubro4 = DB::table('rub_rubro')->insertGetId([
            'nombre' => 'CUEROS',
            'descripcion' => 'Ofrece cueros de óptima calidad reconocidos tanto a nivel nacional como internacional.',
            'estado' => 'AC',
            'imagen_banner' => '16056428235fb42a47a7332.jpeg',
            'imagen_icono' => '16056437955fb42e137ec08.jpeg'
        ],'rub_id');

        $rubro5 = DB::table('rub_rubro')->insertGetId([
            'nombre' => 'ALIMENTOS Y BEBIDAS',
            'descripcion' => 'Arte y tecnica de trabajar la madera y de fabricar o arreglar objetos con ella.',
            'estado' => 'AC',
            'imagen_banner' => '16056430935fb42b553992b.jpeg',
            'imagen_icono' => '16056439805fb42ecc940aa.jpeg'
        ],'rub_id');

        $categoriaRubro1 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro1,
            'nombre' => 'Ropa de niño y niña',
            'descripcion' => "prendas para niños.",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro2 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro1,
            'nombre' => 'Ropa de mujer temporada invierno',
            'descripcion' => 'temporada invierno',
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro3 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro1,
            'nombre' => 'Ropa de hombre temporada invierno',
            'descripcion' => 'temporada invierno',
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro4 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro1,
            'nombre' => 'Ropa de hombre temporada verano',
            'descripcion' => 'temporada verano',
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro5 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro1,
            'nombre' => 'Ropa de niño y niña varios colores',
            'descripcion' => "prendas para niños en varios colores",
            'nivel' => '2',
            'padre_id' => $categoriaRubro1,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro6 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro1,
            'nombre' => 'Ropa de mujer temporada invierno varios colores',
            'descripcion' => "Ropa de mujer temporada invierno varios colores y tamaños",
            'nivel' => '2',
            'padre_id' => $categoriaRubro2,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro7 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro1,
            'nombre' => 'Ropa de hombre temporada invierno varios colores',
            'descripcion' => "Ropa de hombre temporada invierno varios colores y tamaños",
            'nivel' => '2',
            'padre_id' => $categoriaRubro3,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro8 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro2,
            'nombre' => 'Carpinteria en Madera',
            'descripcion' => "La carpintería es el oficio de trabajar, cortar y labrar la madera solida",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro9 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro2,
            'nombre' => 'Carpinteria en Melamina',
            'descripcion' => "La carpintería es el oficio de trabajar, cortar y armar melamina",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro10 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro2,
            'nombre' => 'Muebles de madera Solida',
            'descripcion' => "diferentes tipos de muebles desde camas hasta puertas",
            'nivel' => '2',
            'padre_id' => $categoriaRubro8,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro11 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro2,
            'nombre' => 'Muebles de malamina',
            'descripcion' => "Venta de muebles de melamina pre diseñados",
            'nivel' => '2',
            'padre_id' => $categoriaRubro9,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro12 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro3,
            'nombre' => 'Estructuras en metal',
            'descripcion' => "Desarrollo de estuctura de metal y otros",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro13 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro3,
            'nombre' => 'Desarrollo de maquinas',
            'descripcion' => "Diseño y desarrollo de maquinaria a medida",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro14 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro3,
            'nombre' => 'Estructuras para viviendas',
            'descripcion' => "Estructuras para viviendas como ser gradas y otros",
            'nivel' => '2',
            'padre_id' => $categoriaRubro12,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro15 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro3,
            'nombre' => 'Maquinas para la construccion',
            'descripcion' => "Maquinaria para la construccion de viviendas",
            'nivel' => '2',
            'padre_id' => $categoriaRubro13,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro16 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro4,
            'nombre' => 'Chamaras de cuero',
            'descripcion' => "Venta de abrigos",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro17 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro4,
            'nombre' => 'Zapatos',
            'descripcion' => "Venta de zapatos al por mayor y menor",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');
        $categoriaRubro18 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro4,
            'nombre' => 'Abrigos chamaras para mujer y varon',
            'descripcion' => "prendas para niños en varios colores",
            'nivel' => '2',
            'padre_id' => $categoriaRubro17,
            'estado' => 'AC'
        ],'cat_id');
        $categoriaRubro19 = DB::table('cat_categoria_rubro')->insertGetId([
        'rub_id' => $rubro4,
        'nombre' => 'Ropa de niño y niña varios colores',
        'descripcion' => "prendas para niños en varios colores",
        'nivel' => '2',
        'padre_id' => $categoriaRubro18,
        'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro20 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro5,
            'nombre' => 'Vinos',
            'descripcion' => "Se producen Vinos con distintas variedades de uvas. Las más importantes variedades de uva son los siguientes: Cabernet Sauvignon, Syrah, Malbec, Merlot, Barbera, Tannat, Oporto (Portugieser)",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro21 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro5,
            'nombre' => 'Embutidos',
            'descripcion' => "Preparación que consiste en una tripa natural o sintética embuchada con carne picada de cerdo, tocino, sangre cocida u otros ingredientes y condimentos",
            'nivel' => '1',
            'padre_id' => null,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro22 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro5,
            'nombre' => 'Vinos Tradicionales',
            'descripcion' => "Se producen Vinos con distintas variedades en cochabamba",
            'nivel' => '2',
            'padre_id' => $categoriaRubro20,
            'estado' => 'AC'
        ],'cat_id');

        $categoriaRubro23 = DB::table('cat_categoria_rubro')->insertGetId([
            'rub_id' => $rubro5,
            'nombre' => 'Embutidos Tradicionales',
            'descripcion' => "Preparación que consiste en una tripa natural o sintética.",
            'nivel' => '2',
            'padre_id' => $categoriaRubro21,
            'estado' => 'AC'
        ],'cat_id');

        $asoci1 = DB::table('aso_asociacion')->insertGetId([
            'sigla' => 'COTEXBO',
            'nombre' => 'Asociación del Conglomerado Textil Boliviano',
            'actividad' => 'Textiles',
            'direccion' => 'Tejada Sorzano Avenue No. 414 Miraflores',
            'telefono' => '73223925',
            'celular' => '73223925',
            'estado' => 'AC'
        ],'aso_id');

        $asociacion2 = DB::table('aso_asociacion')->insertGetId([
            'sigla' => 'ASOMEC',
            'nombre' => 'Asociación de Metalmecanica de cochabamba',
            'actividad' => 'Metal',
            'direccion' => 'Tejada Sorzano  No. 414 Quillacollo',
            'telefono' => '72223925',
            'celular' => '73223925',
            'estado' => 'AC'
        ],'aso_id');

        $asociacion3 = DB::table('aso_asociacion')->insertGetId([
            'sigla' => 'ASOCEC',
            'nombre' => 'La Asociación de Carpinteros Ebanistas de Cochabamba',
            'actividad' => 'Metal',
            'direccion' => 'Tejada Sorzano  No. 414 Quillacollo',
            'telefono' => '72223925',
            'celular' => '73223925',
            'estado' => 'AC'
        ],'aso_id');

        $asociacion4 = DB::table('aso_asociacion')->insertGetId([
            'sigla' => 'ASOC',
            'nombre' => 'La Asociación de Carpinteros Ebanistas del tropico',
            'actividad' => 'Metal',
            'direccion' => 'Tejada Sorzano  No. 4 tropico',
            'telefono' => '71223915',
            'celular' => '71223925',
            'estado' => 'AC'
        ],'aso_id');

        $asociacion5 = DB::table('aso_asociacion')->insertGetId([
            'sigla' => 'ASOPVQ',
            'nombre' => 'La Asociación de productores de Vinos y quesos cochabamba',
            'actividad' => 'Produccion de vinos y quesos',
            'direccion' => 'Quintanilla No. 412 ',
            'telefono' => '71223315',
            'celular' => '71223665',
            'estado' => 'AC'
        ],'aso_id');

        $asociacion6 = DB::table('aso_asociacion')->insertGetId([
            'sigla' => 'ASOPRC',
            'nombre' => 'La Asociación de productores de Ropa cochabamba',
            'actividad' => 'Produccion de ropa en general',
            'direccion' => 'zona del estadium No. 2412 ',
            'telefono' => '71223315',
            'celular' => '71223665',
            'estado' => 'AC'
        ],'aso_id');

        $productor1 = DB::table('pro_productor')->insertGetId([
            'rub_id' => $rubro5,
            'usr_id' => $usr1,
            'nombre_propietario' => 'Ernesto rivas',
            'direccion' => 'Calle Heroinas entre ayacucho',
            'telefono_1' => '12232222',
            'telefono_2' => '12232222',
            'celular' => '63909726',
            'celular_wp' => '63909726',
            'nombre_tienda' => 'Vinos y embutidos',
            'actividad' => 'ventas de vinos y embutidos',
            'email' => 'sergio-0091@hotmail.com',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'link_facebook' => 'https://www.facebook.com/sergio.limachigironda',
            'link_twiter' => 'https://twitter.com/MarquinaRuddy',
            'link_instagram' => 'https://www.instagram.com/ruddymarquina/',
            'link_youtube' => 'https://www.youtube.com/channel/UCUjrDJokSX8JavRwy5iUOkA',
            'estado' => 'AC',
            'puntuacion'=>'3',
            'fecha_registro' =>'2020-10-20',
            'estado_tienda' => 'AC',
            'aso_id' => $asoci1
        ],'pro_id');

        $productor2 = DB::table('pro_productor')->insertGetId([
            'rub_id' => $rubro4,
            'usr_id' => $usr2,
            'nombre_propietario' => 'Alberto rojas',
            'direccion' => 'calle ayacucho entre ',
            'telefono_1' => '12232222',
            'telefono_2' => '12232222',
            'celular' => '63902726',
            'celular_wp' => '62909726',
            'nombre_tienda' => 'Venta de vinos',
            'actividad' => 'vente de vinos',
            'email' => 'sergio-0091@hotmail.com',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'link_facebook' => 'https://www.facebook.com/sergio.limachigironda',
            'link_twiter' => 'https://twitter.com/MarquinaRuddy',
            'link_instagram' => 'https://www.instagram.com/ruddymarquina/',
            'link_youtube' => 'https://www.youtube.com/channel/UCUjrDJokSX8JavRwy5iUOkA',
            'estado' => 'AC',
            'puntuacion'=>'3',
            'fecha_registro' =>'2020-10-20',
            'estado_tienda' => 'AC',
            'aso_id' => $asociacion4
        ],'pro_id');


        $productor3 = DB::table('pro_productor')->insertGetId([
            'rub_id' => $rubro1,
            'usr_id' => $usr3,
            'nombre_propietario' => 'Marcos lopez',
            'direccion' => 'calle san martin entre ',
            'telefono_1' => '12232222',
            'telefono_2' => '12232222',
            'celular' => '63902726',
            'celular_wp' => '62909726',
            'nombre_tienda' => 'Shopping Flores',
            'actividad' => 'Venta y confeccion de ropa',
            'email' => 'ruddy_marquina@hotmail.com',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'link_facebook' => 'https://www.facebook.com/sergio.limachigironda',
            'link_twiter' => 'https://twitter.com/MarquinaRuddy',
            'link_instagram' => 'https://www.instagram.com/ruddymarquina/',
            'link_youtube' => 'https://www.youtube.com/channel/UCUjrDJokSX8JavRwy5iUOkA',
            'estado' => 'AC',
            'puntuacion'=>'3',
            'fecha_registro' =>'2020-10-20',
            'estado_tienda' => 'AC',
            'aso_id' => $asociacion6
        ],'pro_id');

        $productor4 = DB::table('pro_productor')->insertGetId([
            'rub_id' => $rubro1,
            'usr_id' => $usr4,
            'nombre_propietario' => 'Dayana lopez',
            'direccion' => 'calle san martin entre3343 ',
            'telefono_1' => '12232222',
            'telefono_2' => '12232222',
            'celular' => '63902726',
            'celular_wp' => '62909726',
            'nombre_tienda' => 'Shopping Flores y vera',
            'actividad' => 'Venta y confeccion de ropa y costura',
            'email' => 'ruddys_marquina@hotmail.com',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'link_facebook' => 'https://www.facebook.com/sergio.limachigironda',
            'link_twiter' => 'https://twitter.com/MarquinaRuddy',
            'link_instagram' => 'https://www.instagram.com/ruddymarquina/',
            'link_youtube' => 'https://www.youtube.com/channel/UCUjrDJokSX8JavRwy5iUOkA',
            'estado' => 'AC',
            'puntuacion'=>'3',
            'fecha_registro' =>'2020-10-20',
            'estado_tienda' => 'AC',
            'aso_id' => $asociacion6
        ],'pro_id');

         $productor5 = DB::table('pro_productor')->insertGetId([
            'rub_id' => $rubro1,
            'usr_id' => $usr5,
            'nombre_propietario' => 'Cintia Salas',
            'direccion' => 'calle san martin entre3343 ',
            'telefono_1' => '12232222',
            'telefono_2' => '12232222',
            'celular' => '63902726',
            'celular_wp' => '62909726',
            'nombre_tienda' => 'Tienda Salas',
            'actividad' => 'Venta y confeccion de ropa y costura',
            'email' => 'cintia_marquina@hotmail.com',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'link_facebook' => 'https://www.facebook.com/sergio.limachigironda',
            'link_twiter' => 'https://twitter.com/MarquinaRuddy',
            'link_instagram' => 'https://www.instagram.com/ruddymarquina/',
            'link_youtube' => 'https://www.youtube.com/channel/UCUjrDJokSX8JavRwy5iUOkA',
            'estado' => 'AC',
            'puntuacion'=>'3',
            'fecha_registro' =>'2020-10-20',
            'estado_tienda' => 'AC',
            'aso_id' => $asociacion6
        ],'pro_id');


        $producto1 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor1,
            'cat_id'=> $categoriaRubro23,
            'nombre_producto' => 'Queso Criollo',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Queso Criollo de diferentes tamaños',
            'descripcion2' => 'Queso elaborado a base de leche ',
            'precio' => 50.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => null,
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $producto2 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor1,
            'cat_id'=> $categoriaRubro22,
            'nombre_producto' => 'Vino tinto',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Vino tinto ',
            'descripcion2' => 'Vino tinto presentacion de 1 litro',
            'precio' => 39.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => '2020-11-24',
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $producto3 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor3,
            'cat_id'=> $categoriaRubro6,
            'nombre_producto' => 'Chompas de Lana ',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Chompas de lana varios colores y otros',
            'descripcion2' => 'Chompas de lana en varios colores, modelos y tamaños ',
            'precio' => 48.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => null,
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $producto4 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor1,
            'cat_id'=> $categoriaRubro22,
            'nombre_producto' => 'Vino blanco',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Vino blanco y otros',
            'descripcion2' => 'La produccion del vino blanco con los mas altos estandares de elaboracion',
            'precio' => 70.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => '2020-11-24',
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $producto5 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor1,
            'cat_id'=> $categoriaRubro23,
            'nombre_producto' => 'Queso',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Queso de diferentes tamaños',
            'descripcion2' => 'Queso elaborado a base de leche',
            'precio' => 50.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => null,
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $producto6 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor2,
            'cat_id'=> $categoriaRubro23,
            'nombre_producto' => 'Zapatos hombre',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Zapatos para varon de diferentes temporadas',
            'descripcion2' => 'Zapatos de diferentes tipos y modelos para todo tipo de evento',
            'precio' => 250.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => null,
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $producto7 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor2,
            'cat_id'=> $categoriaRubro23,
            'nombre_producto' => 'Chamaras de cuero ',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Chamaras para varon de diferentes temporadas',
            'descripcion2' => 'Chamaras de diferentes tipos,modelos y colores',
            'precio' => 350.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => null,
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $producto8 = DB::table('prd_producto')->insertGetId([
            'pro_id' => $productor2,
            'cat_id'=> $categoriaRubro23,
            'nombre_producto' => 'Chamaras de cuero para dama',
            'existencia' => 5,
            'puntuacion' => 3,
            'descripcion1' => 'Chamaras para mujer diferentes temporadas',
            'descripcion2' => 'Chamaras de diferentes tipos,modelos y colores ',
            'precio' => 350.0,
            'precio_oferta' => null,
            'descuento' => 0,
            'existencia_minima' => 10,
            'fecha_registro' => '2020-11-18',
            'fecha_modificacion' => null,
            'codigo_qr_venta' => null,
            'estado' => 'AC',
            'fecha_inicio_oferta' => null,
            'fecha_fin_oferta' =>null
        ],'prd_id');

        $delivery1 = DB::table('del_delivery')->insertGetId([
            'razon_social'=> 'Sin delivery',
            'propietario' => 'ninguno',
            'tipo_transporte' => 'Otros',
            'disponible' => '1',
            'costo_minimo' => 0,
            'costo_maximo' =>0,
            'pro_id' => $productor1,
            'estado' => 'AC'
        ],'del_id');

        $delivery2 = DB::table('del_delivery')->insertGetId([
            'razon_social'=> 'Sin delivery',
            'propietario' => 'ninguno',
            'tipo_transporte' => 'Otros',
            'disponible' => '1',
            'costo_minimo' => 0,
            'costo_maximo' =>0,
            'pro_id' => $productor2,
            'estado' => 'AC'
        ],'del_id');

        $delivery3 = DB::table('del_delivery')->insertGetId([
            'razon_social'=> 'Sin delivery',
            'propietario' => 'ninguno',
            'tipo_transporte' => 'Otros',
            'disponible' => '1',
            'costo_minimo' => 0,
            'costo_maximo' =>0,
            'pro_id' => $productor3,
            'estado' => 'AC'
        ],'del_id');

        $delivery4 = DB::table('del_delivery')->insertGetId([
            'razon_social'=> 'Sin delivery',
            'propietario' => 'ninguno',
            'tipo_transporte' => 'Otros',
            'disponible' => '1',
            'costo_minimo' => 0,
            'costo_maximo' =>0,
            'pro_id' => $productor4,
            'estado' => 'AC'
        ],'del_id');

        $delivery5 = DB::table('del_delivery')->insertGetId([
            'razon_social'=> 'Sin delivery',
            'propietario' => 'ninguno',
            'tipo_transporte' => 'Otros',
            'disponible' => '1',
            'costo_minimo' => 0,
            'costo_maximo' =>0,
            'pro_id' => $productor5,
            'estado' => 'AC'
        ],'del_id');



        $feriavirtual1 = DB::table('fev_feria_virtual')->insertGetId([
            'version'=> '2',
            'nombre' => 'Feria de carpintería en alumnio',
            'descripcion' => 'Feria departamental de Carpintería en alumnio',
            'fecha_inicio' => '2020-12-19',
            'fecha_final' => '2020-12-29',
            'lugar' => 'Plaza 14 de septiembre',
            'direccion' => 'Calle Su',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'estado' => 'AC',
            'rub_id' => $rubro1
        ],'fev_id');

        $feriavirtual2 = DB::table('fev_feria_virtual')->insertGetId([
            'version'=> '2',
            'nombre' => 'Feria del Cuero',
            'descripcion' => 'Feria departamental de productores de cuero',
            'fecha_inicio' => '2020-12-17',
            'fecha_final' => '2020-12-27',
            'lugar' => 'Plaza sucre frente a la facultad de derecho',
            'direccion' => 'Calle Sucre',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'estado' => 'AC',
            'rub_id' => $rubro2
        ],'fev_id');

        $feriavirtual3 = DB::table('fev_feria_virtual')->insertGetId([
            'version'=> '6',
            'nombre' => 'Feria de metal mecanica',
            'descripcion' => 'Feria departamental de productores de vino y queso',
            'fecha_inicio' => '2020-12-20',
            'fecha_final' => '2020-12-31',
            'lugar' => 'Plaza sucre',
            'direccion' => 'Calle sucre',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'estado' => 'AC',
            'rub_id' => $rubro3
        ],'fev_id');

        $feriavirtual4 = DB::table('fev_feria_virtual')->insertGetId([
            'version'=> '6',
            'nombre' => 'Feria del Cuero y el Calzado ',
            'descripcion' => 'Feria departamental de productores de vino y queso',
            'fecha_inicio' => '2020-12-20',
            'fecha_final' => '2020-12-31',
            'lugar' => 'Plaza sucre',
            'direccion' => 'Los visitantes podrán encontrar una diversidad de modelos de zapatos para niños, adultos e industriales. Los expositores lanzaron varias promociones como descuentos del 30 por ciento para sus productos con calidad de exportación.',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'estado' => 'AC',
            'rub_id' => $rubro4
        ],'fev_id');

        $feriavirtual5 = DB::table('fev_feria_virtual')->insertGetId([
            'version'=> '1',
            'nombre' => 'Primera Feria Virtual de Alimentos, Bebidas y Salud',
            'descripcion' => 'La expansión del coronavirus ha provocado la cancelación o aplazamientos de diversas ferias a nivel nacional e internacional y prácticamente ha parado la industria ferial. ',
            'fecha_inicio' => '2020-12-20',
            'fecha_final' => '2020-12-31',
            'lugar' => 'FEICOBOL',
            'direccion' => 'Calle sucre',
            'latitud' => '-17.392409',
            'longitud' => '-66.159072',
            'estado' => 'AC',
            'rub_id' => $rubro5
        ],'fev_id');*/


    }
}
