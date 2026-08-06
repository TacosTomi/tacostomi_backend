<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Repositories\PlatilloRepository;
use App\Http\Requests\StorePlatilloRequest;
use App\Http\Requests\UpdateplatiloRequest;
use Illuminate\Http\Request;
use App\Models\Platillo;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;


class PlatilloController extends Controller
{
    protected $platilloRepository;
    public function __construct(PlatilloRepository $platilloRepository)
    {
        $this->platilloRepository = $platilloRepository;
    }
    
   public function indexApi(){
       try {
        
        $platillos = $this->platilloRepository->obtenerPlatillos();
       return response()->json([
            'exito' => true,
            'data'  => $platillos
        ], 200);

        } catch (\Exception $e) {
        return response()->json([
        "mensaje"=>$e->getMessage()
        ],500);
        }
   }


    public function create()
    {
        if(auth()->user()->rol_id !== 1) {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }

        $categorias = Categoria::all();

        return view('crear_platillo', compact('categorias'));
    }

    public function store(StorePlatilloRequest $request)
    {
        if(auth()->user()->rol_id !== 1) {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }


        $urlImage = null;

        if($request->hasFile('image'))
        {
            if (!$request->file('image')->isValid()) {
                return back()->withErrors(['image' => 'Requerimientos de imagenes no encontrados: Archivo corrupto al subir.']);
            }

            $path = $request->file('image')->store('platillos', 's3');
            $urlImage = Storage::disk('s3')->url($path);
        }

        Platillo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'=> $request->precio,
            'activo'=> $request->activo,
            'categoria_id'=> $request->categoria_id,
            'imagen_url' => $urlImage
        ]);

        return redirect('/admin')->with('success', 'Usuario creado exitosamente.');;
    }

    public function verPlatillos()
    {
        $platillos = Platillo::where('activo', true)->get();
        return view('ver_platillos', compact('platillos'));
    }

    public function verPlatillosAdmin(Request $request)
    {
        $categorias = Categoria::all();
        $query = Platillo::with('categoria');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }
        if ($request->filled('disponibilidad')) {
            $query->where('activo', $request->disponibilidad);  
        }

        $platillos = $query->get();
        return view('ver_platillosAdmin', compact('platillos', 'categorias'));
    }

    public function vistaModificarPlatillo($id)
    {
        if(auth()->user()->rol_id !==1) {
            abort(403, 'Alto ahi chiavo! Esto es solo para admins VRGS');
        }

        $platillo = Platillo::findOrFail($id);
        $categorias = Categoria::all();

        return view('editar_platillo', compact('platillo', 'categorias'));
    }

    public function modifcarPlatillos(UpdateplatiloRequest $request, $id)
    {
        if(auth()->user()->rol_id !==1) {
            abort(403, 'Alto ahi chiavo! Esto es solo para admins VRGS');
        }


        $platillo = Platillo::findOrFail($id);
        $platillo->nombre = $request->nombre;
        $platillo->descripcion = $request->descripcion;
        $platillo->precio = $request->precio;
        $platillo->activo = $request->activo;
        $platillo->categoria_id = $request->categoria_id;

        if($request->hasFile('image'))
        {
            if (!$request->file('image')->isValid()) {
                return back()->withErrors(['image' => 'Requerimientos de imagenes no encontrados: Archivo corrupto al subir.']);
            }

            $path = $request->file('image')->store('platillos', 's3');
            $platillo->imagen_url = Storage::disk('s3')->url($path);
        }

        $platillo->save();

        return redirect('/platillosAdmin');
    }

    public function eliminarPlatillo($id)
    {
        if(auth()->user()->rol_id !==1) 
        {
            abort(403, 'Alto ahi chiavo! Esto es solo para admins VRGS');
        }

        $platillo = Platillo::findOrFail($id);
        $platillo->delete();

        return redirect('/platillosAdmin');
    }
}