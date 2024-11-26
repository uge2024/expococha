<?php
namespace App\Repositories;

use App\Models\Post;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PostRepository
{
    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get all posts.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->post->all();
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->post->all();
        /*return DB::table('pos_post')->get();*/
        /*return DB::table('pos_post')->where([
            ['pos_id','>',1]
        ])->get();*/
    }



    /**
     * Save Post
     *
     * @param $data
     * @return Post
     */
    public function save($data):Post
    {
        $post = new $this->post;

        $post->titulo = $data['titulo'];
        $post->descripcion = $data['descripcion'];
        $post->fecha = $data['fecha'];
        $post->bandera = $data['bandera'];
        $post->valor_a = $data['valor_a'];
        $post->valor_b = $data['valor_b'];
        $post->valor_c = $data['valor_c'];
        $post->valor_d = $data['valor_d'];
        $post->fecha_hora = $data['fecha_hora'];
        $post->save();
        return $post->fresh();
    }

    public function getPaginate($limit)
    {
        return $this->post->paginate($limit);
        //return $this->post->simplePaginate($limit);
    }

    /**
     * funcion que devuelve una lista de valores paginados
     * @param $limit
     * @param $ordenar
     * @return mixed valores de la paginacion
     */
    public function getPaginateWithOrderBy($limit,$ordenar)
    {
        if ($ordenar == 1){
            return $this->post->orderBy('pos_id','desc')->paginate($limit);
        }else{
            return $this->post->orderBy('titulo','desc')->paginate($limit);
        }

        //return $this->post->simplePaginate($limit);
    }

}
