<?php
namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        
            $perPage = $request->query('per_page', 10); 
        
            $nome = $request->query('name');
            $minPrice = $request->query('min_price');
            $maxPrice = $request->query('max_price');
        
            $query = Produto::query();
        
           
            if ($nome) {
                $query->where('nome', 'like', '%' . $nome . '%');
            }
        
            if ($minPrice) {
                $query->where('preco', '>=', $minPrice);
            }
            if ($maxPrice) {
                $query->where('preco', '<=', $maxPrice);
            }
        
            $produtos = $query->paginate($perPage);
            
            return response()->json($produtos);
      
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required|numeric',
        ]);

        $produto = Produto::create($request->all());
        return response()->json($produto, 201); 
    }

    public function show(Produto $produto)
    {
        return response()->json($produto);
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required|numeric',
        ]);

        $produto->update($request->all());
        return response()->json($produto);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return response()->json(null, 204); 
    }
}
