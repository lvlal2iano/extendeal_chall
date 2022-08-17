<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use App\Models\Sala;
use App\Models\Pais;
use Carbon\Carbon;

class Cuadro extends Model
{
    use HasFactory;
    use PowerJoins;

    protected $fillable = ['autor', 'nombre', 'anio_creacion', 'precio','alto','ancho','img_url', 'sala_id', 'pais_procedencia_id'];

    public function id(){
        return $this->id;
    }

    public function sala(){
        return $this->belongsTo(Sala::class);
    }

    public function procedencia(){
        return $this->belongsTo(Pais::class, 'pais_procedencia_id');
    }

    //Scoopes

    public function scopeAutor($query,$autor){
        return $query->where($this->table.'.autor','LIKE','%'.$autor.'%');
    }

    public function scopeMaxPrecio($query,$precio){
        return $query->where($this->table.'.precio','<=',$precio);
    }

    public function scopeMinPrecio($query,$precio){
        return $query->where($this->table.'.precio','>=',$precio);
    }

    public function scopeMaxAlto($query,$alto){
        return $query->where($this->table.'.alto','<=',$alto);
    }

    public function scopeMinAlto($query,$alto){
        return $query->where($this->table.'.alto','>=',$alto);
    }

    public function scopeMaxAncho($query,$ancho){
        return $query->where($this->table.'.ancho','<=',$ancho);
    }

    public function scopeMinAncho($query,$ancho){
        return $query->where($this->table.'.ancho','>=',$ancho);
    }

    public function scopeMaxCreacion($query,$anio){
        return $query->whereDate($this->table.'.anio_creacion','<=',Carbon::parse($anio));
    }

    public function scopeMinCreacion($query,$anio){
        return $query->whereDate($this->table.'.anio_creacion','>=',Carbon::parse($anio));
    }

    public function scopeSala($query,$sala_id){
        return $query->whereHas('sala', function($query) use($sala_id){
            $query->where('id', $sala_id);
        });
    }

    public function scopeProcedencia($query,$code){
        return $query->whereHas('procedencia', function($query) use($code){
            $query->where('code', $code);
        });
    }
}
