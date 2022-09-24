<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificacaoFiscal extends Model
{
    use HasFactory;
    protected $fillable = [
        'Codigo',
        'Descricao',
        'Data_Inicio',
        'Data_Fim',
        'Tipo_Ato',
        'Numero_Ato',
        'Ano_Ato',
    ];
}
