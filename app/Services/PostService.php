<?php


namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PostService
{
    protected $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Get all post.
     *
     * @return String
     */
    public function getAll()
    {
        //return $this->postRepository->getAll();
        return $this->postRepository->getPosts();
    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return Post
     * @throws Exception
     */
    public function savePostData($data)
    {
        $messages = [
            'required' => 'El campo :attribute es requerido.',
            'descripcion.required' => 'El campo descripcion dos es requerido',
        ];

        $validator = Validator::make($data, [
            'titulo' => 'required',
            'descripcion' => 'required'
        ],$messages);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->postRepository->save($data);
        if (empty($result)){
            throw new Exception("Error en la DB");
        }

        return $result;
    }

    public function savePostData2($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $result = $this->postRepository->save($data);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getPaginate($limit)
    {
        return $this->postRepository->getPaginate($limit);
    }

    public function getPaginateWithOrderBy($limit,$ordenar)
    {
        return $this->postRepository->getPaginateWithOrderBy($limit,$ordenar);
    }

}
