<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoVendas extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantidade',
        'produto',
        'venda',
        'valorProduto',
        'nomeProduto',
    ];
}
