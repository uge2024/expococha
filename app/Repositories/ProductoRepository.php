<?php


namespace App\Repositories;


use App\Models\Producto;
use App\Models\Productor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductoRepository
{
    protected $producto;
    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    //Guardar solo los datos del producto
    public function save($data):?Producto
    {
        $producto = new $this->producto;
        $producto->nombre_producto = $data['nombre_producto'];
        $producto->nombre_producto = $data['nombre_producto'];
        $producto->existencia = $data['existencia'];
        $producto->puntuacion = 3;
        $producto->descripcion1 = $data['descripcion1'];
        $producto->descripcion2 = $data['descripcion2'];
        $producto->precio = $data['precio'];
        if(isset($data['precio_oferta'])){
            $producto->precio_oferta = $data['precio_oferta'];
        }else{
            $producto->precio_oferta = null;
        }
        if(isset($data['descuento'])){
            $producto->descuento = $data['descuento'];
        }else{
            $producto->descuento = null;
        }
        if(isset($data['fecha_modificacion'])){
            $producto->fecha_modificacion = $data['fecha_modificacion'];
        }else{
            $producto->fecha_modificacion = null;
        }
       if(isset($data['codigo_qr_venta'])){
            $producto->codigo_qr_venta = $data['codigo_qr_venta'];
        }else{
            $producto->codigo_qr_venta = null;
        }
        $producto->existencia_minima = $data['existencia_minima'];
        $producto->fecha_registro = $data['fecha_registro'];
        $producto->estado = $data['estado'];
        $producto->cat_id = $data['cat_id'];
        $producto->pro_id = $data['pro_id'];
        $producto->save();
        return $producto->fresh();
    }

    public function getById($prd_id):?Producto
    {
        $producto = Producto::find($prd_id);
        return $producto;
    }

    public function update($data):?Producto
    {
        $producto = Producto::find($data['prd_id']);
        $producto->nombre_producto = $data['nombre_producto'];
        $producto->existencia = $data['existencia'];
        $producto->descripcion1 = $data['descripcion1'];
        $producto->descripcion2 = $data['descripcion2'];
        $producto->precio = $data['precio'];
        if(isset($data['fecha_modificacion'])){
            $producto->fecha_modificacion = $data['fecha_modificacion'];
        }else{
            $producto->fecha_modificacion = null;
        }
        if(isset($data['codigo_qr_venta'])){
            $producto->codigo_qr_venta = $data['codigo_qr_venta'];
        }
        /*else{
            $producto->codigo_qr_venta = null;
        }*/
        $producto->existencia_minima = $data['existencia_minima'];
        //$producto->fecha_registro = $data['fecha_registro'];
        $producto->estado = $data['estado'];
        $producto->cat_id = $data['cat_id'];
        $producto->pro_id = $data['pro_id'];
        $producto->save();
        return $producto->fresh();

    }

    public function delete($data,$texto):?Producto
    {
        $producto = Producto::find($data['prd_id']);
        if($texto == 'inhabilitar') {
            $producto->estado = 'EL';
            $producto->save();
            return $producto->fresh();
        }
        if($texto == 'habilitar'){
            $producto->estado = 'AC';
            $producto->save();
            return $producto->fresh();
        }

    }

    public function getAllProductoByProductorPaginate($limit,$pro_id)
    {
        return $this->producto->where([
            ['pro_id','=',$pro_id],
            ['estado','=','AC']
        ])->paginate($limit);
    }

    //Agrega una oferta al producto
    public function agregarOferta($data):?Producto
    {
        $producto = Producto::find($data['prd_id']);
        $producto->descuento = $data['descuento'];
        $producto->precio_oferta = $data['precio_oferta'];
        $producto->fecha_inicio_oferta = $data['fecha_inicio_oferta'];
        $producto->fecha_fin_oferta = $data['fecha_fin_oferta'];
        $producto->save();
        return $producto->fresh();
    }

    public function getAllProductosByProductorOrdenados($pro_id)
    {
        return $this->producto->where([
            ['pro_id','=',$pro_id],
            ['estado','=','AC']
        ])->orderBy('nombre_producto','asc')->get();
    }

    public function getAllProductosByProductorOrdenadosQueNoEstenEnUnaFeriaProductor($pro_id,$fpd_id)
    {
        return Producto::where([['pro_id','=',$pro_id],['estado','=','AC']])->whereNotIn('prd_id',
            function ($query)use($fpd_id){
                $query->select('fpr_feria_producto.prd_id')
                    ->from('fpr_feria_producto')
                    ->join('fpd_feria_productor','fpd_feria_productor.fpd_id','=','fpr_feria_producto.fpd_id')
                    ->where([
                        ['fpr_feria_producto.estado','=','AC'],
                        ['fpd_feria_productor.estado','=','AC'],
                        ['fpd_feria_productor.fpd_id','=',$fpd_id]
                    ]);
            }
        )->get();
    }

    //Lista todos los productos existentes
    public function getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        $sortCampo = $sort==1?'prd.nombre_producto':($sort==2?'prd.descripcion1':($sort==3?'prd.existencia':'prd.precio'));
        $where = array();
        $whereRaw = ' true ';// array_push($where, ['use.rol','=',2]);
        if (!empty($search)){
            $campoSearch = $searchtype==1?'prd.nombre_producto':'prd.descripcion1';
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }
        return DB::table('prd_producto as prd')
            ->where($where)
            ->whereRaw($whereRaw)
            ->select('prd.prd_id'
                ,'prd.nombre_producto as nombre_producto'
                ,'prd.descripcion1 as descripcion1'
                ,'prd.existencia as existencia'
                ,'prd.precio as precio')
            ->orderBy($sortCampo,'asc')
            ->groupBy('prd.prd_id')->first()
            ->paginate($limit);
    }

    //lista los productos de un productor con estado AC y EL
    public function getAllPaginateBySearchAndSortACAndEl($limit,$pro_id,$searchtype,$search,$sort)
    {
        $sortCampo = $sort==1?'prd_producto.nombre_producto':($sort==2?'prd_producto.descripcion1':($sort==3?'prd_producto.existencia':'prd_producto.precio'));
        $where = array();
        $whereRaw = ' true ';
       array_push($where, ['prd_producto.pro_id','=',$pro_id]);
        if (!empty($search)){
            $campoSearch = $searchtype==1?'prd_producto.nombre_producto':'prd_producto.descripcion1';
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }
        return $this->producto->where($where)
            ->whereRaw($whereRaw)
            ->orderBy($sortCampo,'asc')
            ->paginate($limit);
    }
    /**
     * Regresa un lista de productos ordenados aletoriamente
     * y con un limite y que no sean nuevos ni en oferta
     * @param $limit
     * @param $dias
     * @return mixed
     */
    public function getProductosRandomByLimit($limit,$dias)
    {
        $fechaActual = date('Y-m-d');
        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $dias days"));
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_registro','<',$fechaDesde]
        ])->whereRaw(" COALESCE(fecha_fin_oferta,'1991-11-11') < '$fechaActual'")
            ->whereHas('productor', function ($query) {
                $query->where('estado_tienda', 'like', 'AC');
            })->limit($limit)->inRandomOrder()->with(['imagenesProducto'])->get();
    }

    /**
     * Regresa un lista de productos en oferta ordenados aletoriamente
     * y con un limite
     * @param $limit
     * @return Colletion
     */
    public function getProductosEnOfertaRamdomByLimit($limit)
    {
        $fechaActual = date('Y-m-d');
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_inicio_oferta','<=',$fechaActual],
            ['fecha_fin_oferta','>=',$fechaActual]
        ])->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->limit($limit)->inRandomOrder()->with(['imagenesProducto'])->get();
    }

    /**
     * regresa una lista de productos nuevos y no en oferta
     * @param $limit
     * @param $dias
     * @return mixed
     */
    public function getProductosNuevosRandomByLimitAndDiasNuevo($limit,$dias)
    {
        $fechaActual = date('Y-m-d');
        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $dias days"));
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_registro','>=',$fechaDesde]
        ])->where(function ($query) use($fechaActual){
            $query->whereRaw(" COALESCE(fecha_inicio_oferta,'1991-11-11') > '$fechaActual'")
                ->orWhereRaw(" COALESCE(fecha_fin_oferta,'1991-11-11') < '$fechaActual'");
        })->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->limit($limit)->inRandomOrder()->with(['imagenesProducto'])->get();
    }

    /**
     * regresa una lista de todos los productos
     * incluidos en oferta y nuevos
     * @param $sort
     * @param $limit
     * @return mixed
     */
    public function getAllProductosBySortAndPaginate($sort,$limit)
    {
        $campoOrdenar = 'nombre_producto';
        $manera = 'asc';
        switch ($sort){
            case 1:
                $campoOrdenar = 'nombre_producto';
                break;
            case 2:
                $campoOrdenar = 'precio';
                break;
            case 3:
                $campoOrdenar = 'puntuacion';
                $manera = 'desc';
                break;
            default:
                $campoOrdenar = 'nombre_producto';
        }
        return $this->producto::where([
            ['estado','=','AC']
        ])->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderby($campoOrdenar,$manera)->with(['imagenesProducto'])->paginate($limit);
    }

    /**
     * regresa una lista paginada de productos en oferta
     * @param $sort
     * @param $limit
     * @return mixed
     */
    public function getAllProductosOfertasBySortAndPaginate($sort,$limit)
    {
        $campoOrdenar = 'nombre_producto';
        $manera = 'asc';
        switch ($sort){
            case 1:
                $campoOrdenar = 'nombre_producto';
                break;
            case 2:
                $campoOrdenar = 'precio';
                break;
            case 3:
                $campoOrdenar = 'puntuacion';
                $manera = 'desc';
                break;
            default:
                $campoOrdenar = 'nombre_producto';
        }
        $fechaActual = date('Y-m-d');
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_inicio_oferta','<=',$fechaActual],
            ['fecha_fin_oferta','>=',$fechaActual]
        ])->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderby($campoOrdenar,$manera)->with(['imagenesProducto'])->paginate($limit);
    }

    /**
     * regresa una lista paginada de productos nuevos en base a dias como parametro
     * para contar
     * @param $sort
     * @param $limit
     * @param $dias
     * @return mixed
     */
    public function getAllProductosNuevosBySortAndPaginate($sort,$limit,$dias)
    {
        $campoOrdenar = 'nombre_producto';
        $manera = 'asc';
        switch ($sort){
            case 1:
                $campoOrdenar = 'nombre_producto';
                break;
            case 2:
                $campoOrdenar = 'precio';
                break;
            case 3:
                $campoOrdenar = 'puntuacion';
                $manera = 'desc';
                break;
            default:
                $campoOrdenar = 'nombre_producto';
        }
        $fechaActual = date('Y-m-d');
        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $dias days"));
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_registro','>=',$fechaDesde]
        ])->where(function ($query) use($fechaActual){
            $query->whereRaw(" COALESCE(fecha_inicio_oferta,'1991-11-11') > '$fechaActual'")
                ->orWhereRaw(" COALESCE(fecha_fin_oferta,'1991-11-11') < '$fechaActual'");
        })->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderby($campoOrdenar,$manera)->with(['imagenesProducto'])->paginate($limit);
    }

    /**
     * regresa una lista paginada de productos de un rubro especifico
     * en base a un orden y limite de paginacion
     * @param $sort
     * @param $limit
     * @param $rub_id
     * @return mixed
     */
    public function getAllProductosByRubroSortAndPaginate($sort,$limit,$rub_id)
    {
        $campoOrdenar = 'nombre_producto';
        switch ($sort){
            case 1:
                $campoOrdenar = 'nombre_producto';
                break;
            case 2:
                $campoOrdenar = 'precio';
                break;
            default:
                $campoOrdenar = 'nombre_producto';
        }
        return $this->producto::where([
            ['estado','=','AC']
        ])->whereHas('categoria', function ($query) use ($rub_id){
            $query->where('rub_id', '=', $rub_id);
        })->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderby($campoOrdenar,'asc')->with(['imagenesProducto'])->paginate($limit);
    }

    /**
     * regresa una lista paginada de productos de una categoria especifica
     * en base a un orden y limite de paginacion
     * @param $sort
     * @param $limit
     * @param $cat_id
     * @return mixed
     */
    public function getAllProductosByCategoriaSortAndPaginate($sort,$limit,$cat_id)
    {
        $campoOrdenar = 'nombre_producto';
        switch ($sort){
            case 1:
                $campoOrdenar = 'nombre_producto';
                break;
            case 2:
                $campoOrdenar = 'precio';
                break;
            default:
                $campoOrdenar = 'nombre_producto';
        }
        return $this->producto::where([
            ['estado','=','AC'],
            ['cat_id','=',$cat_id]
        ])->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderby($campoOrdenar,'asc')->with(['imagenesProducto'])->paginate($limit);
    }

    /**
     * regresa una lista de productos buscados por categoria o todos y ordenados
     * por un indicador y paginado por un limite
     * @param $sort
     * @param $cat_id
     * @param $search
     * @param $limit
     * @return mixed
     */
    public function getAllProductosBySearchAndSortAndPaginate($sort,$cat_id,$search,$limit)
    {
        $campoOrdenar = 'nombre_producto';
        switch ($sort){
            case 1:
                $campoOrdenar = 'nombre_producto';
                break;
            case 2:
                $campoOrdenar = 'precio';
                break;
            default:
                $campoOrdenar = 'nombre_producto';
        }

        $where = array();
        array_push($where,['estado','=','AC']);
        if ($cat_id <> 0){
            array_push($where,['cat_id','=',$cat_id]);
        }
        $whereSearch = ' true ';
        $whereSearchPro = ' true ';
        //Log::info('ssss222 '.mb_strtoupper($search,'UTF-8'));
        if (!empty($search)){
            $whereSearch = "LOWER(nombre_producto) like '%".mb_strtolower($search,'UTF-8')."%'";
            $whereSearchPro = "LOWER(nombre_tienda) like '%".mb_strtolower($search,'UTF-8')."%'";
        }
        //Log::info('ssss222 '.$whereSearch);
        //Log::info('ssss222 '.$whereSearchPro);
        return $this->producto::where(function ($query1) use($where,$whereSearch){
            $query1->where($where)->whereRaw($whereSearch)
                ->whereHas('productor', function ($query) {
                    $query->where('estado_tienda', 'like', 'AC');
                });
        })->orWhere(function ($query2) use($where,$whereSearchPro){
            $query2->where($where)
                ->whereHas('productor', function ($query) use($whereSearchPro){
                $query->where('estado_tienda', 'like', 'AC')->whereRaw($whereSearchPro);
            });
        })->orderby($campoOrdenar,'asc')->with(['imagenesProducto'])->paginate($limit);
    }

    /**
     * regresa una lista de productos relacionados a una categoria
     * yc con un limite
     * @param $limit
     * @param $cat_id
     * @return mixed
     */
    public function getAllProductosRelacionadosByCategoriaSortAndLimit($limit,$cat_id)
    {
        return $this->producto::where([
            ['estado','=','AC'],
            ['cat_id','=',$cat_id]
        ])->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->limit($limit)->inRandomOrder()->with(['imagenesProducto'])->get();
    }

    /**
     * Devulve una lista de productos en oferta para la app
     * @param $inicio
     * @param $limit
     * @return mixed
     */
    public function getProductosEnOfertaByInicioAndLimitAndOrden($inicio,$limit,$orden)
    {
        $fechaActual = date('Y-m-d');
        $campoSort = 'nombre_producto';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
                break;
            case 2://puntuacion
                $campoSort = 'puntuacion';
                $maneraOrden = 'desc';
                break;
            case 3://precio oferta
                $campoSort = 'precio_oferta';
                $maneraOrden = 'asc';
                break;
            default:
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
        }
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_inicio_oferta','<=',$fechaActual],
            ['fecha_fin_oferta','>=',$fechaActual]
        ])->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesProducto'])->skip($inicio)->take($limit)->get();
    }

    /**
     * Devulve una lista de productos nuevos para la app
     * @param $inicio
     * @param $limit
     * @param $dias
     * @return mixed
     */
    public function getProductosNuevosByInicioAndLimitAndDiasNuevoAndOrden($inicio,$limit,$orden,$dias)
    {
        $fechaActual = date('Y-m-d');
        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $dias days"));
        $campoSort = 'nombre_producto';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
                break;
            case 2://puntuacion
                $campoSort = 'puntuacion';
                $maneraOrden = 'desc';
                break;
            case 3://precio
                $campoSort = 'precio';
                $maneraOrden = 'asc';
                break;
            default:
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
        }
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_registro','>=',$fechaDesde]
        ])->where(function ($query) use($fechaActual){
            $query->whereRaw(" COALESCE(fecha_inicio_oferta,'1991-11-11') > '$fechaActual'")
                ->orWhereRaw(" COALESCE(fecha_fin_oferta,'1991-11-11') < '$fechaActual'");
        })->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesProducto'])->skip($inicio)->take($limit)->get();
    }

    /**
     * Devulve una lista de productos no en oferta ni nuevos para la app
     * @param $inicio
     * @param $limit
     * @param $dias
     * @return mixed
     */
    public function getProductosByInicioAndLimitAndOrden($inicio,$limit,$orden,$dias)
    {
        $fechaActual = date('Y-m-d');
        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $dias days"));
        $campoSort = 'nombre_producto';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
                break;
            case 2://puntuacion
                $campoSort = 'puntuacion';
                $maneraOrden = 'desc';
                break;
            case 3://precio
                $campoSort = 'precio';
                $maneraOrden = 'asc';
                break;
            default:
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
        }
        return $this->producto::where([
            ['estado','=','AC'],
            ['fecha_registro','<',$fechaDesde]
        ])->whereRaw(" COALESCE(fecha_fin_oferta,'1991-11-11') < '$fechaActual'")
            ->whereHas('productor', function ($query) {
                $query->where('estado_tienda', 'like', 'AC');
            })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesProducto'])->skip($inicio)->take($limit)->get();
    }

    /**
     * devuelve una lista de productos por categoria para la app
     * @param $cat_id
     * @param $inicio
     * @param $limit
     * @param $orden
     * @param $dias
     * @return mixed
     */
    public function getProductosByCategoriaAndLimitAndOrden($cat_id,$inicio,$limit,$orden)
    {
        $campoSort = 'nombre_producto';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
                break;
            case 2://puntuacion
                $campoSort = 'puntuacion';
                $maneraOrden = 'desc';
                break;
            case 3://precio
                $campoSort = 'precio';
                $maneraOrden = 'asc';
                break;
            default:
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
        }
        return $this->producto::where([
            ['estado','=','AC'],
            ['cat_id','=',$cat_id]
        ])->whereHas('productor', function ($query) {
            $query->where('estado_tienda', 'like', 'AC');
        })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesProducto'])->skip($inicio)->take($limit)->get();
    }

    public function getProductosByRubroAndLimitAndOrden($rub_id,$inicio,$limit,$orden)
    {
        $campoSort = 'nombre_producto';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
                break;
            case 2://puntuacion
                $campoSort = 'puntuacion';
                $maneraOrden = 'desc';
                break;
            case 3://precio
                $campoSort = 'precio';
                $maneraOrden = 'asc';
                break;
            default:
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
        }
        return $this->producto::where([
            ['estado','=','AC']
        ])->whereHas('productor', function ($query) use($rub_id){
            $query->where([
                ['estado_tienda', 'like', 'AC'],
                ['rub_id','=',$rub_id]
            ]);
        })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesProducto'])->skip($inicio)->take($limit)->get();
    }

    /**
     * devuelve una lista de productos por busqueda en su nombre para la app
     * @param $search
     * @param $inicio
     * @param $limit
     * @param $orden
     * @return mixed
     */
    public function getProductosByBuscarAndLimitAndOrden($search,$inicio,$limit,$orden)
    {
        $campoSort = 'nombre_producto';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
                break;
            case 2://puntuacion
                $campoSort = 'puntuacion';
                $maneraOrden = 'desc';
                break;
            case 3://precio
                $campoSort = 'precio';
                $maneraOrden = 'asc';
                break;
            default:
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
        }
        $where = array();
        array_push($where,['estado','=','AC']);
        $whereSearch = ' true ';
        $whereSearchPro = ' true ';
        if (!empty($search)){
            $whereSearch = "UPPER(nombre_producto) like '%".strtoupper($search)."%'";
            $whereSearchPro = "UPPER(nombre_tienda) like '%".strtoupper($search)."%'";
        }

        return $this->producto::where(function ($query1) use($where,$whereSearch){
            $query1->where($where)->whereRaw($whereSearch)
                ->whereHas('productor', function ($query) {
                    $query->where('estado_tienda', 'like', 'AC');
                });
        })->orWhere(function ($query2) use($where,$whereSearchPro){
            $query2->where($where)
                ->whereHas('productor', function ($query) use($whereSearchPro){
                    $query->where('estado_tienda', 'like', 'AC')->whereRaw($whereSearchPro);
                });
        })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesProducto'])->skip($inicio)->take($limit)->get();
    }

}
