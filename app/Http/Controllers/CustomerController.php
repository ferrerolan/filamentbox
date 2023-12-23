<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        // Recupera todos os clientes
        $customers = Customer::all();

        // Retorna os clientes para a view de index
        return view('customers.index', ['customers' => $customers]);
    }

    public function show($id)
    {
        // Recupera um cliente específico pelo ID
        $customer = Customer::find($id);

        // Verifica se o cliente foi encontrado
        if (!$customer) {
            // Pode redirecionar ou retornar uma resposta de erro
            return redirect()->route('customers.index')->with('error', 'Cliente não encontrado.');
        }

        // Retorna o cliente para a view de show
        return view('customers.show', ['customer' => $customer]);
    }
}
