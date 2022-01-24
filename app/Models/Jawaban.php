<?php

namespace App\Models;

use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = "jawaban";
    protected $guarded = [
    ];

    public function getSingleData($id)
    {
        return Jawaban::select([
            'jawaban.*',
            \DB::raw('DATE_FORMAT(jawaban.created_at, "%d-%b-%Y")  as tgl'),
        ])
        ->where('id', $id)->first();
    }

    public function getSingleDataWithId($id, $user_id)
    {
        return Jawaban::select([
            'jawaban.*',
            \DB::raw('DATE_FORMAT(jawaban.created_at, "%d-%b-%Y")  as tgl'),
        ])
        ->where('id_pertanyaan', $id)
        ->where('user_id', $user_id)->first();
    }

    public function getDataByUserId($user_id)
    {
        return Jawaban::select([
            'jawaban.*',
            \DB::raw('DATE_FORMAT(jawaban.created_at, "%d-%b-%Y")  as tgl'),
        ])
        ->where('user_id', $user_id)->get();
    }

    public function jawaban_materi()
    {
        return $this->belongsTo(Materi::class, 'id','id_pertanyaan');
    }

}
