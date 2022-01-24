<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jawaban;

class Materi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = "materi";
    protected $guarded = [
    ];

    public function getSingleData($id)
    {
        return Materi::select([
            'materi.id',
            'materi.judul_tema',
            'materi.link',
            'materi.tema',
            'materi.teks_materi',
            \DB::raw('DATE_FORMAT(materi.created_at, "%d-%b-%Y")  as tgl'),
        ])
        ->where('id', $id)->first();
    }

    public function getAllDataByTema($id, $user_id)
    {
        return Materi::with(['jawaban' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }
        ])
        ->where('tema', $id)->get();
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_pertanyaan','id');
    }
}
